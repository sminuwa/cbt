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
        Schema::create('answeroptions_temps', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('question_option')->nullable();
            $table->integer('question_bank_id')->nullable()->index('fk_answer_options_question_bank1');
            $table->enum('correctness', ['1', '0'])->nullable()->default('0');
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
        Schema::dropIfExists('answeroptions_temps');
    }
};
