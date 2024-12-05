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
        Schema::create('comprobante_ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_ingreso');
            $table->date('fecha_ingreso');
            $table->string('cefo');
            $table->string('observaciones')->nullable();
            $table->foreignId('conocimiento_id');
            $table->integer('estado')->default(0);
            $table->string('pdf_comprobante_ingreso',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprobante_ingresos');
    }
};
