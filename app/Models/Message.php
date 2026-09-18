<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // I campi che possono essere compilati in massa (Mass Assignment)
    protected $fillable = [
        'listing_id',
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
    ];

    // Converte automaticamente is_read in vero/falso (boolean)
    protected $casts = [
        'is_read' => 'boolean',
    ];

    // --- RELAZIONI ---
    public function listing() { 
        return $this->belongsTo(Listing::class); 
    }
    
    public function sender() { 
        return $this->belongsTo(User::class, 'sender_id'); 
    }
    
    public function receiver() { 
        return $this->belongsTo(User::class, 'receiver_id'); 
    }
}