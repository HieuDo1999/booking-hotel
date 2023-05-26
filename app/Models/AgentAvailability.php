<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentAvailability extends Model
{
    protected $table = 'agent_availability';

    protected $fillable = ['post_id', 'check_in', 'check_out', 'status', 'post_type', 'order_id'];
}
