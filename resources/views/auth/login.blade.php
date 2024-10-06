@extends('layouts.app')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat" 
     style="background-image: url('{{ asset('img/fundo.jpg') }}'); background-size: cover; background-position: center;">

    <div class="min-h-screen flex items-center justify-center bg-black bg-opacity-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg lg:max-w-3xl bg-white shadow-md rounded-lg p-6 lg:p-12 transition-all duration-300">
            <div class="flex justify-center mb-6 lg:mb-8">
                <img src="{{ asset('img/Senac_logo.svg.png') }}" alt="Senac Logo" class="h-12 lg:h-16"> <!-- Adaptei a altura da logo -->
            </div>    

            <!-- Texto de Boas-Vindas -->
            <div class="text-center mb-6 lg:mb-8">
                <h2 class="mt-4 text-2xl lg:text-3xl font-bold text-gray-800">Área do Aluno</h2>
                <p class="mt-2 text-sm lg:text-base text-gray-600">Seja bem-vindo. Faça o login para agendar uma sala inovadora.</p>
            </div>    

            <!-- Título Login -->
            <h2 class="text-center text-3xl lg:text-4xl font-extrabold text-senacBlue mb-6 lg:mb-8">{{ __('Login') }}</h2>

            <!-- Formulário de Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf    

                <div class="mb-4 lg:mb-6">
                    <label for="login" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Email ou Matrícula') }}</label>
                    <input id="login" type="text" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('login') border-red-500 @enderror" name="login" value="{{ old('login') }}" required autofocus>
                    @error('login')
                        <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                    @enderror
                </div>    

                <div class="mb-4 lg:mb-6">
                    <label for="password" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Senha') }}</label>
                    <input id="password" type="password" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('password') border-red-500 @enderror" name="password" required>
                    @error('password')
                        <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-4 lg:mb-6">
                    <div class="text-sm lg:text-base">
                        <a href="{{ route('password.request') }}" class="font-medium text-senacBlue hover:text-senacOrange transition duration-300">
                            {{ __('Esqueceu sua senha?') }}
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full bg-senacOrange text-white py-2 lg:py-3 px-4 rounded-md hover:bg-orange-600 transition duration-300 lg:text-lg">
                        {{ __('Entrar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
