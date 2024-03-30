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
        Schema::table('test_questions', function (Blueprint $table) {
            $table->foreign(['question_bank_id'], 'test_questions_ibfk_1')->references(['id'])->on('question_banks')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['test_section_id'], 'test_questions_ibfk_2')->references(['id'])->on('test_sections')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_questions', function (Blueprint $table) {
            $table->dropForeign('test_questions_ibfk_1');
            $table->dropForeign('test_questions_ibfk_2');
        });
    }
};
