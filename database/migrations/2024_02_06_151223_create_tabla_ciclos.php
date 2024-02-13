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
        Schema::create('ciclos', function (Blueprint $table) {
            $table->id();
            $table->string('ciclo');
            $table->string('vliteral');
            $table->string('cliteral');
            $table->unsignedBigInteger('idFamilia');
            $table->unsignedBigInteger('responsable');

            $table->foreign('idFamilia')->references('id')->on('familias');
            $table->foreign('responsable')->references('id')->on('users');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclos');
    }
};
