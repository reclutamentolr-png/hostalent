<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo Personalizzato -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <span class="text-2xl font-bold text-blue-700">Hospit<span class="text-orange-500">Jobs</span></span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.index')">
                        {{ __('Cerca Lavoro') }}
                    </x-nav-link>

                    @auth
                        <!-- LINK ESCLUSIVI PER CANDIDATI (Cuochi, Camerieri, ecc.) -->
                        @if(Auth::user()->role === 'candidate')
                            <x-nav-link :href="route('candidate.saved')" :active="request()->routeIs('candidate.saved')">
                                <i class="fas fa-heart text-red-400 mr-1"></i> {{ __('Preferiti') }}
                            </x-nav-link>
                            <x-nav-link :href="route('candidate.applications')" :active="request()->routeIs('candidate.applications')">
                                <i class="fas fa-paper-plane text-blue-400 mr-1"></i> {{ __('Le mie Candidature') }}
                            </x-nav-link>
                        @endif

                        <!-- LINK ESCLUSIVI PER AZIENDE (Albergatori, Ristoratori) -->
                        @if(Auth::user()->role === 'employer')
                            <x-nav-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                                <i class="fas fa-plus text-orange-500 mr-1"></i> {{ __('Pubblica Annuncio') }}
                            </x-nav-link>
                            <x-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                                <i class="fas fa-inbox text-green-500 mr-1"></i> {{ __('Candidature Ricevute') }}
                            </x-nav-link>
                        @endif

                        <!-- Dashboard per entrambi i ruoli -->
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @else
                        <!-- Link per chi NON è loggato -->
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                            {{ __('Accedi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="text-orange-600 font-bold">
                            {{ __('Registrati') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    <!-- Badge del ruolo accanto al nome -->
                                    @if(Auth::user()->role === 'employer')
                                        <i class="fas fa-hotel text-orange-500 mr-2" title="Azienda"></i>
                                    @else
                                        <i class="fas fa-user-tie text-blue-500 mr-2" title="Candidato"></i>
                                    @endif
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.index')">
                {{ __('Cerca Lavoro') }}
            </x-responsive-nav-link>

            @auth
                @if(Auth::user()->role === 'candidate')
                    <x-responsive-nav-link :href="route('candidate.saved')" :active="request()->routeIs('candidate.saved')">
                        <i class="fas fa-heart text-red-400 mr-2"></i> {{ __('I miei Preferiti') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('candidate.applications')" :active="request()->routeIs('candidate.applications')">
                        <i class="fas fa-paper-plane text-blue-400 mr-2"></i> {{ __('Le mie Candidature') }}
                    </x-responsive-nav-link>
                @endif

                @if(Auth::user()->role === 'employer')
                    <x-responsive-nav-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                        <i class="fas fa-plus text-orange-500 mr-2"></i> {{ __('Pubblica Annuncio') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('messages.index')" :active="request()->routeIs('messages.index')">
                        <i class="fas fa-inbox text-green-500 mr-2"></i> {{ __('Candidature Ricevute') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Accedi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Registrati') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 flex items-center">
                    @if(Auth::user()->role === 'employer')
                        <i class="fas fa-hotel text-orange-500 mr-2"></i>
                    @else
                        <i class="fas fa-user-tie text-blue-500 mr-2"></i>
                    @endif
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="font-medium text-xs text-gray-400 mt-1 uppercase">
                    Ruolo: {{ Auth::user()->role === 'employer' ? 'Azienda' : 'Candidato' }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>