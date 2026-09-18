<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedListing extends Model
{
    protected $fillable = [
        'user_id',
        'listing_id',
    ];
}