<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotel108Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('hotel', function (Blueprint $table) {
            if (!Schema::hasColumn("hotel", 'deleted_at')) {
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
        Schema::table('hotel', function (Blueprint $table) {
            $table->dropColumn([
                'deleted_at'
            ]);
        });
	}
}
