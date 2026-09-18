<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'job_type_id', 'title', 'description',
        'city', 'salary_range', 'start_date', 'end_date', 'is_featured', 'status'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function jobType() { return $this->belongsTo(JobType::class); }
    public function messages() { return $this->hasMany(Message::class); }
    
    // Scope per prendere solo gli annunci attivi e approvati
    public function scopeActive($query) {
        return $query->where('status', 'active');
    }
}