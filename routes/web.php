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

// Rotas protegidas por autenticação e verificação de email
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard do usuário
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rotas do Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Usuário
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    // Rotas de Admin protegidas pelo middleware 'admin'
    Route::middleware(['admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // Dashboard de admin
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index'); // Listar usuários
        Route::get('/admin/users/{user}', [AdminController::class, 'show'])->name('admin.users.show'); // Visualizar usuário
        Route::get('/admin/users/{user}/pdf', [AdminController::class, 'generatePDF'])->name('admin.users.pdf'); // Gerar PDF de usuário
        Route::get('/admin/users/{user}/agendamentos/{agendamento}/pdf', [AdminController::class, 'generateAgendamentoPDF'])->name('admin.generate-agendamento-pdf');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.destroy'); // Deletar usuário
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit-user'); // Editar usuário
        Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.update-user'); // Atualizar usuário
        Route::get('/admin/users/{user}/agendamentos', [AdminController::class, 'show'])->name('admin.user-agendamentos'); // Agendamentos do usuário
        Route::delete('/admin/users/{user}/agendamentos/{agendamento}', [AdminController::class, 'destroy'])->name('admin.agendamento-destroy');
        Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.update-user');
    });


    // Rotas de Agendamentos
    Route::resource('agendamentos', AgendamentoController::class);

    // Rota específica para gerar o PDF de um agendamento
    Route::get('/agendamentos/{agendamento}/pdf', [AgendamentoController::class, 'generatePDF'])->name('agendamentos.pdf');
});

// Rotas de autenticação
require __DIR__.'/auth.php';
