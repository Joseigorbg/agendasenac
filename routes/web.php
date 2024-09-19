<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgendamentoController;

// Rota principal
Route::get('/', function () {
    return view('welcome');
});

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas do Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Usuário
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // Rotas de Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // Rotas de Agendamentos
    Route::resource('agendamentos', AgendamentoController::class);

    // Rota específica para gerar o PDF de um agendamento
    Route::get('/agendamentos/{agendamento}/pdf', [AgendamentoController::class, 'generatePDF'])->name('agendamentos.pdf');
});

// Rotas de autenticação
require __DIR__.'/auth.php';
