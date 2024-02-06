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
        Schema::create('alumnosCiclos', function (Blueprint $table) {
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idCiclo');
            $table->date('finalizacion')->nullable();
            $table->boolean('validado')->default(false);

            $table->primary(['idUsuario','idCiclo']);

            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idCiclo')->references('id')->on('ciclos');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('alumnosCiclos');
    }
};
