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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            //
            $table->foreignId('presupuesto_id')->nullable()->constrained('presupuestos')->change();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->change();
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_apellido')->nullable();
            $table->string('cliente_dni')->nullable();
            $table->float('precio_total')->nullable();
            $table->boolean('cobrado')->default(false);
            $table->boolean('eliminado')->default(false);
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
        Schema::dropIfExists('ordenes');
    }
};
