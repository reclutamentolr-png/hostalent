<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Scommenta la riga sotto se vuoi anche un utente admin/test di prova
        // $this->call(UserSeeder::class);

        $this->call([
            CategorySeeder::class,
            JobTypeSeeder::class,
        ]);
    }
}