@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-senacBlue mb-4">Editar Agendamento</h1>

    <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="instrutor" class="block text-gray-700 font-semibold">Instrutor:</label>
            <input type="text" id="instrutor" name="instrutor" value="{{ $agendamento->instrutor }}" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" required>
        </div>

        <div class="mb-4">
            <label for="sala" class="block text-gray-700 font-semibold">Sala:</label>
            <input type="text" id="sala" name="sala" value="{{ $agendamento->sala }}" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" required>
        </div>

        <div class="mb-4">
            <label for="data_inicio" class="block text-gray-700 font-semibold">Data Início:</label>
            <input type="date" id="data_inicio" name="data_inicio" value="{{ $agendamento->data_inicio }}" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" required>
        </div>

        <div class="mb-4">
            <label for="data_fim" class="block text-gray-700 font-semibold">Data Fim:</label>
            <input type="date" id="data_fim" name="data_fim" value="{{ $agendamento->data_fim }}" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" required>
        </div>

        <div class="mb-4">
            <label for="turno" class="block text-gray-700 font-semibold">Turno:</label>
            <select id="turno" name="turno" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" required>
                <option value="">Escolha um turno</option>
                <option value="manhã" {{ $agendamento->turno == 'manhã' ? 'selected' : '' }}>Manhã</option>
                <option value="tarde" {{ $agendamento->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                <option value="noite" {{ $agendamento->turno == 'noite' ? 'selected' : '' }}>Noite</option>
            </select>
        </div>


        <!-- Seção de edição de equipamentos -->
        <h2 class="text-xl font-semibold mb-4 text-gray-900 shadow-sm">Editar Equipamentos</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach (['notebooks', 'projetor', 'camera_fotografica', 'tripe', 'fonte_caixa_som', 'microfone', 'caneta_quadro_interativo', 'controle_tv', 'controle_projetor'] as $equipamento)
                <div class="flex items-center justify-between">
                    <label class="flex items-center text-gray-900 shadow-sm">
                        {{ ucfirst(str_replace('_', ' ', $equipamento)) }}
                    </label>
                    <!-- Campo de quantidade -->
                    <input type="number" name="equipamentos[{{ $equipamento }}][quantity]" min="0" value="{{ $agendamento->equipamentos[$equipamento]['quantity'] ?? 0 }}" class="form-input mt-1 w-20 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" placeholder="Qtd">
                </div>
            @endforeach
        </div>

        <!-- Botão para atualizar o agendamento -->
        <button type="submit" class="bg-senacOrange text-white px-4 py-2 rounded-md hover:bg-orange-600 transition duration-300 mt-4">
            Atualizar Agendamento
        </button>
    </form>

    <!-- Formulário para excluir o agendamento -->
    <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="mt-6">
        @csrf
        @method('DELETE')

        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition duration-300" onclick="return confirm('Você tem certeza que deseja excluir este agendamento?');">
            Excluir Agendamento
        </button>
    </form>
</div>
@endsection
