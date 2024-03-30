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
        Schema::table('faculty_schedule_mappings', function (Blueprint $table) {
            $table->foreign(['faculty_id'], 'faculty_schedule_mappings_ibfk_1')->references(['id'])->on('faculties')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['scheduling_id'], 'faculty_schedule_mappings_ibfk_2')->references(['id'])->on('schedulings')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculty_schedule_mappings', function (Blueprint $table) {
            $table->dropForeign('faculty_schedule_mappings_ibfk_1');
            $table->dropForeign('faculty_schedule_mappings_ibfk_2');
        });
    }
};
