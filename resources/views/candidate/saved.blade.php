<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>I miei Preferiti - HospitJobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">
    @include('components.navbar')

    <div class="max-w-5xl mx-auto px-4 pb-20">
        <h1 class="text-3xl font-bold text-gray-900 mb-6"><i class="fas fa-heart text-red-500 mr-3"></i> I tuoi Annunci Salvati</h1>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @forelse($savedListings as $saved)
                @php $listing = $saved->listing; @endphp
                @if($listing) <!-- Controllo di sicurezza se l'annuncio è stato cancellato -->
                <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">{{ $listing->jobType->name }}</span>
                            <h3 class="text-lg font-bold text-gray-900">{{ $listing->title }}</h3>
                        </div>
                        <p class="text-gray-600 text-sm mb-2"><i class="fas fa-map-marker-alt text-gray-400 mr-1"></i> {{ $listing->city }} &bull; {{ $listing->user->company_name ?? $listing->user->name }}</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="/annunci/{{ $listing->id }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">Vedi Annuncio</a>
                        <form action="{{ route('listings.save', $listing->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="border border-red-200 text-red-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-50 transition">
                                <i class="fas fa-trash mr-1"></i> Rimuovi
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            @empty
                <div class="p-12 text-center text-gray-500">
                    <i class="far fa-heart text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">Nessun annuncio salvato</p>
                    <a href="/annunci" class="text-blue-600 hover:underline mt-2 inline-block">Cerca lavoro ora</a>
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $savedListings->links() }}</div>
    </div>
</body>
</html>