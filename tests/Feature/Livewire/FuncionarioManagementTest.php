<?php

use App\Models\User;
use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\Certificado;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->auditor = User::factory()->create(['is_admin' => false]);

    $this->empresa = Empresa::factory()->create();
    $this->certificado = Certificado::factory()->create();

    $this->empresa->users()->attach($this->auditor);
});

it('permite que admin visualize todos os funcionários', function () {
    $funcionario = Funcionario::factory()->create(['idEmpresa' => $this->empresa->id]);

    Livewire::actingAs($this->admin)
        ->test('funcionario-management')
        ->assertSee($funcionario->nome);
});

it('permite que auditor visualize apenas funcionários de suas empresas', function () {
    $funcionario = Funcionario::factory()->create(['idEmpresa' => $this->empresa->id]);

    Livewire::actingAs($this->auditor)
        ->test('funcionario-management')
        ->assertSee($funcionario->nome);
});

it('não mostra funcionário de empresa que não pertence ao auditor', function () {
    $outraEmpresa = Empresa::factory()->create();
    $funcionario = Funcionario::factory()->create(['idEmpresa' => $outraEmpresa->id]);

    Livewire::actingAs($this->auditor)
        ->test('funcionario-management')
        ->assertDontSee($funcionario->nome);
});

it('permite que admin cadastre funcionário', function () {
    Livewire::actingAs($this->admin)
        ->test('funcionario-management')
        ->set('nome', 'Fulano da Silva')
        ->set('cpf', '12345678900')
        ->set('setor', 'RH')
        ->set('cargo', 'Analista')
        ->set('empresa_id', $this->empresa->id)
        ->set('certificado_id', $this->certificado->id)
        ->call('save');

    $this->assertDatabaseHas('funcionarios', ['nome' => 'Fulano da Silva']);
});

it('impede que auditor exclua funcionário', function () {
    $funcionario = Funcionario::factory()->create(['idEmpresa' => $this->empresa->id]);

    Livewire::actingAs($this->auditor)
        ->test('funcionario-management')
        ->call('confirmDelete', $funcionario->id)
        ->call('deleteFuncionario')
        ->assertForbidden();

    $this->assertDatabaseHas('funcionarios', ['id' => $funcionario->id]);
});
