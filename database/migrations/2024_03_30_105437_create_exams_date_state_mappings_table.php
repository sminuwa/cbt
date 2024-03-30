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
        Schema::create('exams_date_state_mappings', function (Blueprint $table) {
            $table->unsignedInteger('id')->index('id');
            $table->integer('scheduling_id')->nullable()->index('scheduling_id');
            $table->integer('state_id')->index('state_id');
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
        Schema::dropIfExists('exams_date_state_mappings');
    }
};
