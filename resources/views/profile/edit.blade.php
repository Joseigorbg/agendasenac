@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-semibold text-senacBlue mb-4">Meu Perfil</h2>
    <!-- Informações do Usuário -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <p class="text-lg"><strong>Nome:</strong> {{ $user->name }}</p>
        <p class="text-lg"><strong>Email:</strong> {{ $user->email }}</p>
    </div>

    <h3 class="text-xl font-semibold text-senacBlue mt-6">Meus Agendamentos</h3>
    <a href="{{ route('agendamentos.create') }}" class="inline-block bg-senacOrange text-white px-4 py-2 rounded-md mb-4 hover:bg-orange-600 transition duration-300">Criar Novo Agendamento</a>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if($agendamentos->isEmpty())
        <p class="text-gray-500">Nenhum agendamento encontrado.</p>
    @else
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-senacBlue text-white">
                <tr>
                    <th class="py-3 px-4">Instrutor</th>
                    <th class="py-3 px-4">Sala</th>
                    <th class="py-3 px-4">Data de Início</th>
                    <th class="py-3 px-4">Data de Fim</th>
                    <th class="py-3 px-4">Turno</th>
                    <th class="py-3 px-4">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-700">
                @foreach($agendamentos as $agendamento)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $agendamento->instrutor }}</td>
                        <td class="py-3 px-4">{{ $agendamento->sala }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($agendamento->data_inicio)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($agendamento->data_fim)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">{{ ucfirst($agendamento->turno) }}</td>
                        <td class="py-3 px-4 space-x-2">
                            <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600">Editar</a>
                            <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600" onclick="return confirm('Tem certeza que deseja deletar este agendamento?')">Deletar</button>
                            </form>
                            <a href="{{ route('agendamentos.pdf', $agendamento->id) }}" class="bg-gray-500 text-white px-2 py-1 rounded-md hover:bg-gray-600">PDF</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
