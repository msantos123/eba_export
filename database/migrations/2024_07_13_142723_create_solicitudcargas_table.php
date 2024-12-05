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
        Schema::create('solicitudcargas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->foreignId('planta_id');
            $table->foreignId('usuario_id');
            $table->foreignId('salida_inventario')->nullable();
            $table->string('tipo');
            $table->integer('estado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudcargas');
    }
};
