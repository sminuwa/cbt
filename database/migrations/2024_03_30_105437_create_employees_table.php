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
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('first_name', 30);
            $table->string('surname', 30);
            $table->string('other_names', 30)->nullable();
            $table->integer('department_id')->nullable()->index('department_id');
            $table->date('date_of_first_appointment');
            $table->integer('rank_on_employment');
            $table->string('salary_on_appointment', 5);
            $table->date('date_of_birth')->nullable();
            $table->integer('nationality')->default(156);
            $table->integer('lga')->nullable()->default(100);
            $table->string('place_of_birth', 45)->nullable();
            $table->enum('marital_status', ['Married', 'Single', 'Divorced', 'Widow', 'Separated'])->nullable();
            $table->enum('gender', ['Female', 'Male']);
            $table->string('permanent_address', 100)->nullable();
            $table->string('personnel_no', 20)->nullable()->unique('personnel_no');
            $table->string('status', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
