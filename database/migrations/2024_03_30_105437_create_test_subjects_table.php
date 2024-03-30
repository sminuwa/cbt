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
        Schema::create('test_subjects', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('test_id')->index('test_id');
            $table->integer('subject_id')->index('subject_id');
            $table->string('title', 45)->nullable();
            $table->string('instruction', 45)->nullable();
            $table->float('total_mark')->nullable()->default(100);
            $table->timestamps();

            $table->primary(['id', 'test_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_subjects');
    }
};
