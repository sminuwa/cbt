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
        Schema::create('test_configs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->enum('test_category', ['Single Subject', 'Multi-Subject']);
            $table->float('total_mark');
            $table->integer('test_code_id')->nullable()->index('test_code_id');
            $table->integer('test_type_id')->nullable()->index('test_type_id');
            $table->integer('session');
            $table->integer('semester')->nullable();
            $table->time('daily_start_time')->nullable();
            $table->time('daily_end_time')->nullable();
            $table->integer('duration')->nullable();
            $table->enum('starting_mode', ['on login', 'on starttime'])->nullable()->default('on login');
            $table->enum('display_mode', ['All', 'single question'])->nullable()->default('All');
            $table->enum('question_administration', ['random', 'linear'])->nullable()->default('random');
            $table->enum('option_administration', ['random', 'linear'])->nullable()->default('random');
            $table->unsignedInteger('versions')->default(1)->comment('indicates the number of version of every subject registered in the test');
            $table->integer('active_version')->nullable()->default(1);
            $table->integer('initiated_by')->index('initiated_by')->comment('The user that initiated the test');
            $table->date('date_initiated');
            $table->boolean('status')->unsigned()->default(false);
            $table->enum('endorsement', ['no', 'yes'])->default('no');
            $table->string('pass_key', 6)->default('cbt');
            $table->integer('time_padding')->default(0);
            $table->boolean('allow_calc')->default(false);
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
        Schema::dropIfExists('test_configs');
    }
};
