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
        Schema::create('time_controls', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('test_id');
            $table->integer('candidate_id')->index('candidate_id');
            $table->boolean('completed')->default(false)->comment('keep track if the student has completed orr not');
            $table->time('start_time');
            $table->time('curent_time');
            $table->integer('elapsed')->comment('keep the total number of second elapsed');
            $table->string('ip', 20);
            $table->timestamps();

            $table->primary(['test_id', 'candidate_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('time_controls');
    }
};
