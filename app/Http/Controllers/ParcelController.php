<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use Illuminate\Support\Str;
use App\Models\ParcelItem;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ParcelRequest;

class ParcelController extends Controller
{
    public function parcel(Request $request)
    {
        return view('parcel.new');
    }

    public function submit(ParcelRequest $request, Parcel $parcel)
    {
        $save_request = $parcel->create([
            'uuid' => Str::uuid(),
            'sender_name' => $request->sender_fullname,
            'sender_email' => $request->sender_email,
            'sender_phone' => $request->sender_phone,
            'sender_address' => $request->sender_address,
            'receiver_name' => $request->receiver_fullname,
            'receiver_phone' => $request->receiver_phone,
            'receiver_address' => $request->receiver_address,
            'price' => $request->price,
            'distance' => $request->distance,
            'payment_type' => $request->payment_type,
        ]);
        if ( $save_request ){

            foreach( $request->items as $key => $item ){
                $save_request->items()->create([
                    'description'   => $item['description'],
                    'weight'        => $item['weight'],
                    'quantity'      => $item['quantity'],
                ]);
            }

            $user = ($request->user()) ?  $request->user()->id : false;
            if ( $user ){
                $save_request->user_id = $user;
                $save_request->save();
            }

            if ( $save_request->payment_type === 'online' ){
                // Process callback to PayStack
            }

            return response()->json([ 'parcel' => $save_request, 'payment_type' => $save_request->payment_type ], 200);
        }
    }

    public function payment(Request $request, Parcel $parcel)
    {
        if ( $request->status === 'success' ){
            $payment = $parcel->payment()->create([
                            'transaction_ref'   => $request->reference,
                            'status'            => $request->status,
                            'amount'            => $parcel->price,
                        ]);
            if ( $payment ){
                return response()->json(true, 200);
            } else {
                return response()->json(false, 400);
            }
        }
    }

    public function thank_you(Request $request, Parcel $parcel)
    {
        if ( $parcel ){
            return view('parcel.thank_you')->with(['parcel'=>$parcel]);
        } else {
            return redirect('/');
        }
    }

    public function details(Request $request, Parcel $parcel)
    {
        return view('parcel.detail')->with(['parcel' => $parcel]);
    }

    public function requestPickup(Request $request, Parcel $parcel)
    {
        if ( $request->isMethod('get') ){
            return view('parcel.request-pickup');
        }
    }
}
