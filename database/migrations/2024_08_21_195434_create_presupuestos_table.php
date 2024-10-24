<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TPresupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('proyecto_id');
            $table->foreign('proyecto_id')->references('proyecto_id')->on('TProyectos')->onDelete('cascade');
            $table->string('nom_pres')->nullable();
            $table->float('precio_total')->nullable();
            $table->string('pago')->nullable();
            $table->string('iva')->nullable();
            $table->enum('estado', ['presupuestado', 'presupuesto_aceptado', 'por_cobrar'])->nullable();
            $table->boolean('aceptado')->default(false);
            $table->boolean('eliminado')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TPresupuestos');
    }
};
