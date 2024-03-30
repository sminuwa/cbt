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
        Schema::create('sbrs_students', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('old_sbrsno', 30)->nullable();
            $table->string('sbrs_no', 10)->nullable();
            $table->string('jamb_no', 25)->nullable();
            $table->string('combination', 11)->nullable();
            $table->string('surname', 20);
            $table->string('first_name', 20);
            $table->string('other_names', 20)->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();
            $table->date('dob')->nullable();
            $table->integer('lga')->nullable();
            $table->string('lgac', 20)->nullable();
            $table->integer('state')->nullable();
            $table->string('statec', 20)->nullable();
            $table->integer('nationality')->nullable();
            $table->string('entry_session', 9)->nullable();
            $table->string('contact_address')->nullable();
            $table->string('home_address')->nullable();
            $table->string('gsm_number', 11)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('login_password', 30)->nullable()->comment('for students to log in to their profile on the portal');
            $table->integer('first_choice')->nullable();
            $table->integer('second_choice')->nullable();
            $table->string('firstc', 30)->nullable();
            $table->string('secondc', 30)->nullable();
            $table->float('cgpa', 5)->nullable();
            $table->enum('enable_std', ['y', 'n'])->nullable()->default('n');
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
        Schema::dropIfExists('sbrs_students');
    }
};
