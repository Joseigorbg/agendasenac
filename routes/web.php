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
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Rotas de Admin protegidas pelo middleware 'admin'
    Route::middleware(['admin'])->group(function () {
        // Dashboard de admin
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Rotas de Usuários
        Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index'); 
        Route::get('/admin/users/{user}', [AdminController::class, 'show'])->name('admin.users.show'); 
        Route::get('/admin/users/{user}/pdf', [AdminController::class, 'generatePDF'])->name('admin.users.pdf'); 
        Route::get('/admin/users/{user}/agendamentos/{agendamento}/pdf', [AdminController::class, 'generateAgendamentoPDF'])->name('admin.generate-agendamento-pdf');
        Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.destroy-user');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit-user'); 
        Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.update-user'); 

        // Rotas de Agendamentos dos usuários
        Route::get('/admin/users/{user}/agendamentos', [AdminController::class, 'show'])->name('admin.user-agendamentos');
        Route::delete('/admin/users/{user}/agendamentos/{agendamento}', [AdminController::class, 'destroy'])->name('admin.agendamento-destroy');
        Route::match(['post', 'delete'], '/admin/confirm-checklist', [AdminController::class, 'confirmChecklist'])->name('admin.confirmChecklist');
        Route::delete('/admin/agendamentos/{agendamento}', [AdminController::class, 'destroyAgendamento'])->name('agendamentos.destroy');

        // Rota para editar agendamentos
        Route::get('/admin/agendamentos/{agendamento}/edit', [AdminController::class, 'editAgendamento'])->name('admin.agendamento.edit');
        // Exclusão direta de agendamentos (se não for atrelada ao usuário diretamente)
        Route::delete('/admin/agendamentos/{agendamento}', [AdminController::class, 'destroyAgendamento'])->name('admin.agendamentos.destroy');
    });
    Route::get('/admin/limpar-entrada/{id}', [AdminController::class, 'limparEntrada'])->name('admin.limparEntrada');
    Route::get('/admin/limpar-saida/{id}', [AdminController::class, 'limparSaida'])->name('admin.limparSaida');
    Route::get('/admin/historico', [AdminController::class, 'historico'])->name('admin.historico');

    // Rotas de Agendamentos gerais
    Route::resource('agendamentos', AgendamentoController::class);
    // Rota para gerar o PDF de um agendamento específico
    Route::get('/agendamentos/{agendamento}/pdf', [AgendamentoController::class, 'generatePDF'])->name('agendamentos.pdf');
});

// Rotas de autenticação
require __DIR__.'/auth.php';
