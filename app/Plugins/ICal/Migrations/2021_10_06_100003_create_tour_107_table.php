<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTour107Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tour', function (Blueprint $table) {
            if (!Schema::hasColumn("tour", 'ical')) {
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
        Schema::table('tour', function (Blueprint $table) {
            $table->dropColumn([
                'ical'
            ]);
        });
	}
}
