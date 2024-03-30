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
        Schema::table('exams_dates', function (Blueprint $table) {
            $table->foreign(['test_id'], 'exams_dates_ibfk_1')->references(['id'])->on('test_configs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams_dates', function (Blueprint $table) {
            $table->dropForeign('exams_dates_ibfk_1');
        });
    }
};
