<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificados', function (Blueprint $table) {
            $table->id('idCertificado');

            $table->unsignedBigInteger('idCurso');
            $table->unsignedBigInteger('idFuncionario');

            $table->foreign('idCurso')->references('IdCurso')->on('cursos')->onDelete('cascade');
            $table->foreign('idFuncionario')->references('idFuncionario')->on('funcionarios')->onDelete('cascade');

            $table->date('dataEmissao')->nullable();

            $table->integer('carga_horaria');
            $table->string('instrutor');
            $table->string('progresso');
            $table->boolean('assinatura_instrutor')->default(false);
            $table->boolean('assinatura_funcionario')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
