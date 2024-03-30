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
        Schema::table('test_invigilators', function (Blueprint $table) {
            $table->foreign(['user_id'], 'test_invigilators_ibfk_1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['scheduling_id'], 'test_invigilators_ibfk_2')->references(['id'])->on('schedulings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['test_id'], 'test_invigilators_ibfk_3')->references(['id'])->on('test_configs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_invigilators', function (Blueprint $table) {
            $table->dropForeign('test_invigilators_ibfk_1');
            $table->dropForeign('test_invigilators_ibfk_2');
            $table->dropForeign('test_invigilators_ibfk_3');
        });
    }
};
