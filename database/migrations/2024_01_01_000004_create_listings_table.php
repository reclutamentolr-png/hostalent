<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Chi pubblica
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained()->onDelete('cascade');
            
            $table->string('title'); // es: "Cameriere di sala esperto"
            $table->text('description'); // Dettagli dell'offerta
            $table->string('city'); // Città o provincia
            $table->string('salary_range')->nullable(); // es: "1200-1500€/mese" o "A partire da 10€/ora"
            
            $table->date('start_date')->nullable(); // Data inizio prevista
            $table->date('end_date')->nullable(); // Data fine (per stagionali)
            
            $table->boolean('is_featured')->default(false); // Annuncio a pagamento/in evidenza
            $table->enum('status', ['pending', 'active', 'closed', 'rejected'])->default('pending');
            $table->unsignedInteger('views_count')->default(0);
            
            $table->timestamps();

            // Indici per velocizzare le ricerche (fondamentale per SQLite e PostgreSQL)
            $table->index(['city', 'status']);
            $table->index(['category_id', 'status']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};