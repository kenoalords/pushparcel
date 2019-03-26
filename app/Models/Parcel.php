<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parcel extends Model
{
    use SoftDeletes;

    protected $guarded = ['status'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ParcelItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
