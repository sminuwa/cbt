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
        Schema::table('scheduled_candidates', function (Blueprint $table) {
            $table->foreign(['candidate_type_id'], 'scheduled_candidates_ibfk_1')->references(['id'])->on('exam_types')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scheduled_candidates', function (Blueprint $table) {
            $table->dropForeign('scheduled_candidates_ibfk_1');
        });
    }
};
