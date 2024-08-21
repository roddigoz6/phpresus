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
        Schema::create('TClientes', function (Blueprint $table) {
            $table->id();
            //
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('dni')->nullable();
            $table->string('email')->nullable();
            $table->string('movil')->nullable();

            $table->string('contacto')->nullable();
            $table->string('direccion')->nullable();
            $table->string('cp')->nullable();
            $table->string('poblacion')->nullable();
            $table->string('provincia')->nullable();
            $table->string('fax')->nullable();
            $table->string('cargo')->nullable();
            $table->string('titular_nom')->nullable();
            $table->string('titular_ape')->nullable();
            $table->string('direccion_envio')->nullable();
            $table->string('cp_envio')->nullable();
            $table->string('poblacion_envio')->nullable();
            $table->string('provincia_envio')->nullable();
            $table->string('pago')->nullable();

            $table->boolean('establecido')->default(false);
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
        Schema::dropIfExists('TClientes');
    }
};
