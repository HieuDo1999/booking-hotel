<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomAvailability107Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('room_availability', function (Blueprint $table) {
            if (!Schema::hasColumn("room_availability", 'is_base')) {
                $table->integer('is_base')->default(0);
            }
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('room_availability', function (Blueprint $table) {
            $table->dropColumn([
                'is_base'
            ]);
        });
	}
}
