<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Attendance;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class ClientsController extends Controller
{
    public function insert_client(Request $request){
    	
		$client = $request->isMethod('put') ? Client::where('card_number',$request->input('card_number'))->firstOrFail() : new Client;

		$client->name = $request->input('name');
		$client->card_number =  $request->input('card_number');
		if($client->save()){
			return "saved successfuly!";
			}
		else{
			return "something went wrong";
		}
    		
    }
    public function get_client($year,$month,$half){
    	// get clients 
    	$clients = Client::get();
    	$full_info = array();

    	foreach($clients as $client){
	    		// first half
    		$info = array();
	    	if($half == '1'){
	    		$day_first = 1;
	    		$day_second = 26;
	    		$date_first = $year.'-'.$month.'-'.$day_first;
	    		$date_second = $year.'-'.$month.'-'.$day_second;

	    		$attendances = Attendance::whereBetween('time_in',[$date_first,$date_second])
	    		->where('client_id',$client->id)->orderBy('time_in','ASC')->get();

	    		$regular_hour = Attendance::whereBetween('time_in',[$date_first,$date_second])->where('client_id',$client->id)->sum('regular_hour');
	    		$over_time = Attendance::whereBetween('time_in',[$date_first,$date_second])->where('client_id',$client->id)->sum('over_time');
	    		$sunday = Attendance::whereBetween('time_in',[$date_first,$date_second])->where('client_id',$client->id)->sum('sunday');
	    		$holiday = Attendance::whereBetween('time_in',[$date_first,$date_second])->where('client_id',$client->id)->sum('holiday');
	    		$query_info = $date_first." to: ".$date_second;
	    		$totals = Collect([$regular_hour,$over_time,$sunday,$holiday]);
	    		$client_totals = Collect([$client,$attendances,$totals]);
	    		array_push($info, $client_totals);
	    	}
    		array_push($full_info,$info);
    	}
    	// return $full_info;
    	// return view('print.print_to_excel',compact('full_info','query_info'));
    	return Excel::download(new AttendanceExport($full_info,$query_info), 'attendance.xlsx');
    	
    }
}
