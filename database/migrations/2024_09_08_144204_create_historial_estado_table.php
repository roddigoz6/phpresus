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
        //
        Schema::create('THistorialEstados', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto_id')->nullable();
            $table->unsignedBigInteger('visita_id')->nullable();
            $table->timestamp('presupuestado')->nullable();
            $table->timestamp('presupuesto_aceptado')->nullable();
            $table->timestamp('por_cobrar')->nullable();
            $table->timestamp('cerrado')->nullable();
            $table->timestamp('nota_cerrar')->nullable();
            $table->timestamps();

            // Relación con Proyecto
            $table->foreign('proyecto_id')->references('proyecto_id')->on('TProyectos')->onDelete('cascade');

            // Relación con Visita
            $table->foreign('visita_id')->references('id')->on('TVisitas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
