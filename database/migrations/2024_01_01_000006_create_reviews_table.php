<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade'); // Chi lascia la recensione
            $table->foreignId('reviewed_id')->constrained('users')->onDelete('cascade'); // Chi riceve la recensione
            $table->foreignId('listing_id')->nullable()->constrained()->onDelete('set null'); // Annuncio di riferimento
            
            $table->tinyInteger('rating')->unsigned(); // Da 1 a 5
            $table->text('comment')->nullable();
            
            $table->timestamps();

            // Impedisce di recensire la stessa persona più volte per lo stesso annuncio
            $table->unique(['reviewer_id', 'reviewed_id', 'listing_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};