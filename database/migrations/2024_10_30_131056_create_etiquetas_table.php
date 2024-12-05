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
        Schema::create('etiquetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eti_usuario');
            $table->string('eti_nombre');
            $table->json('eti_contenido');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etiquetas');
    }
};
