<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
class HolidaysController extends Controller
{
    public function add_holiday(Request $request)
    {
    	$holiday = $request->isMethod('put') ? Holiday::where('id',$request->input('id'))->firstOrFail() : new Holiday;
    	$holiday->holiday_name = $request->input('holiday_name');
    	$holiday->date = $request->input('date');
        $holiday->type = $request->input('type');
        try{
            $holiday->save();
            return $holiday;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function index(){
        return Holiday::all();
    }
}
