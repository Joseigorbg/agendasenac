<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\EquipamentoTrait;
use App\Models\AgendamentoLog;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    use EquipamentoTrait;

    /**
     * Exibir uma lista de todos os agendamentos do usuário autenticado.
     */
    public function index()
    {
        // Obtém os agendamentos relacionados ao usuário autenticado
        $agendamentos = Agendamento::where('user_id', Auth::id())->get();

        // Decodificar o JSON dos equipamentos para cada agendamento, se existir
        foreach ($agendamentos as $agendamento) {
            $agendamento->equipamentos = $agendamento->equipamentos ? json_decode($agendamento->equipamentos) : null;
        }

        return view('agendamentos.index', compact('agendamentos'));
    }

    /**
     * Exibir o formulário para criar um novo agendamento.
     */
    public function create()
    {
        return view('agendamentos.create');
    }

    /**
     * Armazenar um novo agendamento no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instrutor'    => 'required|string|max:255',
            'sala'         => 'required|string|max:255',
            'data_inicio'  => 'required|date',
            'data_fim'     => 'required|date|after_or_equal:data_inicio',
            'turno'        => 'required|string|in:manhã,tarde,noite',
        ]);

        $validated['equipamentos'] = json_encode($this->capturaEquipamentos($request));
        $validated['user_id'] = Auth::id();

        $agendamento = Agendamento::create($validated);

        // Registrar log da ação de criação
        AgendamentoLog::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Agendamento criado por ' . Auth::user()->name,
        ]);

        // Define 'manhã' como turno padrão se o agendamento não tiver um turno definido
        if (empty($agendamento->turno)) {
            $agendamento->turno = 'manhã';
        }

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
    }

    /**
     * Exibir o formulário para editar um agendamento existente.
     */
    public function edit(Agendamento $agendamento)
    {
        // Define 'manhã' como turno padrão se o agendamento não tiver um turno definido
        if (empty($agendamento->turno)) {
            $agendamento->turno = 'manhã';
        }

        // Verifica se o usuário tem permissão para editar o agendamento
        if (!Auth::user()->can('update', $agendamento)) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para editar este agendamento.');
        }

        // Decodificar os equipamentos para exibir no formulário
        $agendamento->equipamentos = json_decode($agendamento->equipamentos, true);

        return view('agendamentos.edit', compact('agendamento'));
    }

    /**
     * Atualizar um agendamento existente.
     */
    public function update(Request $request, Agendamento $agendamento)
    {
        // Verifica se o usuário tem permissão para atualizar o agendamento
        if (!Auth::user()->can('update', $agendamento)) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para atualizar este agendamento.');
        }

        $validated = $request->validate([
            'instrutor'    => 'required|string|max:255',
            'sala'         => 'required|string|max:255',
            'data_inicio'  => 'required|date',
            'data_fim'     => 'required|date|after_or_equal:data_inicio',
            'turno'        => 'required|string|in:manhã,tarde,noite',
        ]);

        // Registrar log da ação de atualização
        AgendamentoLog::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Agendamento atualizado por ' . Auth::user()->name,
        ]);

        // Captura e codifica os equipamentos como JSON
        $validated['equipamentos'] = json_encode($this->capturaEquipamentos($request));

        $agendamento->update($validated);

        // Redirecionar para a página de gerenciamento de usuários se for administrador
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.users.show', ['user' => $agendamento->user_id])->with('success', 'Agendamento atualizado com sucesso!');
        }

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Deletar um agendamento existente do banco de dados.
     */
    public function destroy(Agendamento $agendamento)
    {
        // Verifica se o usuário tem permissão para deletar o agendamento
        if (!Auth::user()->can('delete', $agendamento)) {
            return redirect()->route('admin.users.show', $agendamento->user_id)->with('error', 'Você não tem permissão para deletar este agendamento.');
        }     

        // Registrar log da ação de exclusão antes de deletar
        AgendamentoLog::create([
            'agendamento_id' => $agendamento->id,
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Agendamento excluído por ' . Auth::user()->name,
        ]);     

        // Exclua o agendamento após o log ser criado
        $agendamento->delete();     

        // Redireciona para a página do usuário correspondente se for administrador
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.users.show', ['user' => $agendamento->user_id])->with('success', 'Agendamento deletado com sucesso!');
        }     

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento deletado com sucesso!');
    }

    /**
     * Gerar um PDF do agendamento.
     */
    public function generatePDF(Agendamento $agendamento)
    {
        // Verifica se o agendamento pertence ao usuário autenticado
        if ($agendamento->user_id !== Auth::id()) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para visualizar este agendamento.');
        }

        // Decodificar os equipamentos para passar ao PDF
        $agendamento->equipamentos = json_decode($agendamento->equipamentos, true);

        // Gerar o PDF com os dados do agendamento
        $pdf = Pdf::loadView('agendamentos.pdf', compact('agendamento'));
        return $pdf->download('agendamento.pdf');
    }
}
