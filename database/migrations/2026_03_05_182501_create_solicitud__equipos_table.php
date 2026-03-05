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
        Schema::create('solicitud__equipos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_Unidad_Equipo');
            $table->foreign('id_Unidad_Equipo')->references('id')->on('unidad__equipos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud__equipos');
    }
};
