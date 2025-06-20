<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id('idFuncionario');
            $table->unsignedBigInteger('idEmpresa');
            $table->string('nome');
            $table->string('cpf')->unique();
            $table->string('setor');
            $table->string('cargo');
            $table->unsignedBigInteger('fk_Certificado_idCertificado')->nullable(); // pode ser null se ainda não tiver certificado
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('idEmpresa')->references('id')->on('empresas')->onDelete('cascade');
            $table->foreign('fk_Certificado_idCertificado')->references('id')->on('certificados')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('funcionarios');
    }
};


