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
        Schema::table('programmes', function (Blueprint $table) {
            $table->foreign(['programme_type_id'], 'programmes_ibfk_1')->references(['id'])->on('programme_types')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['department_id'], 'programmes_ibfk_2')->references(['id'])->on('departments')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropForeign('programmes_ibfk_1');
            $table->dropForeign('programmes_ibfk_2');
        });
    }
};
