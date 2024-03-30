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
        Schema::create('scheduled_candidates', function (Blueprint $table) {
            $table->integer('candidate_id', true)->index('candidate_id');
            $table->integer('candidate_type_id')->nullable()->index('fk_scheduled_candidate_candidate_types1');
            $table->string('reg_number', 100)->index('regno_2');
            $table->timestamps();

            $table->primary(['candidate_id']);
            $table->unique(['reg_number'], 'regno_3');
            $table->index(['reg_number'], 'reg_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scheduled_candidates');
    }
};
