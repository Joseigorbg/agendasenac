<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Título da página -->
    <title>Senac Amapá</title>
    <!-- Ícone da aba -->
    <link rel="icon" href="{{ asset('img/logo-white.png') }}" type="image/png">
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="{{ (Route::is('login') || Route::is('register')) ? 'bg-cover bg-center bg-no-repeat' : 'bg-gray-100' }}" 
      style="{{ (Route::is('login') || Route::is('register')) ? 'background-image: url('.asset('img/fundo.jpg').'); background-size: cover;' : '' }}">

    <div class="flex flex-col min-h-screen">
        <!-- Navegação -->
        @include('layouts.navigation')

        <!-- Cabeçalho da Página -->
        @isset($header)
            <header class="bg-senacOrange text-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endisset

        <!-- Conteúdo da Página -->
        <main class="flex-grow max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            @yield('content')
        </main>
        
        <footer class="bg-blue-900 text-white py-8">
          <div class="container mx-auto flex flex-wrap justify-between">
            
            <!-- Logo e descrição -->
            <div class="w-full md:w-1/4 mb-6">
              <img src="{{ asset('img/logo2.png') }}" alt="Senac Logo" class="mb-4 w-24">
              <p class="text-sm">
                Desde 1946, o Senac é o principal agente de educação profissional para Comércio de Bens, Serviços e Turismo.
              </p>
            </div>        

            <!-- FAQ e Transparência -->
            <div class="w-full md:w-1/4 mb-6">
              <h5 class="font-bold text-lg mb-4">FAQ</h5>
              <ul>
                <li><a href="#" class="text-sm hover:underline">Dúvidas Frequentes</a></li>
              </ul>
              
              <h5 class="font-bold text-lg mt-6 mb-4">Transparência</h5>
              <ul>
                <li><a href="#" class="text-sm hover:underline">Política de Privacidade</a></li>
                <li><a href="#" class="text-sm hover:underline">Termos de uso</a></li>
              </ul>
            </div>        

            <!-- Mapa do site -->
            <div class="w-full md:w-1/4 mb-6">
              <h5 class="font-bold text-lg mb-4">Mapa do site</h5>
              <ul>
                <li><a href="#" class="text-sm hover:underline">Senac</a></li>
                <li><a href="#" class="text-sm hover:underline">Para você</a></li>
                <li><a href="#" class="text-sm hover:underline">Cursos</a></li>
                <li><a href="#" class="text-sm hover:underline">Para sua empresa</a></li>
                <li><a href="#" class="text-sm hover:underline">Fale conosco</a></li>
              </ul>
            </div>        

            <!-- Acesso Interno -->
            <div class="w-full md:w-1/4 mb-6">
              <h5 class="font-bold text-lg mb-4">Acesso Interno</h5>
              <ul>
                <li><a href="#" class="text-sm hover:underline">SEND</a></li>
                <li><a href="#" class="text-sm hover:underline">Webmail</a></li>
                <li><a href="#" class="text-sm hover:underline">Painel administrativo</a></li>
              </ul>
            </div>        

          </div>        

          <!-- Linha de baixo com direitos reservados -->
          <div class="border-t border-gray-700 mt-8 pt-4">
            <div class="container mx-auto flex flex-wrap justify-between">
              <p class="text-sm">
                ©2024 SENAC. CNPJ: 03.592.977/0001-33. Todos os direitos reservados.
              </p>
              <p class="text-sm">Versão 01.01.35</p>
              <p class="text-sm">Desenvolvido por <a href="#" class="hover:underline">DIX DIGITAL</a></p>
            </div>
          </div>
        </footer>


    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
