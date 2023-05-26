<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeauty106Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beauty', function (Blueprint $table) {
            if (!Schema::hasColumn("beauty", 'external_booking')) {
                $table->string('external_booking', 3)->nullable()->default('off');
            }
            if (!Schema::hasColumn("beauty", 'external_link')) {
                $table->string('external_link')->nullable();
            }
            if (!Schema::hasColumn("beauty", 'post_description')) {
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
        Schema::table('beauty', function (Blueprint $table) {
            $table->dropColumn([
                'external_booking',
                'external_link',
                'post_description'
            ]);
        });
    }
}
