<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agendamento;
use Illuminate\Http\Request;
use App\Models\AgendamentoLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Exibir o dashboard de administração.
     */
    public function dashboard()
    {
        // Carregar agendamentos com o relacionamento do usuário e logs
        $agendamentos = Agendamento::with('user', 'logs', 'equipamentos')->get();
    
        // Carregar os logs mais recentes com relacionamento de agendamento e usuário
        $logs = AgendamentoLog::all();
        $turnosCount = [
            'manhã' => Agendamento::where('turno', 'manhã')->count(),
            'tarde' => Agendamento::where('turno', 'tarde')->count(),
            'noite' => Agendamento::where('turno', 'noite')->count(),
        ];
        // Decodificar os equipamentos dos agendamentos e contar as solicitações
        $equipamentosCount = [];
        foreach ($agendamentos as $agendamento) {
            if (is_string($agendamento->equipamentos)) {
                $agendamento->equipamentos = json_decode($agendamento->equipamentos, true);
            }
            foreach ($agendamento->equipamentos as $equipamento => $detalhes) {
                if (!isset($equipamentosCount[$equipamento])) {
                    $equipamentosCount[$equipamento] = 0;
                }
                $equipamentosCount[$equipamento] += $detalhes['quantity'];
            }
        }
    
        // Ordenar os equipamentos por quantidade de solicitações
        arsort($equipamentosCount);
    
        // Separar as labels e os valores
        $equipamentosLabels = array_keys($equipamentosCount);
        $equipamentosDataValues = array_values($equipamentosCount);
    
        // Carregar os agendamentos mais recentes
        $recentAgendamentos = Agendamento::with('user')->orderBy('created_at', 'desc')->limit(5)->get();
    
        // Contar o total de usuários cadastrados
        $totalUsers = User::count();
    
        // Passar as variáveis para a view
        return view('admin.dashboard', compact('agendamentos', 'logs', 'totalUsers', 'recentAgendamentos', 'equipamentosLabels', 'equipamentosDataValues','turnosCount'));
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
    
        // Exclua o agendamento antes de criar o log
        $agendamento->delete();
    
        // Crie o log após o agendamento ser excluído
        AgendamentoLog::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => Auth::id(), // Usando Auth::id() para consistência
            'action' => 'deleted',
            'description' => 'Agendamento excluído por Admin',
        ]);
    
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
        // Validação dos campos
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|confirmed|min:8', // Senha opcional, mas se preenchida deve ser confirmada
        ]);
    
        // Atualiza os campos de nome e email
        $user->name = $validated['name'];
        $user->email = $validated['email'];
    
        // Atualiza a senha se fornecida
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
    
        // Salva as mudanças
        $user->save();
    
        // Log de atualização de perfil
        AgendamentoLog::create([
            'user_id' => Auth::id(), // Usando Auth::id() para consistência
            'action' => 'updated',
            'description' => "Perfil do usuário {$user->id} atualizado pelo Admin",
        ]);
    
        return redirect()->route('admin.users.show', $user->id)->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroyUser(User $user)
    {
        // Exclua todos os agendamentos relacionados ao usuário antes de excluir o usuário
        $user->agendamentos()->delete();
    
        // Exclua o usuário
        $user->delete();
    
        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso!');
    }

    public function confirmChecklist(Request $request)
    {
        if ($request->isMethod('post')) {
            // Capturar os dados enviados via formulário
            $agendamentosChecklist = $request->input('checklist', []);
    
            // Verificar se pelo menos um agendamento foi selecionado
            if (empty($agendamentosChecklist)) {
                return redirect()->route('admin.dashboard')->with('error', 'Nenhum agendamento foi selecionado.');
            }
    
            DB::beginTransaction(); // Inicia uma transação
    
            try {
                // Iterar sobre cada agendamento selecionado
                foreach ($agendamentosChecklist as $id => $action) {
                    $agendamento = Agendamento::find($id);
    
                    if ($agendamento) {
                        // Determinar a ação (entrada ou saída)
                        $currentAction = $action === 'entrada' ? 'entrada' : 'saida';
    
                        // Obter o último log para verificar a ação anterior
                        $lastLog = $agendamento->logs()->latest()->first();
    
                        // Criar um novo log se o último log não for da mesma ação
                        if (!$lastLog || $lastLog->action !== $currentAction) {
                            // Atualizar o status e marcar o checklist como concluído
                            $agendamento->update([
                                'status' => ucfirst($currentAction), // Atualiza o status com a ação atual (entrada ou saída)
                                'checklist_completed' => true,
                            ]);
    
                            // Criar um novo log para a ação atual
                            AgendamentoLog::create([
                                'agendamento_id' => $agendamento->id,
                                'user_id' => Auth::id(),
                                'action' => $currentAction,
                                'description' => 'Checklist confirmado pelo administrador como ' . $currentAction . '.',
                            ]);
                        }
                    }
                }
    
                DB::commit(); // Confirma a transação
                return redirect()->route('admin.dashboard')->with('success', 'Checklist confirmado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack(); // Reverte a transação em caso de erro
                return redirect()->route('admin.dashboard')->with('error', 'Erro ao confirmar o checklist: ' . $e->getMessage());
            }
        }
    
        // Redirecionar em caso de erro na confirmação do checklist
        return redirect()->route('admin.dashboard')->with('error', 'Erro ao confirmar o checklist.');
    }

    public function editAgendamento($id)
    {
        // Carregar o agendamento pelo ID
        $agendamento = Agendamento::findOrFail($id);
        // Define 'manhã' como turno padrão se o agendamento não tiver um turno definido
        if (empty($agendamento->turno)) {
            $agendamento->turno = 'manhã';
        }
        // Decodificar os equipamentos, se houver
        $agendamento->equipamentos = $agendamento->equipamentos ? json_decode($agendamento->equipamentos, true) : null;
    
        // Retornar a view correta para editar o agendamento
        return view('agendamentos.edit', compact('agendamento'));
    }

    public function destroyAgendamento(Agendamento $agendamento)
    {
        if (!$agendamento) {
            return redirect()->route('admin.dashboard')->with('error', 'Agendamento não encontrado.');
        }
    
        $agendamento->delete();
    
        return redirect()->route('dashboard')->with('success', 'Agendamento excluído com sucesso.');
    }
    public function limparEntrada($id)
{
    // Encontre o agendamento
    $agendamento = Agendamento::findOrFail($id);

    // Limpe o log de entrada associado ao agendamento
    AgendamentoLog::where('agendamento_id', $id)->where('action', 'entrada')->delete();

    return redirect()->back()->with('success', 'Entrada do agendamento limpa com sucesso.');
}

public function limparSaida($id)
{
    // Encontre o agendamento
    $agendamento = Agendamento::findOrFail($id);

    // Limpe o log de saída associado ao agendamento
    AgendamentoLog::where('agendamento_id', $id)->where('action', 'saida')->delete();

    return redirect()->back()->with('success', 'Saída do agendamento limpa com sucesso.');
}
public function historico()
{
    // Carregar os logs com relacionamento de agendamento
    $logs = AgendamentoLog::with('agendamento')->orderBy('created_at', 'desc')->get();

    // Retornar a view do histórico com os logs
    return view('admin.historico', compact('logs'));
}

}
