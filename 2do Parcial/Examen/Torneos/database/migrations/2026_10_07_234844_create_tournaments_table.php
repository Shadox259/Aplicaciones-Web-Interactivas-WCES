<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // creador (admin)
            $table->string('nombre', 255);
            $table->string('juego', 255);
            $table->date('fecha');
            $table->unsignedInteger('cupo')->default(16);
            $table->text('descripcion')->nullable();
            $table->boolean('abierto')->default(true); // true = abierto, false = cerrado
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};