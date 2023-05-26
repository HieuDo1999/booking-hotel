<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentRelation extends Model
{
   protected $table = 'agent_relation';

   protected $fillable = [
      'id',
      'agent_id',
      'post_id',
      'post_type',
   ];


}
