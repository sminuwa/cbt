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
        Schema::table('lgas', function (Blueprint $table) {
            $table->foreign(['state_id'], 'lgas_ibfk_1')->references(['id'])->on('states')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lgas', function (Blueprint $table) {
            $table->dropForeign('lgas_ibfk_1');
        });
    }
};
