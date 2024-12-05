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
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id();
            $table->integer('gestion');
            $table->string('mes');
            $table->string('contrato');
            $table->string('cliente_contrato');
            $table->integer('nro_factura');
            $table->date('fecha_factura');
            $table->string('cliente');
            $table->string('destino');
            $table->string('puerto');
            $table->string('incoterm');
            $table->string('calidad');
            $table->string('zafra');
            $table->integer('cantidad_caja');
            $table->integer('volumen_kg');
            $table->integer('volumen_tn');
            $table->double('precio');
            $table->double('total_facturado_usd');
            $table->double('total_facturado_oficial');
            $table->double('comisiones');
            $table->double('total_pagar_usd');
            $table->double('ingreso_total_eba');
            $table->double('total_pagado_bs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadisticas');
    }
};
