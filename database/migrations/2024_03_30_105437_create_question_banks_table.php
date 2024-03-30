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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('title');
            $table->enum('difficulty_level', ['simple', 'difficult', 'moredifficult'])->nullable()->default('simple');
            $table->dateTime('questiontime')->nullable();
            $table->enum('active', ['true', 'false'])->nullable()->default('true');
            $table->integer('author')->nullable();
            $table->integer('subject_id')->nullable()->index('subject_id');
            $table->string('topic', 45)->nullable();
            $table->integer('topic_id')->nullable()->index('topic_id');
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
        Schema::dropIfExists('question_banks');
    }
};
