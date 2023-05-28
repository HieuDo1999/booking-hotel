<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePost108Table extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('post', function (Blueprint $table) {
            if (!Schema::hasColumn("post", 'deleted_at')) {
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
        Schema::table('post', function (Blueprint $table) {
            $table->dropColumn([
                'deleted_at'
            ]);
        });
	}
}
