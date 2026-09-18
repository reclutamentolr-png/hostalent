<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospitality Jobs - Trova lavoro nel settore alberghiero</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- ALPINE.JS (FONDAMENTALE PER IL MENU A TENDINA) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- FontAwesome per le icone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar Universale -->
    @include('components.navbar')

    <!-- Sezione Hero con Barra di Ricerca -->
    <section class="py-12 px-4 bg-gradient-to-b from-blue-50 to-gray-50">
        <div class="max-w-4xl mx-auto text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Trova il tuo prossimo lavoro nel settore Horeca</h1>
            <p class="text-gray-600 text-lg">Migliaia di opportunità per cuochi, camerieri, receptionist e molto altro.</p>
        </div>

        <form action="{{ route('listings.index') }}" method="GET" class="bg-white p-4 rounded-xl shadow-xl flex flex-col md:flex-row gap-4 max-w-3xl mx-auto border border-gray-100">
            <div class="flex-1 relative">
                <i class="fas fa-briefcase absolute left-3 top-3.5 text-gray-400"></i>
                <select name="category" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none appearance-none bg-gray-50">
                    <option value="">Tutte le categorie</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex-1 relative">
                <i class="fas fa-map-marker-alt absolute left-3 top-3.5 text-gray-400"></i>
                <input type="text" name="city" placeholder="Città o provincia (es. Milano)" 
                       class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none bg-gray-50">
            </div>
            
            <button type="submit" class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition shadow-md flex items-center justify-center">
                <i class="fas fa-search mr-2"></i> Cerca
            </button>
        </form>
    </section>

    <!-- Sezione Categorie -->
    <section class="py-16 px-4 max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">Cerca per categoria</h2>
            <p class="text-gray-500 mt-2">Scegli il reparto e trova le migliori opportunità</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($categories as $category)
                <a href="/categoria/{{ $category->slug }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition border border-gray-100 text-center group">
                    <div class="w-14 h-14 mx-auto bg-blue-50 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-100 transition">
                        <i class="{{ $category->icon ?? 'fas fa-utensils' }} text-2xl text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 group-hover:text-blue-700 transition">{{ $category->name }}</h3>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Ultimi Annunci -->
    <section class="py-16 px-4 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900">Ultimi annunci pubblicati</h2>
                    <p class="text-gray-500 mt-2">Le nuove offerte di lavoro dalle migliori strutture</p>
                </div>
                <a href="/annunci" class="text-blue-700 font-semibold hover:text-blue-900 hidden md:block">Vedi tutti &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($latestListings as $listing)
                    <!-- Card Annuncio -->
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 border border-gray-100 flex flex-col relative group">
                        
                        <!-- Badges -->
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex flex-wrap gap-2">
                                @if($listing->is_featured && $listing->featured_until?->isFuture())
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded-full flex items-center shadow-sm">
                                        <i class="fas fa-star mr-1 text-[10px]"></i> Premium
                                    </span>
                                @endif
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-1 rounded-full">
                                    {{ $listing->jobType->name }}
                                </span>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition">{{ $listing->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">
                            {{ Str::limit($listing->description, 120) }}
                        </p>

                        <div class="flex items-center text-gray-500 text-sm mb-4 space-x-4">
                            <span class="flex items-center"><i class="fas fa-map-marker-alt mr-1.5 text-gray-400"></i> {{ $listing->city }}</span>
                            @if($listing->salary_range)
                                <span class="flex items-center text-green-700 font-medium"><i class="fas fa-euro-sign mr-1.5"></i> {{ $listing->salary_range }}</span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-700 font-bold text-xs mr-2 border border-blue-100">
                                    {{ strtoupper(substr($listing->user->name ?? 'A', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $listing->user->company_name ?? $listing->user->name }}</p>
                                    <p class="text-xs text-gray-500 flex items-center">
                                        @if($listing->user->is_verified)
                                            <i class="fas fa-check-circle text-blue-500 mr-1"></i> Verificato
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <a href="/annunci/{{ $listing->id }}" class="text-blue-700 hover:text-blue-900 font-semibold text-sm flex items-center">
                                Dettagli <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                        <i class="fas fa-folder-open text-4xl mb-4 text-gray-300"></i>
                        <p>Nessun annuncio attivo al momento.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="text-center mt-10 md:hidden">
                <a href="/annunci" class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-50">Vedi tutti gli annunci</a>
            </div>
        </div>
    </section>

    <!-- Footer Semplice -->
    <footer class="bg-gray-900 text-gray-400 py-10 px-4 mt-10">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-sm">&copy; 2026 HosTalent. La piattaforma per il settore Horeca.</p>
        </div>
    </footer>

</body>
</html>