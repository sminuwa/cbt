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
        Schema::table('question_banks', function (Blueprint $table) {
            $table->foreign(['topic_id'], 'question_banks_ibfk_1')->references(['id'])->on('topics')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['subject_id'], 'question_banks_ibfk_2')->references(['id'])->on('subjects')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_banks', function (Blueprint $table) {
            $table->dropForeign('question_banks_ibfk_1');
            $table->dropForeign('question_banks_ibfk_2');
        });
    }
};
