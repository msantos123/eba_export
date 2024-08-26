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
        Schema::create('conocimientos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->foreignId('usuario_id');
            $table->string('empresa', 80);
            $table->string('conductor',50);
            $table->string('vehiculo',50);
            $table->string('propietario',50);
            $table->string('licencia',15);
            $table->string('placa',10);
            $table->string('celular', 8);
            $table->foreignId('solicitud_id');
            $table->integer('estado')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conocimientos');
    }
};
