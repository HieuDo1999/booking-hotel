<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentRelation104nTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      if (Schema::hasTable('agent_relation')) {
         $this->down();
      }
      Schema::create('agent_relation', function (Blueprint $table) {
         $table->bigIncrements('id');
         $table->foreignId('agent_id')->constrained('agent')->onDelete('cascade');
         $table->bigInteger('post_id');
         $table->string('post_type', 50)->nullable();
         $table->timestamps();
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::drop('agent_relation');
   }
}
