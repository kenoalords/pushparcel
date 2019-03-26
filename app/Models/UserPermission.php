<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    protected $fillable = ['is_admin', 'is_biker', 'is_customer'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
