<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id('idFuncionario');
            $table->foreignId('idEmpresa')->constrained('empresas')->onDelete('cascade');
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('setor');
            $table->string('cargo');

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')->references('IdCurso')->on('cursos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};
