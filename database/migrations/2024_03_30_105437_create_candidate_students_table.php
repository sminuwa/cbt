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
        Schema::create('candidate_students', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('schedule_id')->index('schedule_id');
            $table->integer('candidate_id')->index('candidate_id');
            $table->integer('subject_id')->index('subject_id')->comment('indicate the subjects to be taken by the candidate in case of multisubject exams. eg putme');
            $table->integer('add_index')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->primary(['id', 'schedule_id', 'candidate_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_students');
    }
};
