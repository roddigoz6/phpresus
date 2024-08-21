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
        Schema::create('TProductos', function (Blueprint $table) {
            $table->id();
            //
            $table->string('nombre');
            $table->float('precio');
            $table->text('leyenda')->nullable();
            $table->integer('stock');
            $table->string('tipo')->nullable();
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
        Schema::dropIfExists('TProductos');
    }
};
