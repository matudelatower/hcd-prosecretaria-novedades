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
        Schema::create('designaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('responsable_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->enum('periodicidad', ['diaria', 'semanal', 'mensual', 'unica']);
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('responsable_id')->references('id')->on('responsables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designaciones');
    }
};
