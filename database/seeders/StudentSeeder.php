<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $student1 = Student::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'level_id' => 1 
        ]);

        $student2 = Student::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
            'level_id' => 2
        ]);


        $student1->courses()->attach([1, 2]);
        $student2->courses()->attach([2, 3]);
    }
}
