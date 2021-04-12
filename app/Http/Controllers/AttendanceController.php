<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Client;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use DB;

// 2021-01-23 12:12:11

class AttendanceController extends Controller
{

    public function attendances(){
        $attendances = DB::table('clients')->join('attendances',function($join){
            $join->on('clients.id','=','attendances.client_id');
        })->get();
        // $attendances = Attendance::all();
        return $attendances;
    }
    public function insert_attendance(Request $request){
    	$is_in = $request->input('is_in');
    	$client = Client::where('card_number',$request->input('card_number'))->first();
        if(!$client){
            return "0";
        }
    	$date_today = Carbon::now()->format('Y-m-d H:i:s');
    	$default_time_out = '2020-01-01 00:00:00';
 		// if is_in create new row
 		if($is_in){
 			// check if exist
 			$exist = Attendance::select('time_in')->where('client_id',$client->id)->whereDate('time_in',Carbon::now()->format('Y-m-d'))->exists();
 			if($exist){
 				return "you already logged in today";
 			}
 			$new = new Attendance;
 			$new->client_id = $client->id;
 			$new->time_in = $date_today;
 			$new->time_out = $default_time_out;

 			if($new->save()){
 				 $result = collect([
                'name'=>$new->client->name,
                'time_in'=>$new->time_in,   
                'time_out'=>'None',
                ]);
                return $result;
 			}
 			else{
 				return "error";
 			};
 		}

 		// find and insert time out
 		else{

 			// check if exist
 			$exist = Attendance::
            where('client_id',$client->id)
            ->whereDate('time_out','<=',Carbon::now()->format('Y-m-d H:i:s'))
            ->whereDate('time_out','>',Carbon::now()->subHours(1)->format('Y-m-d H:i:s'))
            ->exists();
    
 			if($exist){
 				return "you already logged out today";
 			}
 			$date_today = Carbon::parse($date_today);
 			$attendance_row = Attendance::select('time_in','id')->whereDate('time_in',$date_today->toDateString())->where('client_id',$client->id)->first();

 			// if attendance_row does not exist 
 			if($attendance_row == null){
 				// check for yesterday's attendance row
 				$attendance_row = Attendance::select('time_in','id')->whereDate('time_in',Carbon::yesterday()->toDateString())->where('client_id',$client->id)->whereDate('time_out',$default_time_out)->first();
 				if($attendance_row == null){
 					// tell the user to check whether he is trying to log in or out
 					return "Are you trying to log in?";
 				}
 			}
 	
 			$time_in = Carbon::parse($attendance_row->time_in);
 			// arr is array ['reg_time','over_time']
 			$col = $this->get_hour($time_in,$date_today);
 			$sun = $this->cal_sunday($time_in,$date_today);
 			$hol = $this->cal_holiday($time_in,$date_today);
            $np = $this->cal_night_premium($time_in,$date_today);
           
            $over_time = null;
            $regular_hour = null;

            // if today is holiday or sunday, insert 0 to regular hour
            if($sun['sun_hour'] > 0 || $hol['hol_hour'] > 0){
                $regular_hour = 0;
                // get overtime
                if($sun['over_time'] > 0){
                    $over_time = $sun['over_time'];
                }
                elseif($hol['over_time'] > 0){
                    $over_time = $hol['over_time'];
                }
                else{
                    $over_time = 0;
                }
            }
            else{
                $regular_hour = $col['reg_hour'];
                $over_time = $col['over_time'];
            }

            // // insert to row
            $attendance_row = Attendance::findOrFail($attendance_row->id);
            $attendance_row->time_out = $date_today->format('Y-m-d H:i:s');

            $attendance_row->regular_hour = $regular_hour;
 			$attendance_row->over_time = $over_time;
 			$attendance_row->sunday = $sun['sun_hour'];
 			$attendance_row->holiday = $hol['hol_hour'];
            $attendance_row->night_premium = $np;
 			
            try{
                $attendance_row->save();
                $result = collect([
                'name'=>$attendance_row->client->name,
                'time_in'=>$attendance_row->time_in,
                'time_out'=>$attendance_row->time_out,
                ]);
                return $result;
            }
            catch(Exception $e){
                return  $e->getMessage();
            }
 			
 		 }
    }

    // calculate regular hour
    public function get_hour($time_in, $time_out){

    	$reg_hour = $time_out->diff($time_in)->format('%h');
    	$complete_hour = 8;
    	// if reg hour exceeds 8 hours, set reg hour to 8 and add the remaining to overtime
    	if($reg_hour > $complete_hour){
            $over_time = $reg_hour-$complete_hour;
            $reg_hour = $complete_hour;
    	}
    	else{
    		$over_time = 0;
    	}
    	// return an array of 2
    	$col = collect(['reg_hour'=>$reg_hour,'over_time'=>$over_time]);
    	return $col;
    }
    // calculate holiday
    public function cal_holiday($time_in,$time_out){
    	// check if today is holiday
    	if($check = Holiday::select('id')->whereMonth('date',$time_in->month)->whereDay('date',$time_in->day)->exists())
    	{
    		$complete_hour = 8;
            $hol_hour = $time_out->diff($time_in)->format('%h');

            if($hol_hour > $complete_hour){
                $over_time = $hol_hour-$complete_hour;
                $hol_hour = $complete_hour;
            }
            else{
                $over_time = 0;
            }
            $col = collect(['hol_hour'=>$hol_hour,'over_time'=>$over_time]);
    	}
        else{
            $col = collect(['hol_hour'=>'0','over_time'=>'0']);
        }
        return $col;
    }
    // calculate sunday
    public function cal_sunday($time_in,$time_out){
        if($time_in->dayOfWeekIso == 7){
            $complete_hour = 8;
            $sun_hour = $time_out->diff($time_in)->format('%h');

            if($sun_hour > $complete_hour){
                $over_time = $sun_hour-$complete_hour;
                $sun_hour = $complete_hour;
            }
            else{
                $over_time = 0;
            }
            $col = collect(['sun_hour'=>$sun_hour,'over_time'=>$over_time]);
        }
        else{
            $col = collect(['sun_hour'=>'0','over_time'=>'0']);
        }
         return $col;
    }
    // calculate night premium
    public function cal_night_premium($time_in,$time_out){

            // start counting for NP
            // return $time_out->diff($time_in)->format('%h:%i:%s');
            $time_in = $time_in->format('Y-m-d')." 23:00:00";

            return $time_out->diff($time_in)->format('%h:%i');
            // echo $time_out->diff($time_in)->format('%h');
        
    }
}
