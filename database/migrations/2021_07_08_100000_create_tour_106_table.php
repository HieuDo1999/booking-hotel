<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTour106Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tour', function (Blueprint $table) {
            if (!Schema::hasColumn("tour", 'post_description')) {
                $table->text('post_description')->nullable();
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
                'post_description'
            ]);
        });
	}
}
