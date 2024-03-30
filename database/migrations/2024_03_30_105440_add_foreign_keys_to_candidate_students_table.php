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
        Schema::table('candidate_students', function (Blueprint $table) {
            $table->foreign(['candidate_id'], 'candidate_students_ibfk_1')->references(['candidate_id'])->on('scheduled_candidates')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['schedule_id'], 'candidate_students_ibfk_2')->references(['id'])->on('schedulings')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['subject_id'], 'candidate_students_ibfk_3')->references(['id'])->on('subjects')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidate_students', function (Blueprint $table) {
            $table->dropForeign('candidate_students_ibfk_1');
            $table->dropForeign('candidate_students_ibfk_2');
            $table->dropForeign('candidate_students_ibfk_3');
        });
    }
};
