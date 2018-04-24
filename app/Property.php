<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name', 'address', 'city', 'state', 'zipcode'];
}
