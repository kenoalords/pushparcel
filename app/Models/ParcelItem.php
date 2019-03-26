<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParcelItem extends Model
{
    protected $fillable = ['parcel_id', 'description', 'quantity', 'weight'];

    public function parcel()
    {
        return $this->belongsTo(Parcel::class);
    }
}
