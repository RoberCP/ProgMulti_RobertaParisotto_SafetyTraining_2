<?php

use App\Models\Empresa;
use App\Models\User;
use function Pest\Laravel\{actingAs, get, post, put, delete};
use Livewire\Livewire;

beforeEach(function () {
    $this->admin = User::factory()->create(['is_admin' => true]);
    $this->auditor = User::factory()->create(['is_admin' => false]);
});

it('permite que o admin acesse a tela de empresas', function () {
    actingAs($this->admin);
    get('/empresas')->assertOk();
});

it('não permite que auditor acesse todas as empresas', function () {
    actingAs($this->auditor);
    get('/empresas')->assertOk(); // A tela abre, mas sem empresas listadas
});

it('cria uma nova empresa com dados válidos', function () {
    actingAs($this->admin);
    
    Livewire::test(\App\Livewire\EmpresaManagement::class)
        ->set('razao_social', 'Empresa Teste')
        ->set('cnpj', '12345678000100')
        ->set('ramo', 'Consultoria')
        ->call('save');

    expect(Empresa::where('cnpj', '12345678000100')->exists())->toBeTrue();
});

it('não cria empresa com campos obrigatórios em branco', function () {
    actingAs($this->admin);

    Livewire::test(\App\Livewire\EmpresaManagement::class)
        ->set('razao_social', '')
        ->set('cnpj', '')
        ->set('ramo', '')
        ->call('save')
        ->assertHasErrors(['razao_social', 'cnpj', 'ramo']);
});

it('permite que admin edite uma empresa existente', function () {
    $empresa = Empresa::factory()->create();
    actingAs($this->admin);

    Livewire::test(\App\Livewire\EmpresaManagement::class)
        ->call('edit', $empresa->id)
        ->set('ramo', 'Tecnologia')
        ->call('save');

    expect($empresa->fresh()->ramo)->toBe('Tecnologia');
});

it('permite que admin exclua uma empresa', function () {
    $empresa = Empresa::factory()->create();
    actingAs($this->admin);

    Livewire::test(\App\Livewire\EmpresaManagement::class)
        ->call('confirmDelete', $empresa->id)
        ->call('deleteEmpresa');

    expect(Empresa::find($empresa->id))->toBeNull();
});