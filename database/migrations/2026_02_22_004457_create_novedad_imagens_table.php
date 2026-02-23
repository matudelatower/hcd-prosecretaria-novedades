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
        Schema::create('novedad_imagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('novedad_id');
            $table->string('imagen');
            $table->text('descripcion')->nullable();
            $table->timestamps();
            
            $table->foreign('novedad_id')->references('id')->on('novedades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedad_imagens');
    }
};
