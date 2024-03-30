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
        Schema::create('schedulings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('test_id')->nullable()->index('test_id');
            $table->integer('venue_id')->nullable()->index('venue_id');
            $table->date('date')->nullable();
            $table->integer('maximum_batch')->default(-1);
            $table->integer('no_per_schedule')->nullable();
            $table->time('daily_start_time')->nullable();
            $table->time('daily_end_time')->nullable();
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
        Schema::dropIfExists('schedulings');
    }
};
