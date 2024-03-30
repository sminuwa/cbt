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
        Schema::create('programmes', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('department_id')->index('department_id');
            $table->string('name', 100);
            $table->string('duration', 15);
            $table->integer('programme_type_id')->index('programme_type_id');
            $table->string('art_science', 8)->nullable();
            $table->string('hprog_type_code', 2)->nullable();
            $table->string('pcode', 2);
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
        Schema::dropIfExists('programmes');
    }
};
