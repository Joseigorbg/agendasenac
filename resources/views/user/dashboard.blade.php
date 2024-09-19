@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Meus Agendamentos</h1>

    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Instrutor</th>
                <th class="border px-4 py-2">Sala</th>
                <th class="border px-4 py-2">Data Início</th>
                <th class="border px-4 py-2">Data Fim</th>
                <th class="border px-4 py-2">Turno</th>
                <th class="border px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendamentos as $agendamento)
                <tr>
                    <td class="border px-4 py-2">{{ $agendamento->instrutor }}</td>
                    <td class="border px-4 py-2">{{ $agendamento->sala }}</td>
                    <td class="border px-4 py-2">{{ $agendamento->data_inicio }}</td>
                    <td class="border px-4 py-2">{{ $agendamento->data_fim }}</td>
                    <td class="border px-4 py-2">{{ $agendamento->turno }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="btn btn-primary">Editar</a>
                        <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Deletar</button>
                        </form>
                        <a href="{{ route('agendamentos.pdf', $agendamento->id) }}" class="btn btn-secondary">Gerar PDF</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
