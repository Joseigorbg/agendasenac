<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\EquipamentoTrait;

class AgendamentoController extends Controller
{
    use EquipamentoTrait;

    /**
     * Exibir uma lista de todos os agendamentos do usuário autenticado.
     */
    public function index()
    {
        // Obtém o usuário autenticado
        $user = auth()->user();

        // Obtém os agendamentos relacionados ao usuário autenticado
        $agendamentos = Agendamento::where('user_id', $user->id)->get();

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

        // Captura e codifica os equipamentos como JSON
        $validated['equipamentos'] = json_encode($this->capturaEquipamentos($request));

        // Adiciona o user_id ao agendamento
        $validated['user_id'] = auth()->id();

        Agendamento::create($validated);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
    }

    /**
     * Exibir o formulário para editar um agendamento existente.
     */
    public function edit(Agendamento $agendamento)
    {
        // Verifica se o agendamento pertence ao usuário autenticado
        if ($agendamento->user_id !== auth()->id()) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para editar este agendamento.');
        }

        // Decodificar os equipamentos para exibir no formulário
        $agendamento->equipamentos = json_decode($agendamento->equipamentos, true);

        return view('agendamentos.edit', compact('agendamento'));
    }

    /**
     * Atualizar um agendamento existente no banco de dados.
     */
    public function update(Request $request, Agendamento $agendamento)
    {
        // Verifica se o agendamento pertence ao usuário autenticado
        if ($agendamento->user_id !== auth()->id()) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para editar este agendamento.');
        }

        $validated = $request->validate([
            'instrutor'    => 'required|string|max:255',
            'sala'         => 'required|string|max:255',
            'data_inicio'  => 'required|date',
            'data_fim'     => 'required|date|after_or_equal:data_inicio',
            'turno'        => 'required|string|in:manhã,tarde,noite',
        ]);

        // Captura e codifica os equipamentos como JSON
        $validated['equipamentos'] = json_encode($this->capturaEquipamentos($request));

        $agendamento->update($validated);

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    /**
     * Deletar um agendamento existente do banco de dados.
     */
    public function destroy(Agendamento $agendamento)
    {
        // Verifica se o agendamento pertence ao usuário autenticado
        if ($agendamento->user_id !== auth()->id()) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para deletar este agendamento.');
        }

        $agendamento->delete();

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento deletado com sucesso!');
    }

    /**
     * Gerar um PDF do agendamento.
     */
    public function generatePDF(Agendamento $agendamento)
    {
        // Verifica se o agendamento pertence ao usuário autenticado
        if ($agendamento->user_id !== auth()->id()) {
            return redirect()->route('agendamentos.index')->with('error', 'Você não tem permissão para visualizar este agendamento.');
        }

        $pdf = Pdf::loadView('agendamentos.pdf', compact('agendamento'));
        return $pdf->download('agendamento.pdf');
    }
}
