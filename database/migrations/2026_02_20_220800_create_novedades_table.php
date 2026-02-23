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
        Schema::create('novedades', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->enum('tipo', ['incidencia', 'mantenimiento', 'evento', 'otro']);
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('responsable_id')->nullable();
            $table->enum('estado', ['pendiente', 'en_progreso', 'resuelto'])->default('pendiente');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('responsable_id')->references('id')->on('responsables')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades');
    }
};
