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
        Schema::table('feed_backs', function (Blueprint $table) {
            $table->foreign(['test_id'], 'feed_backs_ibfk_1')->references(['id'])->on('test_configs')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['candidate_id'], 'feed_backs_ibfk_2')->references(['candidate_id'])->on('scheduled_candidates')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feed_backs', function (Blueprint $table) {
            $table->dropForeign('feed_backs_ibfk_1');
            $table->dropForeign('feed_backs_ibfk_2');
        });
    }
};
