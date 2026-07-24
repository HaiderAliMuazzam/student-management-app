<?php

namespace Modules\Student\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Student\Models\Student;

class StudentDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Student::factory()->count(15)->create();
    }
}