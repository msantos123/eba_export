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
        Schema::create('comprobante_salidas', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_salida');
            $table->string('empresa',100);
            $table->string('responsable',100);
            $table->string('camion',50);
            $table->string('placa',10);
            $table->string('licencia',10);
            $table->integer('celular');
            $table->string('contenedor',20);
            $table->string('presinto',20);
            $table->string('reserva',20);
            $table->integer('factura');
            $table->string('destino',100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobante_salidas');
    }
};
