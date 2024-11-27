<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
use App\Models\Language;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $languages = Language::all();

        foreach ($languages as $language) {
            Level::create(['name' => 'A', 'language_id' => $language->id]);
            Level::create(['name' => 'B', 'language_id' => $language->id]);
            Level::create(['name' => 'C', 'language_id' => $language->id]);
        }
    }
}
