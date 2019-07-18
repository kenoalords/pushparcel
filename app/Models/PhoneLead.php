<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneLead extends Model
{
    protected $fillable = ['phone_number', 'name', 'ip', 'city', 'state'];
}
