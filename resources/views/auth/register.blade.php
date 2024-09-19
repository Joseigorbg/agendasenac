@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-lg lg:max-w-3xl bg-white shadow-md rounded-lg p-6 lg:p-12 transition-all duration-300">
        <h2 class="text-center text-3xl lg:text-4xl font-extrabold text-senacBlue mb-6 lg:mb-8">{{ __('Register') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4 lg:mb-6">
                <label for="name" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Name') }}</label>
                <input id="name" type="text" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 lg:mb-6">
                <label for="cargo" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Cargo') }}</label>
                <input id="cargo" type="text" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('cargo') border-red-500 @enderror" name="cargo" value="{{ old('cargo') }}" required>
                @error('cargo')
                    <span class="text-red-500 text-sm lg:text-base">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4 lg:mb-6">
                <label for="email" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
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

            <div class="mb-4 lg:mb-6">
                <label for="password-confirm" class="block text-sm lg:text-base font-medium text-gray-700">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="mt-1 block w-full p-3 lg:p-4 border border-gray-300 rounded-md shadow-sm focus:ring-senacOrange focus:border-senacOrange sm:text-sm lg:text-base" name="password_confirmation" required>
            </div>

            <div>
                <button type="submit" class="w-full bg-senacOrange text-white py-2 lg:py-3 px-4 rounded-md hover:bg-orange-600 transition duration-300 lg:text-lg">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
