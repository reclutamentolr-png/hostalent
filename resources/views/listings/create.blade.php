<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pubblica Annuncio - HospitJobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar (Copia dalla home per coerenza) -->
    <nav class="bg-white shadow-sm mb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="/" class="text-2xl font-bold text-blue-700">Hospit<span class="text-orange-500">Jobs</span></a>
                <div class="hidden md:flex space-x-8">
                    <a href="/annunci" class="text-gray-600 hover:text-blue-700 text-sm font-medium">Cerca Lavoro</a>
                    <form method="POST" action="/logout" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 text-sm font-medium">Esci</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 pb-20">
        <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100">
            <h1 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-plus-circle text-orange-500 mr-3"></i> Pubblica un nuovo annuncio
            </h1>

            <form action="{{ route('listings.store') }}" method="POST" class="space-y-6">
                @csrf <!-- Fondamentale in Laravel per la sicurezza -->

                <!-- Titolo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titolo dell'annuncio</label>
                    <input type="text" name="title" required placeholder="es. Cameriere di sala esperto" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Categoria e Tipo Contratto (Riga doppia) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Seleziona...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipo di contratto</label>
                        <select name="job_type_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Seleziona...</option>
                            @foreach($jobTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('job_type_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Città e Retribuzione -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Città / Provincia</label>
                        <input type="text" name="city" required placeholder="es. Milano, Rimini" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Retribuzione (Opzionale)</label>
                        <input type="text" name="salary_range" placeholder="es. 1300€/mese o 10€/ora" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <!-- Descrizione -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descrizione dell'offerta</label>
                    <textarea name="description" required rows="5" placeholder="Descrivi i requisiti, gli orari, i benefit..." 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Pulsante Invio -->
                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-md flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i> Pubblica Annuncio
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>