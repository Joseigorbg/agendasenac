@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-lg lg:max-w-3xl bg-white shadow-md rounded-lg p-6 lg:p-12 transition-all duration-300">
        <h2 class="text-center text-3xl lg:text-4xl font-extrabold text-senacBlue mb-6 lg:mb-8">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4 lg:mb-6">
                <label for="login" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Email or Matrícula') }}</label>
                <input id="login" type="text" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('login') border-red-500 @enderror" name="login" value="{{ old('login') }}" required autofocus>
                @error('login')
                    <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 lg:mb-6">
                <label for="password" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('password') border-red-500 @enderror" name="password" required>
                @error('password')
                    <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <div class="text-sm lg:text-base">
                    <a href="{{ route('password.request') }}" class="font-medium text-senacBlue hover:text-senacOrange transition duration-300">
                        {{ __('Esqueceu a senha?') }}
                    </a>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full bg-senacOrange text-white py-2 lg:py-3 px-4 rounded-md hover:bg-orange-600 transition duration-300 lg:text-lg">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
