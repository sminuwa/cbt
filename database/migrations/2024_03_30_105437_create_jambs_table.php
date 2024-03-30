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
        Schema::create('jambs', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('reg_number', 100)->index('reg_number');
            $table->string('candidate_name', 100);
            $table->string('state_id', 100);
            $table->string('lga_id', 100);
            $table->string('gender', 50);
            $table->integer('age');
            $table->integer('eng_score');
            $table->string('subj_2', 50);
            $table->integer('subj_2_Score');
            $table->string('subj_3', 50);
            $table->integer('subj_3_Score');
            $table->string('subj_4', 50);
            $table->integer('subj_4_Score');
            $table->integer('total_Score');
            $table->string('faculty_id', 50);
            $table->string('programme_id', 50);
            $table->timestamps();

            $table->unique(['reg_number'], 'reg_number_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jambs');
    }
};
