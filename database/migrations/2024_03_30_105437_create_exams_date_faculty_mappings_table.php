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
        Schema::create('exams_date_faculty_mappings', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->integer('scheduling_id')->nullable()->index('scheduling_id');
            $table->integer('faculty_id')->index('faculty_index');
            $table->timestamps();

            $table->index(['id', 'faculty_id'], 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams_date_faculty_mappings');
    }
};
