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
        Schema::create('answer_options', function (Blueprint $table) {
            $table->integer('id', true)->index('fk_answer_options_questionbanks1');
            $table->text('question_option')->nullable();
            $table->integer('question_bank_id')->nullable()->index('question_bank_id');
            $table->integer('correctness')->nullable()->default(0)->index('diagram_id');
            $table->timestamps();

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_options');
    }
};
