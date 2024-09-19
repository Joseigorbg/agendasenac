@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-senacBlue mb-4">Editar Agendamento</h1>

    <div x-data="{ open: false, selectedEquipments: {{ json_encode(array_keys($agendamento->equipamentos ?? [])) }} }">
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
                <select id="turno" name="turno" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange">
                    <option value="manhã" {{ $agendamento->turno == 'manhã' ? 'selected' : '' }}>Manhã</option>
                    <option value="tarde" {{ $agendamento->turno == 'tarde' ? 'selected' : '' }}>Tarde</option>
                    <option value="noite" {{ $agendamento->turno == 'noite' ? 'selected' : '' }}>Noite</option>
                </select>
            </div>

            <!-- Botão para abrir o modal -->
            <button type="button" @click="open = true" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                Editar Equipamentos
            </button>

            <!-- Botão para atualizar o agendamento -->
            <button type="submit" class="bg-senacOrange text-white px-4 py-2 rounded-md hover:bg-orange-600 transition duration-300 mt-4">
                Atualizar Agendamento
            </button>
        </form>

        <!-- Modal popup para edição de equipamentos -->
        <div x-show="open" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div @click.away="open = false" class="bg-white border-4 border-senacOrange rounded-lg shadow-lg w-11/12 lg:w-1/2 p-6 transform transition-transform ease-out duration-300" x-transition:enter="scale-90 opacity-0" x-transition:enter-start="scale-90 opacity-0" x-transition:enter-end="scale-100 opacity-100" x-transition:leave="scale-90 opacity-0">
                <h2 class="text-xl font-semibold mb-4 text-gray-900 shadow-sm">Editar Equipamentos</h2>

                <!-- Formulário de seleção de equipamentos -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach (['notebooks', 'projetor', 'camera_fotografica', 'tripe', 'fonte_caixa_som', 'microfone', 'caneta_quadro_interativo', 'controle_tv', 'controle_projetor'] as $equipamento)
                    <div class="flex items-center justify-between">
                        <label class="flex items-center text-gray-900 shadow-sm">
                            <input type="checkbox" name="equipamentos[{{ $equipamento }}][selected]" value="1" class="mr-2" @change="selectedEquipments.includes('{{ $equipamento }}') ? selectedEquipments = selectedEquipments.filter(e => e !== '{{ $equipamento }}') : selectedEquipments.push('{{ $equipamento }}')" {{ isset($agendamento->equipamentos[$equipamento]) ? 'checked' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $equipamento)) }}
                        </label>
                        <!-- Campo de quantidade -->
                        <input type="number" name="equipamentos[{{ $equipamento }}][quantity]" min="1" value="{{ $agendamento->equipamentos[$equipamento]['quantity'] ?? 1 }}" class="form-input mt-1 w-20 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange" x-show="selectedEquipments.includes('{{ $equipamento }}')" placeholder="Qtd">
                    </div>
                    @endforeach
                </div>

                <!-- Botões de ação -->
                <div class="flex justify-end mt-4">
                    <button type="button" @click="open = false" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-300">
                        Cancelar
                    </button>
                    <button type="button" @click="open = false" class="bg-senacOrange text-white px-4 py-2 ml-2 rounded-md hover:bg-orange-600 transition duration-300">
                        Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
