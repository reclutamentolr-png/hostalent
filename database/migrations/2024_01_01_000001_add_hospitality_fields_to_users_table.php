<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['candidate', 'employer'])->default('candidate')->after('email');
            $table->string('company_name')->nullable()->after('role'); // Solo per datori di lavoro
            $table->string('phone')->nullable()->after('company_name');
            $table->string('city')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('city');
            $table->boolean('is_verified')->default(false)->after('avatar');
            $table->text('bio')->nullable()->after('is_verified'); // Breve descrizione o esperienze
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'company_name', 'phone', 'city', 'avatar', 'is_verified', 'bio']);
        });
    }
};