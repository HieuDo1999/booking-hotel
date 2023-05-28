<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCar108Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('car', function (Blueprint $table) {
            if (!Schema::hasColumn("car", 'deleted_at')) {
                $table->softDeletes();
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
        Schema::table('car', function (Blueprint $table) {
            $table->dropColumn([
                'deleted_at'
            ]);
        });
	}
}
