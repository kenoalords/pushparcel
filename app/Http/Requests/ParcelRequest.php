<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParcelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_fullname'  => 'required',
            'sender_email'     => 'required|email',
            'sender_phone'     => 'required',
            'sender_address'   => 'required',
            'receiver_fullname'=> 'required',
            'receiver_phone'   => 'required',
            'receiver_address' => 'required',
            'price'            => 'required',
            'distance'         => 'required',
        ];
    }
}
