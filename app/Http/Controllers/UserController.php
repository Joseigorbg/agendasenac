<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AgendamentoLog;
use App\Models\Agendamento;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Obtém os agendamentos e logs relacionados ao usuário autenticado
        $agendamentos = Agendamento::where('user_id', $user->id)->get();
        $logs = AgendamentoLog::where('user_id', $user->id)->with('agendamento')->get();
    
        return view('dashboard', compact('agendamentos', 'logs'));
    }
    
}
