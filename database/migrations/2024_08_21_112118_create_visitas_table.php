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
        Schema::create('TVisitas', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto_id')->references('proyecto_id')->on('TProyectos')->onDelete('cascade');
            $table->string('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->time('hora_inicio');
            $table->date('fecha_fin')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('contacto_visita')->nullable();
            $table->string('prioridad')->nullable();
            $table->text('nota_cerrar')->nullable();
            $table->boolean('eliminado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TVisitas');
    }
};
