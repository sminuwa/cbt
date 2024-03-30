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
        Schema::table('time_controls', function (Blueprint $table) {
            $table->foreign(['candidate_id'], 'time_controls_ibfk_1')->references(['candidate_id'])->on('scheduled_candidates')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['test_id'], 'time_controls_ibfk_2')->references(['id'])->on('test_configs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('time_controls', function (Blueprint $table) {
            $table->dropForeign('time_controls_ibfk_1');
            $table->dropForeign('time_controls_ibfk_2');
        });
    }
};
