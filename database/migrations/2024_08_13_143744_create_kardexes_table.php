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
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_producto');
            $table->string('articulo',50);
            $table->foreignId('proveedor_id');
            $table->string('ubicacion',50);
            $table->string('unidad')->default('Cajas de 20 Kg.');
            $table->string('lote');
            $table->integer('saldo');
            $table->double('costo_caja')->nullable();
            $table->foreignId('receta_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kardexes');
    }
};
