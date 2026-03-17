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
        Schema::create('solicituds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_trabajador');
            $table->integer('id_admin')->nullable();
            $table->String('motivo');
            $table->String('estado');
            $table->date('fecha_prestamo');
            $table->date('fecha_devolucion');
            $table->date('fecha_entrega')->nullable();

            $table->foreign('id_trabajador')->references('id')->on('users');
            $table->foreign('id_admin')->references('id')->on('users');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicituds');
    }
};
