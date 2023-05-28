<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTour108Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('tour', function (Blueprint $table) {
            if (!Schema::hasColumn("tour", 'deleted_at')) {
                $table->softDeletes();
            }
            if (!Schema::hasColumn("tour", 'package_start_date')) {
                $table->string('package_start_date')->nullable();
            }
            if (!Schema::hasColumn("tour", 'package_end_date')) {
                $table->string('package_end_date')->nullable();
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
                'deleted_at',
                'package_start_date',
                'package_end_date'
            ]);
        });
	}
}
