@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-senacBlue mb-4">Gerenciar Usuários</h1>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4">
        <div class="flex">
            <input type="text" name="search" class="form-input rounded-l-md border-r-0 shadow" placeholder="Buscar usuários..." value="{{ request('search') }}">
            <button class="bg-senacBlue text-white px-4 py-2 rounded-r-md hover:bg-senacDark transition duration-300">Buscar</button>
        </div>
    </form>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
            <thead class="bg-senacBlue text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Nome</th>
                    <th class="py-3 px-4">Matrícula</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Cargo</th>
                    <th class="py-3 px-4">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center text-gray-700">
                @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-100 transition duration-200">
                        <td class="py-3 px-4">{{ $user->id }}</td>
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->matricula }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">{{ ucfirst($user->cargo) }}</td>
                        <td class="py-3 px-4 space-x-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="bg-senacBlue text-white px-2 py-1 rounded-md hover:bg-senacDark transition duration-300">Ver</a>
                            <a href="{{ route('admin.users.pdf', $user) }}" class="bg-gray-500 text-white px-2 py-1 rounded-md hover:bg-gray-600 transition duration-300">PDF</a>
                            <form action="{{ route('admin.destroy-user', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 transition duration-300">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-gray-500">Nenhum usuário encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
