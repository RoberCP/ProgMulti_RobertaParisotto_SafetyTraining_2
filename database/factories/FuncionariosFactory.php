<?php

namespace Database\Factories;

use App\Models\Funcionario;
use App\Models\Empresa;
use App\Models\Certificado;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuncionarioFactory extends Factory
{
    protected $model = Funcionario::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->name(),
            'cpf' => $this->faker->unique()->numerify('###########'), // CPF sem máscara
            'setor' => $this->faker->randomElement(['RH', 'Financeiro', 'TI', 'Produção']),
            'cargo' => $this->faker->jobTitle(),
            'idEmpresa' => Empresa::factory(),
            'fk_Certificado_idCertificado' => Certificado::factory(),
        ];
    }
}