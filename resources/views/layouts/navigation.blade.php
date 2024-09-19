<nav class="bg-senacBlue text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="text-xl font-bold text-senacOrange">
                    {{ config('app.name', 'Senac') }}
                </a>
            </div>

            <!-- Menu Toggle para mobile -->
            <div class="-mr-2 flex md:hidden">
                <button id="menu-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-senacOrange focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Menu Principal e Links de Autenticação -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('profile.edit') }}" class="text-white hover:text-senacOrange">Profile</a>
                <!-- Outros links -->
                
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-senacOrange">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white hover:text-senacOrange">Registrar</a>
                    @endif
                @else
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 text-white hover:text-senacOrange focus:outline-none">
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
                <a href="{{ route('profile.edit') }}" class="text-white hover:text-senacOrange block">Profile</a>
                <!-- Outros links -->
            </div>
        </div>
    </div>
</nav>