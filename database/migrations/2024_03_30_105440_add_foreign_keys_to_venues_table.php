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
        Schema::table('venues', function (Blueprint $table) {
            $table->foreign(['centre_id'], 'fk_venues_tblcentres1')->references(['id'])->on('centres')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['host_id'], 'fk_venues_tblhost1')->references(['id'])->on('hosts')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropForeign('fk_venues_tblcentres1');
            $table->dropForeign('fk_venues_tblhost1');
        });
    }
};
