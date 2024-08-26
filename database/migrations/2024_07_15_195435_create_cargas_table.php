<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cargas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_producto');
            $table->string('nombre_producto');
            $table->date('fecha_produccion')->nullable();
            $table->string('descripcion');
            $table->string('lote',20)->nullable();
            $table->integer('cantidad');
            $table->double('kilosnetos', 10);
            $table->double('librasnetas', 10);
            $table->foreignId('solicitud_cargas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cargas');
    }
};



