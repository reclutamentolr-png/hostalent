<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. ROTTE PUBBLICHE
// ==========================================
Route::get('/', [ListingController::class, 'index'])->name('home');

// ⚠️ IMPORTANTE: '/annunci/crea' DEVE stare PRIMA di '/annunci/{id}'
Route::get('/annunci/crea', [ListingController::class, 'create'])->name('listings.create')->middleware('auth');

Route::get('/annunci', [ListingController::class, 'browse'])->name('listings.index');
Route::get('/annunci/{id}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/categoria/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// ==========================================
// 2. ROTTE POST (Richiedono Login)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::post('/annunci', [ListingController::class, 'store'])->name('listings.store');
    Route::post('/annunci/{id}/candidati', [ListingController::class, 'apply'])->name('listings.apply');
    Route::post('/annunci/{id}/salva', [ListingController::class, 'toggleSave'])->name('listings.save');
    Route::post('/annunci/{id}/premium', [ListingController::class, 'makeFeatured'])->name('listings.featured');

    // Dashboard e Profilo
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Messaggi / Inbox
    Route::get('/messaggi', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messaggi/{id}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    
    // Dashboard Candidato
    Route::get('/preferiti', [ListingController::class, 'mySaved'])->name('candidate.saved');
    Route::get('/mie-candidature', [ListingController::class, 'myApplications'])->name('candidate.applications');
});

require __DIR__.'/auth.php';