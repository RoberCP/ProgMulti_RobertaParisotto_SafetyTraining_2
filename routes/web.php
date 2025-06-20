<?php

use App\Livewire\Auth\Login;
use App\Livewire\UserManagement;
use App\Livewire\EmpresaManagement;
use App\Livewire\FuncionarioManagement;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', UserManagement::class)->name('usuarios');
    Route::get('/empresas', EmpresaManagement::class)->name('empresas');
    Route::get('/funcionarios', FuncionarioManagement::class)->name('funcionarios');
});

require __DIR__.'/auth.php';

