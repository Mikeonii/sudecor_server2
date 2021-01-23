<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
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
}
