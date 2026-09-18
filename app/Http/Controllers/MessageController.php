<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Mostra la lista delle candidature ricevute (Inbox)
     */
    public function index()
    {
        // Prendi tutti i messaggi dove l'utente loggato è il destinatario
        $messages = Message::where('receiver_id', Auth::id())
                           ->with(['sender', 'listing']) // Carica anche i dati di chi ha scritto e dell'annuncio
                           ->latest()
                           ->paginate(15);

        return view('messages.index', compact('messages'));
    }

    /**
     * Segna un messaggio come "letto" quando l'azienda ci clicca sopra
     */
    public function markAsRead($id)
    {
        $message = Message::where('id', $id)
                          ->where('receiver_id', Auth::id())
                          ->firstOrFail();

        $message->update(['is_read' => true]);

        // Reindirizza alla stessa pagina o a una vista dettaglio (per ora torniamo alla inbox)
        return back()->with('success', 'Messaggio segnato come letto.');
    }
}