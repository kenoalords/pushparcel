<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Career extends Model
{
    protected $fillable = ['title', 'description', 'metadescription', 'slug', 'expires', 'status'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getExpiresAttribute($date)
    {
        return Carbon::parse($date);
    }
}
