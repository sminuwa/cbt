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
        Schema::create('exams_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id');
            $table->date('date');
            $table->timestamps();

            $table->unique(['test_id', 'date'], 'test_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams_dates');
    }
};
