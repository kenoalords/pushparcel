<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['parcel_id', 'transaction_ref', 'amount', 'status', 'channel', 'ip_address'];
}
