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
        Schema::table('people_raffles', function (Blueprint $table) {
            $table->unsignedBigInteger('prize_id')->nullable();
            $table->foreign('prize_id')->references('id')->on('prizes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people_raffles', function (Blueprint $table) {
            //
            $table->dropForeign(['prize_id']); // Elimina la restricción de clave foránea
            $table->dropColumn('prize_id'); // Elimina la columna
        });
    }
};
