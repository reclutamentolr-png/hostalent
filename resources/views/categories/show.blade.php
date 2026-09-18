<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annunci per {{ $category->name }} - HospitJobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 pb-20">
        
        <!-- Intestazione Categoria -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">
                Lavori nella categoria: <span class="text-blue-700">{{ $category->name }}</span>
            </h1>
            <p class="text-gray-500">Trovati {{ $listings->total() }} annunci attivi in questo settore</p>
        </div>

        <!-- Griglia Annunci -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($listings as $listing)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 border-2 {{ $listing->is_featured ? 'border-yellow-400 ring-2 ring-yellow-100' : 'border-gray-100' }} flex flex-col relative group">
                    
                    <!-- Badges -->
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
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition">{{ $listing->title }}</h3>
                    <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-3">{{ Str::limit($listing->description, 120) }}</p>

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
                            </div>
                        </div>
                        <a href="/annunci/{{ $listing->id }}" class="text-blue-700 hover:text-blue-900 font-semibold text-sm flex items-center">
                            Dettagli <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-20 text-gray-500 bg-white rounded-xl border border-dashed border-gray-300">
                    <i class="fas fa-folder-open text-4xl mb-4 text-gray-300"></i>
                    <p class="text-lg font-medium">Nessun annuncio attivo in questa categoria.</p>
                    <a href="/" class="text-blue-600 hover:underline mt-2 inline-block">Torna alla home</a>
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