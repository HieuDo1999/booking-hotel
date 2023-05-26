<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarAvailability extends Model
{
    protected $table = 'car_availability';

    protected $fillable = ['post_id', 'check_in', 'check_out', 'number', 'price', 'booked', 'status', 'is_base'];
}
