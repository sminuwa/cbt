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
        Schema::create('endorsements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->integer('test_id')->index('test_id');
            $table->string('pass_key', 10);
            $table->timestamps();

            $table->unique(['candidate_id', 'test_id'], 'candidate_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('endorsements');
    }
};
