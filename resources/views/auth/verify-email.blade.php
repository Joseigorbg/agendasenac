@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-lg lg:max-w-3xl bg-white shadow-md rounded-lg p-6 lg:p-12 transition-all duration-300">
        <h2 class="text-center text-3xl lg:text-4xl font-extrabold text-senacBlue mb-6 lg:mb-8">{{ __('Verificação de E-mail') }}</h2>

        <p class="text-center text-gray-600 mb-6 lg:mb-8">
            {{ __('Antes de continuar, por favor, verifique seu e-mail para o link de confirmação.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm text-green-600 text-center">
                {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div class="mb-4 lg:mb-6">
                <button type="submit" class="w-full bg-senacOrange text-white py-2 lg:py-3 px-4 rounded-md hover:bg-orange-600 transition duration-300 lg:text-lg">
                    {{ __('Reenviar E-mail de Verificação') }}
                </button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <div>
                <button type="submit" class="w-full bg-gray-400 text-white py-2 lg:py-3 px-4 rounded-md hover:bg-gray-500 transition duration-300 lg:text-lg">
                    {{ __('Sair') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
