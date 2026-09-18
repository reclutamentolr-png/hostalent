<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le mie Candidature - HospitJobs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 text-gray-800">
    @include('components.navbar')

    <div class="max-w-5xl mx-auto px-4 pb-20">
        <h1 class="text-3xl font-bold text-gray-900 mb-6"><i class="fas fa-paper-plane text-blue-600 mr-3"></i> Le tue Candidature Inviate</h1>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            @forelse($applications as $app)
                <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $app->listing->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">Candidato presso: <span class="font-semibold">{{ $app->receiver->company_name ?? $app->receiver->name }}</span></p>
                        <p class="text-gray-500 text-xs"><i class="far fa-clock mr-1"></i> Inviata il {{ $app->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                            <i class="fas fa-check mr-1"></i> Inviata
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">
                    <i class="fas fa-paper-plane text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">Non hai ancora inviato candidature</p>
                    <a href="/annunci" class="text-blue-600 hover:underline mt-2 inline-block">Inizia a candidarti</a>
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $applications->links() }}</div>
    </div>
</body>
</html>