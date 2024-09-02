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
            $table->foreignId('cliente_id')->constrained('TClientes')->onDelete('cascade');
            $table->string('proyecto_id');
            $table->foreign('proyecto_id')->references('proyecto_id')->on('TProyectos')->onDelete('cascade');
            $table->float('precio_total')->nullable();
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
