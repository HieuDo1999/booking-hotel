<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('term', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->text('term_title');
			$table->string('term_name');
			$table->longText('term_description')->nullable();
			$table->string('term_icon')->nullable();
			$table->string('term_image')->nullable();
			$table->string('term_price')->nullable();
            $table->foreignId('taxonomy_id')->constrained('taxonomy')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('term');
	}
}
