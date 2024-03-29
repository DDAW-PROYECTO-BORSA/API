<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->unsignedBigInteger('idUsuario');
            $table->string('apellido')->nullable();
            $table->text('CV')->nullable();

            $table->primary(['idUsuario']);

            $table->foreign('idUsuario')->references('id')->on('users');
            $table->timestamps();

            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
