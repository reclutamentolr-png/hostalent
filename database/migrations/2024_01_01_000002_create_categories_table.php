<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // es: "Cucina", "Sala", "Reception", "Housekeeping"
            $table->string('slug')->unique(); // es: "cucina"
            $table->string('icon')->nullable(); // es: "fas fa-utensils" (FontAwesome)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};