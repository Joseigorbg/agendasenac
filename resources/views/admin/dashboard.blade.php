@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="row">
        <div class="col-12">
            <h1 class="text-4xl font-bold mt-4 text-gray-800">Painel de Controle</h1>
            <nav class="breadcrumb mb-4">
                <li class="breadcrumb-item active text-gray-500">Admin Dashboard</li>
            </nav>
        </div>
    </div>

    <!-- Cards para resumo de agendamentos e logs -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-gradient-to-r from-indigo-400 to-indigo-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="text-lg font-medium">Total de Agendamentos</div>
            <div class="text-4xl font-bold">{{ $agendamentos->count() }}</div>
        </div>
        <div class="bg-gradient-to-r from-teal-400 to-teal-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="text-lg font-medium">Total de Entradas</div>
            <div class="text-4xl font-bold">{{ $logs->where('action', 'entrada')->count() }}</div>
        </div>
        <div class="bg-gradient-to-r from-orange-400 to-orange-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="text-lg font-medium">Total de Saídas</div>
            <div class="text-4xl font-bold">{{ $logs->where('action', 'saida')->count() }}</div>
        </div>
    </div>
    <!-- Checklist de agendamentos -->
    <form action="{{ route('admin.confirmChecklist') }}" method="POST">
        @csrf
        <div class="bg-white shadow-lg rounded-lg mt-8 p-6">
            <div class="font-semibold text-2xl mb-4 text-gray-700">Checklist de Agendamentos</div>
            <table class="min-w-full table-auto">
                <thead class="border-b">
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">ID</th>
                        <th class="px-4 py-2 text-left">Usuário</th>
                        <th class="px-4 py-2 text-left">Início</th>
                        <th class="px-4 py-2 text-left">Fim</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Equipamentos</th>
                        <th class="px-4 py-2 text-left">Entrada</th>
                        <th class="px-4 py-2 text-left">Saída</th>
                        <th class="px-4 py-2 text-left">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agendamentos as $agendamento)
                    <tr class="border-b hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-4 py-2">{{ $agendamento->id }}</td>
                        <td class="px-4 py-2">{{ $agendamento->user->name }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($agendamento->data_inicio)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($agendamento->data_fim)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            @php
                                $lastLog = $logs->where('agendamento_id', $agendamento->id)->last();
                                $status = $lastLog ? ucfirst($lastLog->action) : 'Pendente';
                                $statusClass = $status === 'Entrada' ? 'bg-green-100 text-green-800' : ($status === 'Saída' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800');
                            @endphp
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}" id="status-{{ $agendamento->id }}">
                                {{ $status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            @if($agendamento->equipamentos && is_array($agendamento->equipamentos))
                                <div class="grid grid-cols-1 gap-2">
                                    @foreach($agendamento->equipamentos as $equipamento => $detalhes)
                                        @if($detalhes['quantity'] > 0)
                                            <div class="flex items-center">
                                                <span class="mr-2 text-gray-700 font-semibold">
                                                    {{ ucfirst(str_replace('_', ' ', $equipamento)) }}:
                                                </span>
                                                <span class="text-white bg-blue-500 px-2 py-1 rounded-md text-sm font-bold">
                                                    {{ $detalhes['quantity'] }}
                                                </span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-500">Nenhum equipamento agendado</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="checklist[{{ $agendamento->id }}]" value="entrada" class="form-radio h-5 w-5 text-green-500"
                                    @if($lastLog && $lastLog->action == 'entrada') checked @endif
                                    onchange="updateStatus({{ $agendamento->id }}, 'Entrada')">
                                <span class="text-green-700 font-semibold">Entrada <i class="fas fa-sign-in-alt"></i></span>
                            </label>
                            <a href="{{ route('admin.limparEntrada', $agendamento->id) }}" 
                               class="text-sm text-gray-500 hover:text-red-600 flex items-center mt-2" title="Limpar Entrada">
                               <i class="fas fa-times-circle mr-1"></i> Limpar Entrada
                            </a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="checklist[{{ $agendamento->id }}]}" value="saida" class="form-radio h-5 w-5 text-red-500"
                                    @if($lastLog && $lastLog->action == 'saida') checked @endif
                                    onchange="updateStatus({{ $agendamento->id }}, 'Saída')">
                                <span class="text-red-700 font-semibold">Saída <i class="fas fa-sign-out-alt"></i></span>
                            </label>
                            <a href="{{ route('admin.limparSaida', $agendamento->id) }}" 
                               class="text-sm text-gray-500 hover:text-red-600 flex items-center mt-2" title="Limpar Saída">
                               <i class="fas fa-times-circle mr-1"></i> Limpar Saída
                            </a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('agendamentos.edit', $agendamento->id) }}" 
                               class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600 transition duration-300">
                               Editar
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="mt-6 bg-green-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-700 transition duration-300">
            Confirmar Checklist
        </button>
    </form>

    <!-- Seção de gráficos atualizada -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        <!-- Gráfico de Pizza -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Distribuição de Status dos Agendamentos</h2>
            <canvas id="statusPieChart"></canvas>
        </div>

        <!-- Gráfico de Barra -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Agendamentos por Turno</h2>
            <canvas id="turnosBarChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Linha -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h2 class="text-xl font-semibold mb-4">Equipamentos Mais Solicitados</h2>
        <canvas id="equipamentosBarChart"></canvas>
    </div>
</div>

<script>
    var statusDataValues = [
        {{ $logs->where('action', 'entrada')->count() }},
        {{ $logs->where('action', 'saida')->count() }},
    ];

    var turnosDataValues = [
        {{ $turnosCount['manhã'] }},
        {{ $turnosCount['tarde'] }},
        {{ $turnosCount['noite'] }}
    ];

    var equipamentosLabels = {!! json_encode($equipamentosLabels) !!};
    var equipamentosDataValues = {!! json_encode($equipamentosDataValues) !!};
</script>


<script>
function updateStatus(agendamentoId, action) {
    let statusElement = document.getElementById(`status-${agendamentoId}`);
    statusElement.textContent = action;
    if (action === 'Entrada') {
        statusElement.className = 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
    } else {
        statusElement.className = 'px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
    }
}
</script>

@endsection
