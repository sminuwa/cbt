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
        Schema::create('test_compositors', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('user_id');
            $table->integer('test_id')->index('test_id');
            $table->integer('subject_id')->index('subject_id');
            $table->timestamps();

            $table->unique(['user_id', 'test_id', 'subject_id'], 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_compositors');
    }
};
