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
        Schema::create('TProd_Pres', function (Blueprint $table) {
            $table->id();
            //
            $table->foreignId('producto_id')->nullable()->constrained('TProductos')->onDelete('cascade');
            $table->foreignId('presupuesto_id')->constrained('TPresupuestos')->onDelete('cascade');
            $table->float('precio')->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('orden')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->string('titulo')->nullable();
            //
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
        Schema::dropIfExists('TProd_Pres');
    }
};
