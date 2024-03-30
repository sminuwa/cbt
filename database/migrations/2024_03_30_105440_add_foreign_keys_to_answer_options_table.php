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
        Schema::table('answer_options', function (Blueprint $table) {
            $table->foreign(['question_bank_id'], 'answer_options_ibfk_1')->references(['id'])->on('question_banks')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answer_options', function (Blueprint $table) {
            $table->dropForeign('answer_options_ibfk_1');
        });
    }
};
