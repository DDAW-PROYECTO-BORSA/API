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
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEmpresa')->constrained('empresas','idUsuario')->nullable();
            $table->text('descripcion');
            $table->string('duracion');
            $table->string('contacto');
            $table->string('metodoInscripcion');
            $table->string('email')->nullable();
            $table->string('estado');
            $table->boolean('validado');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
