<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentAvailability extends Model
{
    protected $table = 'apartment_availability';

    protected $fillable = ['post_id', 'check_in', 'check_out', 'price', 'booked', 'status', 'is_base'];
}
