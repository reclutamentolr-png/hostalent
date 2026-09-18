<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cucina',
                'icon' => 'fas fa-utensils',
                'description' => 'Chef, Aiuto Cuoco, Lavapiatti, Pizzaiolo'
            ],
            [
                'name' => 'Sala e Bar',
                'icon' => 'fas fa-wine-glass-alt',
                'description' => 'Cameriere, Barista, Sommelier, Maître'
            ],
            [
                'name' => 'Reception',
                'icon' => 'fas fa-concierge-bell',
                'description' => 'Receptionist, Portiere di notte, Addetto booking'
            ],
            [
                'name' => 'Housekeeping',
                'icon' => 'fas fa-broom',
                'description' => 'Cameriere ai piani, Governante, Addetto alle pulizie'
            ],
            [
                'name' => 'Management',
                'icon' => 'fas fa-user-tie',
                'description' => 'Direttore, Responsabile di sala, Executive Chef'
            ],
            [
                'name' => 'Animazione e Eventi',
                'icon' => 'fas fa-music',
                'description' => 'Animatore, Organizzatore eventi, Wedding planner'
            ],
            [
                'name' => 'Manutenzione',
                'icon' => 'fas fa-tools',
                'description' => 'Tuttofare, Giardiniere, Manutentore strutture'
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'slug' => Str::slug($category['name']),
                    'icon' => $category['icon'],
                ]
            );
        }
    }
}