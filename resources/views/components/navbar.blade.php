<nav class="bg-white shadow-sm mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold text-blue-700">Hos<span class="text-orange-500">Talent</span></a>

            <!-- Menu Desktop -->
            <div class="hidden md:flex space-x-6 items-center">
                <a href="/" class="text-gray-600 hover:text-blue-700 font-medium">Home</a>
                <a href="/annunci" class="text-gray-600 hover:text-blue-700 font-medium">Cerca Lavoro</a>

                @auth
                    @if(Auth::user()->role === 'candidate')
                        <a href="/preferiti" class="text-gray-600 hover:text-red-500 font-medium flex items-center">
                            <i class="fas fa-heart mr-1"></i> Preferiti
                        </a>
                        <a href="/mie-candidature" class="text-gray-600 hover:text-blue-700 font-medium flex items-center">
                            <i class="fas fa-paper-plane mr-1"></i> Le mie Candidature
                        </a>
                    @endif

                    @if(Auth::user()->role === 'employer')
                        <a href="/annunci/crea" class="bg-orange-500 text-white px-4 py-2 rounded-lg font-medium hover:bg-orange-600 transition flex items-center">
                            <i class="fas fa-plus mr-1"></i> Pubblica Annuncio
                        </a>
                        <a href="/messaggi" class="text-gray-600 hover:text-green-600 font-medium flex items-center">
                            <i class="fas fa-inbox mr-1"></i> Candidature Ricevute
                        </a>
                    @endif

                    <!-- Dropdown Utente -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-700 font-medium focus:outline-none">
                            @if(Auth::user()->role === 'employer')
                                <i class="fas fa-hotel text-orange-500 mr-2"></i>
                            @else
                                <i class="fas fa-user-tie text-blue-500 mr-2"></i>
                            @endif
                            {{ Auth::user()->name }}
                            <i class="fas fa-chevron-down ml-1 text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-2 z-50" style="display: none;">
                            <a href="/dashboard" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-50">Profilo</a>
                            <hr class="my-1">
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">Esci</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="/login" class="text-gray-600 hover:text-blue-700 font-medium">Accedi</a>
                    <a href="/register" class="bg-blue-700 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-800 transition">Registrati</a>
                @endauth
            </div>

            <!-- Menu Mobile (Hamburger) -->
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-600 hover:text-blue-700 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
                
                <div x-show="open" @click.away="open = false" class="absolute top-16 left-0 right-0 bg-white shadow-lg border-t border-gray-100 py-4 px-4 z-50" style="display: none;">
                    <a href="/" class="block py-2 text-gray-700 hover:text-blue-700">Home</a>
                    <a href="/annunci" class="block py-2 text-gray-700 hover:text-blue-700">Cerca Lavoro</a>
                    
                    @auth
                        @if(Auth::user()->role === 'candidate')
                            <a href="/preferiti" class="block py-2 text-gray-700 hover:text-blue-700">Preferiti</a>
                            <a href="/mie-candidature" class="block py-2 text-gray-700 hover:text-blue-700">Le mie Candidature</a>
                        @endif
                        @if(Auth::user()->role === 'employer')
                            <a href="/annunci/crea" class="block py-2 text-orange-600 font-bold">Pubblica Annuncio</a>
                            <a href="/messaggi" class="block py-2 text-gray-700 hover:text-blue-700">Candidature Ricevute</a>
                        @endif
                        <a href="/dashboard" class="block py-2 text-gray-700 hover:text-blue-700">Dashboard</a>
                        <form method="POST" action="/logout" class="mt-2">
                            @csrf
                            <button type="submit" class="block w-full text-left py-2 text-red-600">Esci</button>
                        </form>
                    @else
                        <a href="/login" class="block py-2 text-gray-700 hover:text-blue-700">Accedi</a>
                        <a href="/register" class="block py-2 text-blue-700 font-bold">Registrati</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>