<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('test_sections', function (Blueprint $table) {
            $table->foreign(['test_subject_id'], 'test_subject_id')->references(['id'])->on('test_subjects')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_sections', function (Blueprint $table) {
            $table->dropForeign('test_subject_id');
        });
    }
};
