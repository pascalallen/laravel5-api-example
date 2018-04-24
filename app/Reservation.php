<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone_number', 'start_date', 'end_date', 'property_id'];
}
