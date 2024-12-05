<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('liberaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('libe_usu');
            $table->string('libe_nave_viaje');
            $table->string('libe_bl');
            $table->string('libe_puerto');
            $table->string('libe_consignatario');
            $table->string('libe_direccion');
            $table->integer('libe_factura');
            $table->json('documentos');
            $table->string('pdf_cartaliberacion')->nullable();
            $table->string('pdf_seawaybill')->nullable();
            $table->integer('libe_estado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liberaciones');
    }
};
