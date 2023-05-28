<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoom107Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('room', function (Blueprint $table) {
            if (!Schema::hasColumn("room", 'ical')) {
                $table->text('ical')->nullable();
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
        Schema::table('room', function (Blueprint $table) {
            $table->dropColumn([
                'ical'
            ]);
        });
	}
}
