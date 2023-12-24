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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ci')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            // campo para provincias
            $table->string('province')->nullable()->default(null);
            $table->string('department')->nullable()->default(null);
            $table->unsignedBigInteger('register_user_id')->nullable()->default(null);
            $table->foreign('register_user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->boolean('active')->default(true);
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
        Schema::dropIfExists('people');
    }
};
