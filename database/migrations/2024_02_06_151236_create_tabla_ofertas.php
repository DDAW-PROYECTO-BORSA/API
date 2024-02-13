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
            $table->foreignId('idEmpresa')->nullable()->constrained('empresas','idUsuario')->onDelete('set null');
            $table->text('descripcion');
            $table->string('duracion');
            $table->string('contacto');
            $table->string('metodoInscripcion');
            $table->string('email')->nullable();
            $table->string('estado');
            $table->boolean('validado');
            $table->softDeletes();
            $table->timestamps();
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
