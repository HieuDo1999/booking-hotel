<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceAvailability extends Model
{
    protected $table = 'space_availability';

    protected $fillable = ['post_id', 'check_in', 'check_out', 'price', 'booked', 'status', 'is_base'];
}
