<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = ['make', 'model', 'condition', 'licence'];

    public function biker()
    {
        return $this->hasOne(Biker::class);
    }
}
