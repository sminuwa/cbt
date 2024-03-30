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
        Schema::create('test_questions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('test_section_id')->index('question_id');
            $table->integer('question_bank_id')->index('question_bank_id');
            $table->unsignedInteger('version')->default(1);
            $table->timestamps();

            $table->primary(['id', 'test_section_id', 'question_bank_id', 'version']);
            $table->index(['test_section_id', 'question_bank_id'], 'test_section_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_questions');
    }
};
