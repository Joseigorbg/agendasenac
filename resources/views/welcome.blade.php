@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-fundo bg-cover bg-center bg-no-repeat">
    <div class="min-h-screen flex flex-col items-center justify-center bg-white bg-opacity-75 py-12 px-4 sm:px-6 lg:px-8 rounded-lg shadow-lg">
        <div class="text-center mb-8">
            <!-- Logo do Senac -->
            <img src="{{ asset('img/Senac_logo.svg.png') }}" alt="Senac Logo" class="h-16 lg:h-24 mx-auto mb-4">
            
            <!-- Texto de Boas-Vindas -->
            <h1 class="text-4xl font-bold text-senacBlue mb-4">Bem-vindo ao Senac!</h1>
            <p class="text-lg text-gray-700">Gerencie seus agendamentos de salas inovadoras com facilidade.</p>
        </div>

        <!-- Se o usuário estiver logado -->
        @auth
        <div class="flex flex-col items-center space-y-4">
            <p class="text-xl text-gray-700">Olá, {{ Auth::user()->name }}!</p>
            <a href="{{ route('dashboard') }}" class="bg-senacOrange text-white px-6 py-2 rounded-md hover:bg-orange-600 transition duration-300">
                Acessar Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded-md hover:bg-red-700 transition duration-300">
                    Sair
                </button>
            </form>
        </div>
        @endauth

        <!-- Se o usuário não estiver logado -->
        @guest
        <div class="flex justify-center space-x-4">
            <a href="{{ route('login') }}" class="bg-senacOrange text-white px-6 py-2 rounded-md hover:bg-orange-600 transition duration-300">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-senacBlue text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                Registrar-se
            </a>
        </div>
        @endguest
    </div>
</div>
@endsection
