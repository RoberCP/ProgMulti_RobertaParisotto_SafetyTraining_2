<?php

namespace Database\Factories;

use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpresaFactory extends Factory
{
    protected $model = Empresa::class;

    public function definition(): array
    {
        return [
            'razao_social' => $this->faker->company,
            'cnpj' => $this->faker->unique()->numerify('########0001##'),
            'ramo' => $this->faker->word,
        ];
    }
}
