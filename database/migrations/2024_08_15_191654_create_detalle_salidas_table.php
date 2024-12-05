<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalle_salidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salida_id');
            $table->foreignId('kardexs_id');
            $table->string('codigo_producto');
            $table->string('producto');
            $table->string('lote');
            $table->string('cantidad');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalle_salidas');
    }
};
