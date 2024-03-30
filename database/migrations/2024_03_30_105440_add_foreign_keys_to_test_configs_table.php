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
        Schema::table('test_configs', function (Blueprint $table) {
            $table->foreign(['test_code_id'], 'test_configs_ibfk_1')->references(['id'])->on('test_codes')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['test_type_id'], 'test_configs_ibfk_2')->references(['id'])->on('test_types')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['initiated_by'], 'test_configs_ibfk_3')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('test_configs', function (Blueprint $table) {
            $table->dropForeign('test_configs_ibfk_1');
            $table->dropForeign('test_configs_ibfk_2');
            $table->dropForeign('test_configs_ibfk_3');
        });
    }
};
