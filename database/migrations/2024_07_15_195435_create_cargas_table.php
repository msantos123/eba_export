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
            $table->string('descripcion');
            $table->string('calidad')->nullable();
            $table->string('lote',20);
            $table->integer('cantidad');
            $table->double('costo_caja')->nullable();
            $table->double('kilosnetos', 10);
            $table->double('librasnetas', 10);
            $table->double('precio_kilo',10)->nullable();
            $table->double('precio_libra',10)->nullable();
            $table->foreignId('receta_id');
            $table->foreignId('solicitud_cargas');
            $table->foreignId('kardex_id')->nullable();
            $table->integer('estado')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cargas');
    }
};



