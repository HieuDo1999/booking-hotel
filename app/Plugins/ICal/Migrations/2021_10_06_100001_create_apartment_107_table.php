<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartment107Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('apartment', function (Blueprint $table) {
            if (!Schema::hasColumn("apartment", 'ical')) {
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
        Schema::table('apartment', function (Blueprint $table) {
            $table->dropColumn([
                'ical'
            ]);
        });
	}
}
