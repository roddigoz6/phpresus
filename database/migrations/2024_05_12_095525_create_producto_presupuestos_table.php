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
        Schema::create('producto_presupuestos', function (Blueprint $table) {
            $table->id();
            //
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('presupuesto_id')->constrained()->onDelete('cascade');
            $table->float('precio')->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('orden_prod')->nullable();
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
        Schema::dropIfExists('producto_presupuestos');
    }
};
