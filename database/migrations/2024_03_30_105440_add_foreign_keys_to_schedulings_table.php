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
        Schema::table('schedulings', function (Blueprint $table) {
            $table->foreign(['test_id'], 'schedulings_ibfk_1')->references(['id'])->on('test_configs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['venue_id'], 'schedulings_ibfk_2')->references(['id'])->on('venues')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedulings', function (Blueprint $table) {
            $table->dropForeign('schedulings_ibfk_1');
            $table->dropForeign('schedulings_ibfk_2');
        });
    }
};
