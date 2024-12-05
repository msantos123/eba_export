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
        Schema::create('pre_facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('comprobante_salida');
            $table->string('mes');
            $table->date('fecha_factura');
            $table->integer('nro_factura');
            $table->string('razon_social');
            $table->string('nit')->nullable();
            $table->string('incoterm');
            $table->string('lugar_destino');
            $table->string('puerto_destino');
            $table->string('direccion');
            $table->double('tipo_cambio');
            $table->integer('zafra');
            $table->double('total_facturado_usd');
            $table->double('total_facturado_bs');
            $table->double('comision')->nullable();
            $table->double('total_pagar_usd');
            $table->double('total_pagar_bs');
            $table->double('primer_pago')->nullable();
            $table->date('fecha_primer_pago')->nullable();
            $table->double('segundo_pago')->nullable();
            $table->date('fecha_segundo_pago')->nullable();
            $table->double('tercer_pago')->nullable();
            $table->date('fecha_tercer_pago')->nullable();
            $table->double('total_pagos')->nullable();
            $table->double('saldos')->nullable();
            $table->integer('anulado')->default();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_facturas');
    }
};
