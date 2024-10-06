@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">

    <!-- Título da página -->
    <h2 class="text-2xl font-bold text-senacBlue mb-6">Histórico de Ações</h2>

    <!-- Verificação se há logs para exibir -->
    @if(isset($logs) && $logs->isNotEmpty())
        <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden mb-6">
            <thead class="bg-senacBlue text-white">
                <tr>
                    <th class="py-3 px-4 text-left">Usuário</th>
                    <th class="py-3 px-4 text-left">Ação</th>
                    <th class="py-3 px-4 text-left">Agendamento</th>
                    <th class="py-3 px-4 text-left">Descrição</th>
                    <th class="py-3 px-4 text-left">Data</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-200">

                <!-- Loop pelos logs -->
                @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $log->user->name }}</td>
                        <td class="py-3 px-4">{{ $log->action }}</td>
                        <td class="py-3 px-4">
                            @if($log->agendamento)
                                #{{ $log->agendamento->id }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $log->description }}</td>
                        <td class="py-3 px-4">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    <!-- Caso não haja logs -->
    @else
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-md mb-6">
            <p class="text-center">Nenhuma ação registrada no momento.</p>
        </div>
    @endif
</div>
@endsection
