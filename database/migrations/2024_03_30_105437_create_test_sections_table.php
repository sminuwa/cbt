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
        Schema::create('test_sections', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('test_subject_id')->index('test_subject_id');
            $table->string('title', 45)->nullable();
            $table->text('instruction')->nullable();
            $table->float('mark_per_question')->nullable();
            $table->integer('num_to_answer')->nullable();
            $table->integer('num_of_easy')->nullable();
            $table->integer('num_of_moderate')->nullable();
            $table->integer('num_of_difficult')->nullable();
            $table->timestamps();

            $table->primary(['id', 'test_subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_sections');
    }
};
