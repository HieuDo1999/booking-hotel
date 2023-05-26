<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
   protected $table = 'withdrawal';

   protected $fillable = [
      'user_id','withdraw','status'
   ];
}
