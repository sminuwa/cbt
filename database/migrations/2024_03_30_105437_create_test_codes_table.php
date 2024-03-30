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
        Schema::create('test_codes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 45)->comment('describe the code for the exams. eg PUTME, COSC101,MATH105');
            $table->timestamps();

            $table->primary(['id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_codes');
    }
};
