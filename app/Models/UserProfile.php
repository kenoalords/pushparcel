<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = ['first_name', 'last_name', 'phone'];

    public function fullname()
    {
        return "$this->first_name $this->last_name";
    }
}
