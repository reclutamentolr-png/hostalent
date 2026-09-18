<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annunci di Lavoro - HospitJobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    @include('components.navbar')
        

    <!-- Barra di ricerca per la pagina dei risultati -->
    <div class="max-w-7xl mx-auto px-4 mb-8">
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
            <form action="{{ route('listings.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <select name="category" class="w-full px-4 py-3 border border-gray-200 rounded-lg outline-none bg-gray-50">
                        <option value="">Tutte le categorie</option>
                        @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->slug }}" {{ $searchCategory == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1 relative">
                    <input type="text" name="city" placeholder="Città..." 
                           value="{{ $searchCity }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg outline-none bg-gray-50">
                </div>
                
                <button type="submit" class="bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    Filtra
                </button>
                <a href="{{ route('listings.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition text-center">
                    Reset
                </a>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 pb-20">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    @isset($category) Annunci per: {{ $category->name }} @else Tutti gli annunci @endisset
                </h1>
                <p class="text-gray-500 mt-1">Trovati {{ $listings->total() }} annunci attivi</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($listings as $listing)
                
                                <!-- CARD ANNUNCIO (con logica Premium) -->
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 border-2 {{ $listing->is_featured ? 'border-yellow-400 ring-2 ring-yellow-100' : 'border-gray-100' }} flex flex-col relative group">
                    
                    <!-- BADGES E CUORE -->
                    <div class="flex justify-between items-start mb-3">
                        <div class="flex flex-wrap gap-2">
                            @if($listing->is_featured)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded-full flex items-center shadow-sm">
                                    <i class="fas fa-star mr-1 text-[10px]"></i> Premium
                                </span>
                            @endif
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                                {{ $listing->jobType->name }}
                            </span>
                            
                            @if($listing->created_at->isAfter(now()->subDays(3)))
                                <span class="bg-orange-100 text-orange-800 text-xs font-semibold px-2.5 py-1 rounded-full flex items-center">
                                    <i class="fas fa-fire mr-1 text-[10px]"></i> Nuovo
                                </span>
                            @endif

                            @if($listing->user->is_verified)
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1 rounded-full flex items-center">
                                    <i class="fas fa-check-circle mr-1 text-[10px]"></i> Verificata
                                </span>
                            @endif
                        </div>

                                               <!-- PULSANTE SALVA (Cuore) -->
                        @auth
                            @php
                                // Query diretta e sicura nella vista
                                $isSaved = \App\Models\SavedListing::where('user_id', Auth::id())
                                                                   ->where('listing_id', $listing->id)
                                                                   ->first();
                            @endphp
                            <form action="{{ route('listings.save', $listing->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="transition transform hover:scale-110 focus:outline-none" title="{{ $isSaved ? 'Rimuovi dai preferiti' : 'Salva annuncio' }}">
                                    @if($isSaved)
                                        <i class="fas fa-heart text-red-500 text-xl"></i>
                                    @else
                                        <i class="far fa-heart text-gray-300 hover:text-red-500 text-xl"></i>
                                    @endif
                                </button>
                            </form>
                        @endauth
                    </div>

                    <!-- TITOLO E DESCRIZIONE -->
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition">{{ $listing->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">{{ Str::limit($listing->description, 120) }}</p>

                    <!-- LOCALITÀ E STIPENDIO -->
                    <div class="flex items-center text-gray-500 text-sm mb-4 space-x-4">
                        <span class="flex items-center"><i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i> {{ $listing->city }}</span>
                        @if($listing->salary_range)
                            <span class="flex items-center text-green-700 font-medium"><i class="fas fa-euro-sign mr-1.5"></i> {{ $listing->salary_range }}</span>
                        @endif
                    </div>

                    <!-- FOOTER: AZIENDA E DETTAGLI -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-700 font-bold text-xs mr-2 border border-blue-100">
                                {{ strtoupper(substr($listing->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $listing->user->company_name ?? $listing->user->name }}</p>
                            </div>
                        </div>
                        <a href="/annunci/{{ $listing->id }}" class="text-blue-700 hover:text-blue-900 font-semibold text-sm flex items-center">
                            Dettagli <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
                <!-- FINE CARD ANNUNCIO -->

            @empty
                <div class="col-span-3 text-center py-20 text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                    <i class="fas fa-search text-4xl mb-4 text-gray-300"></i>
                    <p>Nessun annuncio trovato con questi filtri.</p>
                </div>
            @endforelse
        </div>

        <!-- Paginazione -->
        <div class="mt-12">
            {{ $listings->links() }}
        </div>
    </div>

</body>
</html>