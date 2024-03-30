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
        Schema::create('test_invigilators', function (Blueprint $table) {
            $table->integer('id', true)->index('id');
            $table->integer('user_id');
            $table->integer('test_id')->index('test_id');
            $table->integer('scheduling_id')->index('scheduling_id');
            $table->char('pass_key', 3)->default('abc');
            $table->timestamps();

            $table->unique(['user_id', 'test_id', 'scheduling_id'], 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_invigilators');
    }
};
