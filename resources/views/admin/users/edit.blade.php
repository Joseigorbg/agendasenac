@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Editar Perfil do Usuário</h1>

    <form action="{{ route('admin.update-user', $user->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Nome:</label>
            <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">Email:</label>
            <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-input mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-semibold">Função:</label>
            <select id="role" name="role" class="form-select mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuário</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>

        <button type="submit" class="bg-senacOrange text-white px-4 py-2 rounded-md hover:bg-orange-600 transition duration-300 mt-4">
            Atualizar Perfil
        </button>
    </form>
</div>
@endsection
