<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneLead;

class PhoneLeadController extends Controller
{
    public function lead(Request $request, PhoneLead $lead)
    {
    	if ( $request->isMethod('post') ){
    		$this->validate($request, [ 'phone_number' => 'required', 'name' => 'required' ]);

    		$phone_check = $lead->where('phone_number', $request->phone_number)->first();
    		if ( !$phone_check ){
    			$geoip = geoip($request->ip());
	    		$add_lead = $lead->create([
	    			'state' => $geoip->state_name,
	    			'city'	=> $geoip->city,
	    			'ip'	           => $geoip->ip,
                    'phone_number'  => $request->phone_number,
	    			'name'	         => $request->name,
	    		]);
	    		return response()->json(["status" => true, "message" => 'SAVED']);
    		} else {
    			return response()->json(["status" => true, "message" => 'DUPLICATE']);
    		}   		
    	} else {
    		return response()->json(["status" => false, "message" => 'INVALID_METHOD']);
    	}
    }
}
