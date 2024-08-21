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
        Schema::create('TProyectos', function (Blueprint $table) {
            $table->string('proyecto_id')->primary();
            $table->foreignId('cliente_id')->constrained('TClientes')->onDelete('cascade');
            $table->string('estado')->nullable();
            $table->string('serie_ref')->nullable();
            $table->integer('num_ref')->nullable();
            $table->boolean('eliminado')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('TProyectos');
    }
};
