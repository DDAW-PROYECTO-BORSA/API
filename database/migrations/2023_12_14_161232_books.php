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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->string('idModule');
            $table->string('publisher');
            $table->float('price');
            $table->integer('pages');
            $table->string('status');
            $table->string('photo')->nullable();
            $table->date('soldDate')->nullable();
            $table->text('comments')->nullable();

            $table->foreign('idUser')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idModule')->references('code')->on('modules');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');

    }
};
