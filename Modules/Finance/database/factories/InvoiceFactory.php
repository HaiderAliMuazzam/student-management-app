<?php

namespace Modules\Finance\Database\Factories;

use Modules\Finance\Models\Invoice;
use Modules\Finance\Enums\InvoiceStatus;
use Modules\Student\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // amount is a random fee-like figure; amount_paid starts at 0 by default,
        // since a freshly created invoice hasn't been paid yet (Payment will change this later)
        return [
            // Cross-module factory reference: creates a real Student row and uses its id.
            // Using Student::factory() instead of a raw fake id keeps referential integrity.
            'student_id' => Student::factory(),
            'title' => fake()->randomElement(['Tuition Fee', 'Semester Fee', 'Admission Fee', 'Exam Fee', 'Lab Fee']),
            'amount' => fake()->randomFloat(2, 5000, 100000),
            'amount_paid' => 0,
            'status' => InvoiceStatus::Pending,
            'due_date' => fake()->dateTimeBetween('now', '+2 months'),
        ];
    }
}