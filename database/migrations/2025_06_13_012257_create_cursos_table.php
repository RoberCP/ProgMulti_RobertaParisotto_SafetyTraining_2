<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->bigIncrements('IdCurso');
            $table->string('nomeCurso');
            $table->integer('cargaHora');
            $table->string('instrutor');
            $table->date('prazoRecicla');
            $table->string('status')->default('Ativo');
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};