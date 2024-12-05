<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siga_salida_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('detalle_id');
            $table->foreignId('salida_id');
            $table->integer('rece_id');
            $table->double('cantidad_detalle',10);
            $table->double('cantidad_salida',10)->nullable();
            $table->integer('lote_detalle');
            $table->date('fecha_elaboracion');
            $table->date('fecha_vencimiento');
            $table->date('fecha_envasado');
            $table->foreignId('cargaIngreso_id');
            $table->foreignId('cargaSalida_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siga_salida_detalles');
    }
};
