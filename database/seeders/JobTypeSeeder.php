<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobType;
use Illuminate\Support\Str;

class JobTypeSeeder extends Seeder
{
    public function run(): void
    {
        $jobTypes = [
            ['name' => 'Full-time', 'description' => '40 ore settimanali, contratto standard'],
            ['name' => 'Part-time', 'description' => 'Orario ridotto, mattina o sera'],
            ['name' => 'Stagionale', 'description' => 'Contratto a termine per la stagione (es. estiva o invernale)'],
            ['name' => 'Weekend', 'description' => 'Solo sabato e domenica, ideale per studenti o extra'],
            ['name' => 'Occasionale / Extra', 'description' => 'Singoli turni o sostituzioni last-minute'],
            ['name' => 'Stage / Tirocinio', 'description' => 'Prima esperienza formativa retribuita']
        ];

        foreach ($jobTypes as $type) {
            JobType::updateOrCreate(
                ['name' => $type['name']],
                ['slug' => Str::slug($type['name'])]
            );
        }
    }
}