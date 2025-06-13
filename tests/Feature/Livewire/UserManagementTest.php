<?php

use App\Livewire\UserManagement;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Usuário administrador padrão
function adminUser() {
    return User::factory()->create(['is_admin' => true]);
}

// Usuário auditor padrão
function auditorUser() {
    return User::factory()->create(['is_admin' => false]);
}

it('permite ao administrador visualizar todos os usuários', function () {
    $admin = adminUser();
    User::factory()->count(3)->create();

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->assertViewHas('users', fn ($users) => $users->count() === 4); // 3 + o admin
});

it('não permite ao auditor visualizar todos os usuários', function () {
    $auditor = auditorUser();
    User::factory()->count(2)->create();

    Livewire::actingAs($auditor)
        ->test(UserManagement::class)
        ->assertSee($auditor->name)
        ->assertDontSee(User::where('id', '!=', $auditor->id)->first()->name);
});

it('permite ao administrador criar um usuário com dados válidos', function () {
    $admin = adminUser();

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->set('name', 'Novo Usuário')
        ->set('email', 'novo@teste.com')
        ->set('password', 'Senha@123')
        ->call('createUser')
        ->assertSee('Usuário criado com sucesso');

    expect(User::where('email', 'novo@teste.com')->exists())->toBeTrue();
});

it('exibe erro ao tentar criar usuário com dados inválidos', function () {
    $admin = adminUser();

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->set('email', 'invalido') // e sem nome e senha
        ->call('createUser')
        ->assertHasErrors(['name', 'password', 'email']);
});

it('permite ao administrador editar um usuário', function () {
    $admin = adminUser();
    $user = User::factory()->create();

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->call('editUser', $user->id)
        ->set('name', 'Nome Editado')
        ->call('updateUser')
        ->assertSee('Usuário atualizado com sucesso');

    expect(User::find($user->id)->name)->toBe('Nome Editado');
});

it('permite ao administrador excluir um usuário com confirmação', function () {
    $admin = adminUser();
    $user = User::factory()->create();

    Livewire::actingAs($admin)
        ->test(UserManagement::class)
        ->call('confirmDelete', $user->id)
        ->call('deleteUser')
        ->assertSee('Usuário excluído com sucesso');

    expect(User::find($user->id))->toBeNull();
});
