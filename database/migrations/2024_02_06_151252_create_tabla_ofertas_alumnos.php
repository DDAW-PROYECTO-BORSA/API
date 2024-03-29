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
        Schema::create('ofertasAlumnos', function (Blueprint $table) {
            $table->unsignedBigInteger('idOferta');
            $table->unsignedBigInteger('idUsuario');

            $table->primary(['idUsuario','idOferta']);


            $table->foreign('idOferta')->references('id')->on('ofertas');
            $table->foreign('idUsuario')->references('idUsuario')->on('alumnos');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('ofertasAlumnos');
    }
};
