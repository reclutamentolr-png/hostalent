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

    <!-- Navbar -->
    @include('components.navbar')

    <div class="max-w-5xl mx-auto px-4 pb-20">
        <h1 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fas fa-inbox text-blue-600 mr-3"></i> Le tue Candidature
        </h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Contenitore Bianco Principale -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            
            @forelse($messages as $msg)
                <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition flex flex-col md:flex-row md:items-center justify-between gap-4 {{ !$msg->is_read ? 'bg-blue-50/50' : '' }}">
                    
                    <!-- Info Mittente e Annuncio -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            @if(!$msg->is_read)
                                <span class="w-2 h-2 bg-blue-600 rounded-full" title="Non letto"></span>
                            @endif
                            <span class="font-bold text-gray-900">{{ $msg->sender->name }}</span>
                            <span class="text-gray-400 text-sm">ha candidato per</span>
                            <a href="/annunci/{{ $msg->listing->id }}" class="text-blue-700 font-semibold hover:underline">
                                "{{ Str::limit($msg->listing->title, 40) }}"
                            </a>
                        </div>
                        <p class="text-gray-600 text-sm leading-relaxed pl-5 border-l-2 border-gray-200">
                            "{{ Str::limit($msg->message, 150) }}"
                        </p>
                        <p class="text-gray-400 text-xs mt-2 pl-5">
                            <i class="far fa-clock mr-1"></i> {{ $msg->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Azioni -->
                    <div class="flex flex-col md:flex-row items-start md:items-center gap-3 md:border-l md:pl-4 md:border-gray-200">
                        @if(!$msg->is_read)
                            <form action="{{ route('messages.read', $msg->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition flex items-center">
                                    <i class="far fa-eye mr-2"></i> Segna come letto
                                </button>
                            </form>
                        @else
                            <span class="text-gray-400 text-sm flex items-center">
                                <i class="fas fa-check-double mr-2"></i> Letto
                            </span>
                        @endif
                        
                        <!-- PULSANTE RISPONDI -->
                        <a href="mailto:{{ $msg->sender->email }}?subject=Risposta%20candidatura%20per%20{{ urlencode($msg->listing->title) }}&body=Ciao%20{{ urlencode($msg->sender->name) }},%0D%0A%0D%0AGrazie%20per%20aver%20candidato%20alla%20posizione%20di%20{{ urlencode($msg->listing->title) }}.%0D%0A%0D%0ACordiali%20saluti,%0D%0A{{ urlencode(Auth::user()->company_name ?? Auth::user()->name) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center mt-2 md:mt-0">
                           <i class="fas fa-reply mr-1.5"></i> Rispondi via Email
                        </a>
                    </div>
                </div>
            
            @empty
                <!-- Stato Vuoto (se non ci sono messaggi) -->
                <div class="p-12 text-center text-gray-500">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                    <p class="text-lg font-medium">Nessuna candidatura ricevuta</p>
                    <p class="text-sm">Quando qualcuno si candiderà ai tuoi annunci, lo vedrai qui.</p>
                </div>
            @endforelse

        </div> <!-- CHIUSURA DEL CONTENITORE BIANCO -->

        <!-- Paginazione -->
        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    </div>

</body>
</html>