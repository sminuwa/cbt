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
        Schema::create('venue_computers', function (Blueprint $table) {
            $table->comment('store allowed computer in the venue');
            $table->integer('id');
            $table->integer('venue_id');
            $table->string('computer_mac_address', 30);
            $table->string('computer_ip', 20);
            $table->timestamps();

            $table->primary(['venue_id', 'computer_mac_address']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venue_computers');
    }
};
