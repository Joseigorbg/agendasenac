@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-blue-600 mb-4">Dashboard de Administração</h2>

    <div class="mt-4">
        <a href="{{ route('admin.users.index') }}" class="inline-block bg-senacOrange text-white px-4 py-2 rounded-md hover:bg-orange-600 transition duration-300">Gerenciar Usuários</a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">{{ session('error') }}</div>
    @endif
</div>
@endsection
