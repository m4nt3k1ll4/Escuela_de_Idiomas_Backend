<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Level;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $levels = Level::all();

        foreach ($levels as $level) {
            Course::create(['name' => 'Course 1 for ' . $level->name, 'level_id' => $level->id]);
            Course::create(['name' => 'Course 2 for ' . $level->name, 'level_id' => $level->id]);
        }
    }
}
