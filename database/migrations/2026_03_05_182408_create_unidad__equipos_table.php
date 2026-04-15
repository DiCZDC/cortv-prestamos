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
        Schema::create('unidad__equipos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_equipo');
            $table->string('sicipo');
            $table->boolean('mantenimiento')->default(false);
            $table->foreign('id_equipo')->references('id')->on('equipos');
        });
    }

    /**
     * Reverse the migrations. holiwi
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad__equipos');

    }
};
