<?php

use App\Livewire\UserManagement;
use App\Livewire\EmpresaManagement;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', UserManagement::class)->name('usuarios');
    Route::get('/empresas', EmpresaManagement::class)->name('empresas');
});

require __DIR__.'/auth.php';

