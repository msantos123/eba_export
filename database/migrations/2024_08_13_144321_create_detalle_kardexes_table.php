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
        Schema::create('detalle_kardexes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kardex_id');
            $table->string('tipo_movimiento',20);
            $table->string('empresa',50);
            $table->string('codigo_conocimiento',50);
            $table->foreignId('ingreso_id')->nullable();
            $table->foreignId('salida_id')->nullable();
            $table->integer('ingreso')->nullable();;
            $table->integer('salida')->nullable();;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_kardexes');
    }
};
