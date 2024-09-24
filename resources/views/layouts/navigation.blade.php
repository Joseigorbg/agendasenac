<nav class="bg-white text-black shadow-lg border-b-8 border-senacOrange">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/dashboard') }}">
                    <img src="{{ asset('img/Senac_logo.svg.png') }}" alt="Senac Logo" class="h-12"> <!-- Tamanho da logo ajustado -->
                </a>
            </div>

            <!-- Menu Toggle para mobile -->
            <div class="-mr-2 flex md:hidden">
                <button id="menu-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-black hover:bg-senacOrange focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Menu Principal e Links de Autenticação -->
            <div class="hidden md:flex items-center space-x-4">

                @guest
                    <a href="{{ route('login') }}" class="text-black hover:text-senacOrange">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-black hover:text-senacOrange">Registrar</a>
                    @endif
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-black hover:text-senacOrange">Admin Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="text-black hover:text-senacOrange">Gerenciar Usuários</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="text-black hover:text-senacOrange">Agendamentos</a>
                    @endif
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 text-black hover:text-senacOrange focus:outline-none">
                            @if(Auth::user()->profile_photo_url)
                                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            @else
                                <span>{{ Auth::user()->name }}</span>
                            @endif
                        </button>

                        <!-- Dropdown -->
                        <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-senacBlue">Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-senacBlue" 
                                   onclick="event.preventDefault(); this.closest('form').submit();">
                                    Sair
                                </a>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>

        <!-- Menu Mobile -->
        <div class="hidden md:hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pt-2 pb-3">
                @guest
                    <a href="{{ route('login') }}" class="text-black hover:text-senacOrange block">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-black hover:text-senacOrange block">Registrar</a>
                    @endif
                @else
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-black hover:text-senacOrange block">Admin Dashboard</a>
                        <a href="{{ route('admin.users.index') }}" class="text-black hover:text-senacOrange block">Gerenciar Usuários</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="text-black hover:text-senacOrange block">Agendamentos</a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</nav>
