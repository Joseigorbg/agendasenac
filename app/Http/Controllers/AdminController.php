<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use App\Models\AgendamentoLog;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * Exibir o dashboard de administração.
     */
    public function dashboard()
    {
        $agendamentos = Agendamento::all();
        $logs = AgendamentoLog::with('user', 'agendamento')->get(); // Inclui o relacionamento com usuário e agendamento
    
        return view('admin.dashboard', compact('agendamentos', 'logs'));
    }
    

    /**
     * Listar todos os usuários.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('matricula', 'like', "%{$search}%");
        })->paginate(10); // Paginação opcional

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Exibir detalhes de um usuário específico.
     */
    public function show(User $user)
    {
        // Obtém todos os agendamentos relacionados ao usuário
        $agendamentos = Agendamento::where('user_id', $user->id)->get();
    
        // Decodifica os equipamentos em cada agendamento
        foreach ($agendamentos as $agendamento) {
            $agendamento->equipamentos = $agendamento->equipamentos ? json_decode($agendamento->equipamentos) : null;
        }

        return view('admin.users.show', compact('user', 'agendamentos'));
    }
    
    

    /**
     * Deletar um agendamento de um usuário.
     */
    public function destroy(User $user, Agendamento $agendamento)
    {
        // Verifique se o agendamento pertence ao usuário
        if ($agendamento->user_id !== $user->id) {
            return redirect()->route('admin.users.show', $user->id)->with('error', 'Esse agendamento não pertence ao usuário.');
        }

        // Crie o log antes de excluir o agendamento
        AgendamentoLog::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => auth()->user()->id,
            'action' => 'deleted',
            'description' => 'Agendamento excluído por Admin',
        ]);
    
        // Exclua o agendamento após o log ser criado
        $agendamento->delete();

        return redirect()->route('admin.users.show', $user->id)->with('success', 'Agendamento excluído com sucesso!');
    }

    /**
     * Gerar um PDF com informações do usuário.
     */
    public function generatePDF(User $user)
    {
        $agendamentos = Agendamento::where('user_id', $user->id)->get();
        $pdf = Pdf::loadView('admin.users.pdf', compact('user', 'agendamentos'));
        

        return $pdf->download("usuario_{$user->id}.pdf");
    }

    public function generateAgendamentoPDF(User $user, Agendamento $agendamento)
    {
        if ($agendamento->user_id !== $user->id) {
            return redirect()->route('admin.users.show', $user->id)->with('error', 'Esse agendamento não pertence ao usuário.');
        }
    
        $agendamento->equipamentos = json_decode($agendamento->equipamentos, true);
        $pdf = Pdf::loadView('admin.users.agendamento_pdf', compact('user', 'agendamento'));
        

        return $pdf->download("agendamento_usuario_{$user->id}_agendamento_{$agendamento->id}.pdf");
    }        

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:user,admin',
        ]);

        $user->update($validated);

        // Log de atualização de perfil
        AgendamentoLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'updated',
            'description' => "Perfil do usuário {$user->id} atualizado pelo Admin",
        ]);

        return redirect()->route('admin.users.show', $user->id)->with('success', 'Perfil atualizado com sucesso!');
    }
    public function destroyUser(User $user)
    {
        // Exclua todos os agendamentos relacionados ao usuário antes de excluir o usuário
        $user->agendamentos()->delete();
    
        // Crie um log de exclusão de usuário
        AgendamentoLog::create([
            'user_id' => auth()->user()->id,
            'agendamento_id' => null, // Não há agendamento nesse caso
            'action' => 'deleted',
            'description' => "Usuário {$user->id} excluído pelo Admin",
        ]);
    
        // Exclua o usuário
        $user->delete();
    
        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }
    
}
