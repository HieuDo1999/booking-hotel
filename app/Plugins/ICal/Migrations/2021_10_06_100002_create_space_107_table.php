<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpace107Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('space', function (Blueprint $table) {
            if (!Schema::hasColumn("space", 'ical')) {
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
        Schema::table('space', function (Blueprint $table) {
            $table->dropColumn([
                'ical'
            ]);
        });
	}
}
