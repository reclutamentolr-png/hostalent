<?php

namespace App\Http\Controllers;

use App\Models\SavedListing;
use App\Models\Listing;
use App\Models\Category;
use App\Models\JobType;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    /**
     * HOMEPAGE
     */
    public function index()
    {
        $categories = Category::all();
        
        $latestListings = Listing::where('status', 'active')
                                 ->with(['user', 'category', 'jobType'])
                                 ->latest()
                                 ->take(6)
                                 ->get();

        return view('home', compact('categories', 'latestListings'));
    }

    /**
     * LISTA ANNUNCI CON FILTRI (Questo è il metodo che mancava!)
     */
    public function browse(Request $request)
    {
        $query = Listing::where('status', 'active')
                        ->with(['user', 'category', 'jobType']);

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

                // Ordina: prima i Premium (is_featured = 1), poi per data di creazione
        $listings = $query->orderByRaw('is_featured DESC, created_at DESC')->paginate(12);
        $searchCategory = $request->category;
        $searchCity = $request->city;

        return view('listings.index', compact('listings', 'searchCategory', 'searchCity'));
    }

    /**
     * DETTAGLIO ANNUNCIO
     */
    public function show($id)
    {
        $listing = Listing::where('id', $id)
                          ->where('status', 'active')
                          ->with(['user', 'category', 'jobType'])
                          ->firstOrFail();

        $listing->increment('views_count');

        return view('listings.show', compact('listing'));
    }

    /**
     * FORM CREAZIONE ANNUNCIO
     */
    public function create()
    {
        if (Auth::user()->role !== 'employer') {
            abort(403, 'Solo i datori di lavoro possono pubblicare annunci.');
        }

        $categories = Category::all();
        $jobTypes = JobType::all();

        return view('listings.create', compact('categories', 'jobTypes'));
    }

    /**
     * SALVATAGGIO ANNUNCIO
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'city' => 'required|string|max:100',
            'salary_range' => 'nullable|string|max:100',
        ]);

        Listing::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'job_type_id' => $request->job_type_id,
            'city' => $request->city,
            'salary_range' => $request->salary_range,
            'status' => 'active',
        ]);

        return redirect()->route('home')->with('success', 'Annuncio pubblicato con successo!');
    }

    /**
     * GESTIONE CANDIDATURA
     */
    public function apply(Request $request, $id)
    {
        $listing = Listing::with('user')->findOrFail($id);
        $user = Auth::user();

        // BLOCCO NETTO: Solo i candidati possono candidarsi
        if ($user->role !== 'candidate') {
            return back()->with('error', 'Solo i candidati (cuochi, camerieri, ecc.) possono inviare candidature.');
        }

        if ($user->id === $listing->user_id) {
            return back()->with('error', 'Non puoi candidarti al tuo stesso annuncio.');
        }
        Message::create([
            'listing_id' => $listing->id,
            'sender_id' => $user->id,
            'receiver_id' => $listing->user_id,
            'message' => "Salve, sono molto interessato alla posizione di '{$listing->title}'. Resto a disposizione per un colloquio conoscitivo. Cordiali saluti.",
            'is_read' => false,
        ]);

        return back()->with('success', 'Candidatura inviata con successo! Il datore di lavoro riceve una notifica.');
    }

    /**
     * SALVA / RIMUOVI ANNUNCIO DAI PREFERITI
     */
    public function toggleSave($id)
    {
        $user = Auth::user();
        $saved = SavedListing::where('user_id', $user->id)->where('listing_id', $id)->first();
        
        if ($saved) {
            $saved->delete();
            $message = 'Annuncio rimosso dai preferiti.';
        } else {
            SavedListing::create(['user_id' => $user->id, 'listing_id' => $id]);
            $message = 'Annuncio salvato nei preferiti!';
        }
        
        return back()->with('success', $message);
    }
        /**
     * PAGINA: I MIEI ANNUNCI SALVATI (Preferiti)
     */
    public function mySaved()
    {
        // Prende tutti i salvataggi dell'utente e carica i dati dell'annuncio collegato
        $savedListings = SavedListing::where('user_id', Auth::id())
                                     ->with('listing')
                                     ->latest()
                                     ->paginate(10);
        
        return view('candidate.saved', compact('savedListings'));
    }

    /**
     * PAGINA: LE MIE CANDIDATURE INVIA
     */
    public function myApplications()
    {
        // Prende tutti i messaggi dove l'utente è il mittente
        $applications = Message::where('sender_id', Auth::id())
                               ->with(['listing', 'receiver'])
                               ->latest()
                               ->paginate(10);
        
        return view('candidate.applications', compact('applications'));
    }
        /**
     * RENDE UN ANNUNCIO "IN EVIDENZA" (PREMIUM)
     */
    public function makeFeatured($id)
    {
        $listing = Listing::findOrFail($id);

        // Sicurezza: solo il proprietario può renderlo Premium
        if ($listing->user_id !== Auth::id()) {
            abort(403, 'Non puoi modificare annunci di altri utenti.');
        }

        // Aggiorna lo stato e imposta la scadenza a 7 giorni da ora
        $listing->update([
            'is_featured' => true,
            'featured_until' => now()->addDays(7),
        ]);

        return back()->with('success', 'Annuncio reso Premium! Sarà in evidenza per 7 giorni.');
    }
}