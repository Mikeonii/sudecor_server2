<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
class HolidaysController extends Controller
{
    public function insert_holiday(Request $request)
    {
    	$holiday = $request->isMethod('put') ? Holiday::where('date',$request->input('date'))->firstOrFail() : new Holiday;
    	$holiday->holiday_name = $request->input('holiday_name');
    	$holiday->date = $request->input('date');
    	if($holiday->save()){
    		return "Successfuly saved!";
    	}
    	else{
    		return "Something is wrong";
    	}
    }
}
