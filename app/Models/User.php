<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * I campi che possono essere compilati in massa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_name',
        'phone',
        'city',
        'avatar',
        'is_verified',
        'bio',
    ];

    /**
     * I campi che devono essere nascosti per la serializzazione.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * I tipi di dato per i cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    // --- RELAZIONI E METODI AGGIUNTIVI PER LA PIATTAFORMA ---

    public function listings() { 
        return $this->hasMany(Listing::class); 
    }
    
    public function sentMessages() { 
        return $this->hasMany(\App\Models\Message::class, 'sender_id'); 
    }
    
    public function receivedMessages() { 
        return $this->hasMany(\App\Models\Message::class, 'receiver_id'); 
    }
    
    public function reviewsReceived() { 
        return $this->hasMany(\App\Models\Review::class, 'reviewed_id'); 
    }

    public function isEmployer() { 
        return $this->role === 'employer'; 
    }
}