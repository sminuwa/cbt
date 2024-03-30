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
        Schema::table('exams_date_state_mappings', function (Blueprint $table) {
            $table->foreign(['scheduling_id'], 'exams_date_state_mappings_ibfk_1')->references(['id'])->on('schedulings')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['state_id'], 'exams_date_state_mappings_ibfk_2')->references(['id'])->on('states')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exams_date_state_mappings', function (Blueprint $table) {
            $table->dropForeign('exams_date_state_mappings_ibfk_1');
            $table->dropForeign('exams_date_state_mappings_ibfk_2');
        });
    }
};
