<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $listing->title }} - HospitJobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    @include('components.navbar')

    <div class="max-w-5xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonna Principale (Descrizione) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 mb-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $listing->jobType->name }}
                        </span>
                        <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $listing->category->name }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $listing->title }}</h1>
                    
                    <div class="flex items-center text-gray-500 text-sm mb-6 space-x-4">
                        <span class="flex items-center"><i class="fas fa-map-marker-alt mr-1.5 text-blue-500"></i> {{ $listing->city }}</span>
                        <span class="flex items-center"><i class="far fa-clock mr-1.5 text-blue-500"></i> Pubblicato {{ $listing->created_at->diffForHumans() }}</span>
                        <span class="flex items-center"><i class="far fa-eye mr-1.5 text-blue-500"></i> {{ $listing->views_count }} visualizzazioni</span>
                    </div>

                    <hr class="border-gray-100 mb-6">

                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Descrizione dell'offerta</h2>
                    <div class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $listing->description }}
                    </div>
                </div>
            </div>

                        <!-- Colonna Laterale (Info Azienda e Contatti) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 sticky top-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Info Azienda</h3>
                    
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xl mr-3">
                            {{ strtoupper(substr($listing->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $listing->user->company_name ?? $listing->user->name }}</p>
                            @if($listing->user->is_verified)
                                <p class="text-xs text-blue-600 flex items-center"><i class="fas fa-check-circle mr-1"></i> Profilo Verificato</p>
                            @endif
                        </div>
                    </div>

                    @if($listing->salary_range)
                        <div class="bg-gray-50 p-3 rounded-lg mb-4">
                            <p class="text-xs text-gray-500 uppercase font-semibold">Retribuzione</p>
                            <p class="text-gray-900 font-medium">{{ $listing->salary_range }}</p>
                        </div>
                    @endif

                    <!-- MESSAGGI DI SUCCESSO O ERRORE -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- LOGICA DEL PULSANTE -->
                    @auth
                        @if(Auth::id() === $listing->user_id)
                            <!-- Se sei il proprietario dell'annuncio -->
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-3 rounded-lg text-sm text-center">
                                <i class="fas fa-info-circle mr-1"></i> Questo è il tuo annuncio
                            </div>
                        @elseif(Auth::user()->role === 'employer')
                            <!-- Se sei un altro datore di lavoro -->
                            <div class="bg-gray-100 text-gray-500 p-3 rounded-lg text-sm text-center">
                                Solo i candidati possono inviare candidature.
                            </div>
                        @else
                            <!-- Se sei un candidato: FORM REALE -->
                            <form action="{{ route('listings.apply', $listing->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-orange-500 text-white py-3 rounded-lg font-semibold hover:bg-orange-600 transition shadow-md mb-3 flex items-center justify-center">
                                    <i class="fas fa-paper-plane mr-2"></i> Candidati ora
                                </button>
                            </form>
                            <button class="w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                                <i class="far fa-bookmark mr-2"></i> Salva annuncio
                            </button>
                        @endif
                    @else
                        <!-- Se non sei loggato -->
                        <a href="{{ route('login') }}" class="block w-full bg-blue-700 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-md mb-3">
                            Accedi per candidarti
                        </a>
                    @endauth

                                        <!-- SEZIONE UPGRADE PREMIUM (Visibile solo al proprietario) -->
                    @auth
                        @if(Auth::id() === $listing->user_id)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                @if($listing->is_featured && $listing->featured_until?->isFuture())
                                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-3 rounded-lg text-sm text-center">
                                        <i class="fas fa-crown mr-1"></i> Annuncio Premium attivo fino al {{ $listing->featured_until->format('d/m/Y') }}
                                    </div>
                                @else
                                    <form action="{{ route('listings.featured', $listing->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 to-yellow-600 text-white py-3 rounded-lg font-bold hover:from-yellow-500 hover:to-yellow-700 transition shadow-md flex items-center justify-center">
                                            <i class="fas fa-crown mr-2"></i> Rendi Premium (7 giorni)
                                        </button>
                                    </form>
                                    <p class="text-xs text-gray-400 text-center mt-2">In questo MVP è gratuito per test</p>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>
            </div>

        </div>
    </div>

</body>
</html>