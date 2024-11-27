<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        Language::create(['name' => 'English']);
        Language::create(['name' => 'Spanish']);
        Language::create(['name' => 'French']);
    }
}
