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
        Schema::table('endorsements', function (Blueprint $table) {
            $table->foreign(['test_id'], 'endorsements_ibfk_1')->references(['id'])->on('test_configs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['candidate_id'], 'endorsements_ibfk_2')->references(['candidate_id'])->on('scheduled_candidates')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('endorsements', function (Blueprint $table) {
            $table->dropForeign('endorsements_ibfk_1');
            $table->dropForeign('endorsements_ibfk_2');
        });
    }
};
