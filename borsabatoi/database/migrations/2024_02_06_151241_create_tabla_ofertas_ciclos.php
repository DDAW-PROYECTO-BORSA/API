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
        Schema::create('ofertas_ciclos', function (Blueprint $table) {
            $table->unsignedBigInteger('idOferta');
            $table->unsignedBigInteger('idCiclo');

            $table->foreign('idOferta')->references('id')->on('ofertas');
            $table->foreign('idCiclo')->references('id')->on('ciclos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas_ciclos');
    }
};
