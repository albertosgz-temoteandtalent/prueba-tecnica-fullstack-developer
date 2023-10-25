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
        Schema::create('perfil_usuarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->foreignId('imagen_id')->nullable();

            // Solo puede existir una única combinación de todos estos campos al mismo tiempo
            $table->index(['nombre', 'apellidos', 'telefono', 'correo', 'imagen_id'], 'usuario_unico_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfil_usuarios');
    }
};
