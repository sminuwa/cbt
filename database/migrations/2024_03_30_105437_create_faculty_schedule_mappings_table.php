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
        Schema::create('faculty_schedule_mappings', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('faculty_id')->index('faculty_id');
            $table->integer('scheduling_id')->index('scheduling_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_schedule_mappings');
    }
};
