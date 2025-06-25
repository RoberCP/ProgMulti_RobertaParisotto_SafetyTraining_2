<?php

use App\Livewire\UserManagement;
use App\Livewire\EmpresaManagement;
use App\Livewire\FuncionarioManagement;
use App\Livewire\CursoManagement;
use App\Livewire\CertificadoManagement;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/profile', function () {
    return view('profile');
})->middleware(['auth'])->name('profile');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', UserManagement::class)->name('usuarios');
    Route::get('/empresas', EmpresaManagement::class)->name('empresas');
    Route::get('/funcionarios', FuncionarioManagement::class)->name('funcionarios');
    Route::get('/cursos', CursoManagement::class)->name('cursos');
    Route::get('/certificados', CertificadoManagement::class)->name('certificados');
});

require __DIR__.'/auth.php';
