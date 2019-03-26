<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biker extends Model
{
    protected $fillable = ['fullname', 'address', 'age', 'bike', 'phone'];

    public function bike()
    {
        return $this->hasOne(Bike::class);
    }
}
