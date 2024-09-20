@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-lg lg:max-w-3xl bg-white shadow-md rounded-lg p-6 lg:p-12 transition-all duration-300">
        <h2 class="text-center text-3xl lg:text-4xl font-extrabold text-senacBlue mb-6 lg:mb-8">{{ __('Confirme sua Senha') }}</h2>

        <p class="text-center text-gray-600 mb-6 lg:mb-8">
            {{ __('Por favor, confirme sua senha antes de continuar.') }}
        </p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4 lg:mb-6">
                <label for="password" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Senha') }}</label>
                <input id="password" type="password" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('password') border-red-500 @enderror" name="password" required autofocus>
                @error('password')
                    <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full bg-senacOrange text-white py-2 lg:py-3 px-4 rounded-md hover:bg-orange-600 transition duration-300 lg:text-lg">
                    {{ __('Confirmar Senha') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
