<?php
namespace Modules\Student\Database\Factories;

use Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'grade' => fake()->randomElement(['A', 'A+', 'B', 'B+', 'C', 'Grade 9', 'Grade 10', 'BSc Semester 3']),
            'subject' => fake()->randomElement(['Math', 'Physics', 'English', 'Chemistry', 'Biology', 'Computer Science']),
            'contact_number' => fake()->numerify('+92 3## #######'),
        ];
    }
}