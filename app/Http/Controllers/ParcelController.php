<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\Notifiable;
use App\Models\Parcel;
use Illuminate\Support\Str;
use App\Models\ParcelItem;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\ParcelRequest;
use App\Notifications\SmsNotification;
use GuzzleHttp;
use App\Mail\ParcelRequestMail;
use Mail;

class ParcelController extends Controller
{
    use Notifiable;

    public function parcel(Request $request)
    {
        return view('parcel.new');
    }

    public function submit(ParcelRequest $request, Parcel $parcel)
    {

        // Ping Google DistanceMatrix for correct payment details
        // Delivery distance KM
        $api = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . urlencode($request->sender_address)  . '&destinations=' . urlencode($request->receiver_address) . '|' . urlencode(config('app.office_address')) . '&key=' . config('app.google_maps_key') . '&units=metric';


        $client = new GuzzleHttp\Client;
        $result = $client->get($api);
        $distance = json_decode ( $result->getBody() );

        if ( $distance->status === 'OK' ){
            $elements = $distance->rows[0]->elements;
            $delivery = ceil($elements[0]->distance->value / 1000);
            $pickup = ceil($elements[1]->distance->value / 1000);

            $deliveryCost = ( $delivery > 15  )
                                ? ($delivery * env('COST_PER_KILOMETER_LONG')) + env('BASE_PRICE')
                                : ($delivery * env('COST_PER_KILOMETER_SHORT')) + env('BASE_PRICE');
            $pickupCost = env('PICKUP_COST_PER_KM') * $pickup;
            $total = $deliveryCost + $pickupCost;

            $save_request = $parcel->create([
                'uuid' => Str::uuid(),
                'sender_name' => $request->sender_fullname,
                'sender_email' => $request->sender_email,
                'sender_phone' => $request->sender_phone,
                'sender_address' => $request->sender_address,
                'receiver_name' => $request->receiver_fullname,
                'receiver_phone' => $request->receiver_phone,
                'receiver_address' => $request->receiver_address,
                'price' => $total,
                'distance' => $request->distance,
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


                $phone = preg_replace("/\s/", '', $request->sender_phone);
                $phone_number = preg_replace("/^0/", '+234', $phone);
                $message = "Hello {$request->sender_name}, Thank you for requesting our dispatch service. We will get in touch with you shortly";
                Mail::to($request->sender_email)->send(new ParcelRequestMail($save_request));
                // $save_request->notify(new SmsNotification($phone_number, $message));
                return response()->json([ 'parcel' => $save_request, 'payment_type' => $save_request->payment_type ], 200);
            }

        }


    }

    public function checkout(Request $request, Parcel $parcel)
    {
        if ( $request->isMethod('get') ){
            if ( $parcel->is_paid === 1 ){
                return redirect()->route('thank_you', ['parcel'=>$parcel]);
            }
            if ( $request->query('trxref') || $request->query('reference') ){
                $client = new GuzzleHttp\Client;
                $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($request->query('reference'));
                $verify = $client->get($url, [
                    'headers'   => [
                        'authorization' => 'Bearer ' . config('app.paystack_key'),
                        'cache-control' => 'no-cache',
                    ]
                ]);
                $result = json_decode( $verify->getBody() );
                // dd($result);

                if ( $result->status === true ){
                    $payment = $parcel->payment()->create([
                                    'parcel_id'         => $parcel->id,
                                    'transaction_ref'   => $result->data->reference,
                                    'amount'            => $result->data->amount / 100,
                                    'status'            => $result->data->status,
                                    'channel'           => $result->data->channel,
                                    'ip_address'        => $result->data->ip_address,
                                ]);

                    if ( $payment ) {
                        $parcel->is_paid = true;
                        $parcel->payment_type = 'online';
                        $parcel->save();
                        return redirect()->route('thank_you', ['parcel'=>$parcel]);
                    } else {

                        return redirect()->route('thank_you', ['parcel'=>$parcel]);
                    }
                } else {
                    return redirect()->route('parcel_checkout', ['parcel'=>$parcel, 'notify'=> 'We couldn\'t verify your transaction, please call us on ' . config('app.contact_number') . ' for verification.' ]);
                }
            } else {
                return view('parcel.checkout')->with([ 'parcel' => $parcel ]);
            }
        }

        if ( $request->isMethod('post') ){
            $this->validate($request, [
                'payment_type'  => 'required|in:online,pop',
            ]);

            if ( $request->payment_type === 'pop' ){
                $parcel->payment_type = $request->payment_type;
                $parcel->save();
                return redirect()->route('thank_you', [$parcel]);
            }

            if ( $request->payment_type === 'online' ){
                $email = $parcel->sender_email;
                $amount = $parcel->price;
                $paystack_url = config('app.paystack_url');
                $client = new GuzzleHttp\Client;

                $post = $client->request("POST", $paystack_url, [
                            'form_params' => [
                                'email'     => $email,
                                'amount'    => $amount * 100,
                                'callback_url'  => $request->url(),
                                'metadata'  => [
                                    'parcel_id' => $parcel->uuid,
                                ],
                            ],
                            'headers'   => [
                                'authorization' => 'Bearer ' . config('app.paystack_key'),
                                'cache-control' => 'no-cache',
                            ]
                        ]);
                $payload = json_decode( $post->getBody() );
                if ( $payload->status === true ){
                    return redirect($payload->data->authorization_url);
                }
            }
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
