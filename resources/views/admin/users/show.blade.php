@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
        <!-- Mensagem de sucesso -->
        @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            <strong class="font-bold">Sucesso!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
    <h2 class="text-2xl font-bold text-senacBlue mb-4">Informações do Usuário</h2>

    <!-- Exibir informações do usuário -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Detalhes do Usuário</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nome</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->name }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Cargo</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->cargo }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Matrícula</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->matricula }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">E-mail</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $user->email }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Função</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ ucfirst($user->role) }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Botão para editar o usuário -->
    <div class="mt-6">
        <a href="{{ route('admin.edit-user', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
            Editar Usuário
        </a>
    </div>

    <!-- Exibir agendamentos do usuário -->
    <h2 class="text-2xl font-bold text-senacBlue mt-8 mb-4">Agendamentos</h2>

    @if($agendamentos->isEmpty())
        <p class="text-gray-500">Nenhum agendamento encontrado para este usuário.</p>
    @else
        <!-- Tabela de agendamentos -->
        <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-senacBlue text-white">
                <tr>
                    <th class="py-3 px-4">Instrutor</th>
                    <th class="py-3 px-4">Sala</th>
                    <th class="py-3 px-4">Data de Início</th>
                    <th class="py-3 px-4">Data de Fim</th>
                    <th class="py-3 px-4">Turno</th>
                    <th class="py-3 px-4">Equipamentos</th>
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
                        <td class="py-3 px-4">
                            <!-- Botão para abrir o modal -->
                            <button class="bg-senacOrange text-white px-4 py-2 rounded-md hover:bg-orange-600 transition duration-300" onclick="openModal({{ $agendamento->id }})">Visualizar Equipamentos</button>
                        </td>
                        <td class="py-3 px-4 space-x-2">
                            <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600 transition duration-300">Editar</a>
                            <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 transition duration-300" onclick="return confirm('Tem certeza que deseja deletar este agendamento?')">Deletar</button>
                            </form>
                            <a href="{{ route('admin.generate-agendamento-pdf', ['user' => $user->id, 'agendamento' => $agendamento->id]) }}" class="bg-gray-500 text-white px-2 py-1 rounded-md hover:bg-gray-600 transition duration-300">PDF</a>

                        </td>
                    </tr>

                    <!-- Modal para exibir equipamentos -->
                    <div id="modal-{{ $agendamento->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white w-1/3 p-6 rounded-lg shadow-lg border-4 border-senacOrange text-center relative">
                            <h3 class="text-xl font-bold text-senacOrange mb-4">Equipamentos</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if ($agendamento->equipamentos)
                                    @foreach (['notebooks', 'projetor', 'camera_fotografica', 'tripe', 'fonte_caixa_som', 'microfone', 'caneta_quadro_interativo', 'controle_tv', 'controle_projetor'] as $equipamento)
                                        <div class="flex items-center justify-between">
                                            <label class="flex items-center text-gray-900 shadow-sm">
                                                {{ ucfirst(str_replace('_', ' ', $equipamento)) }}
                                            </label>
                                            <!-- Quantidade do equipamento -->
                                            <span class="text-gray-700">{{ $agendamento->equipamentos[$equipamento]['quantity'] ?? 0 }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <p>Nenhum equipamento solicitado.</p>
                                @endif
                            </div>
                            <button class="absolute top-0 right-0 mt-2 mr-2 text-gray-500 hover:text-black" onclick="closeModal({{ $agendamento->id }})">&times;</button>
                        </div>
                    </div>

                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection