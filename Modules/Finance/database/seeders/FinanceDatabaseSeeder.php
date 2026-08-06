<?php

namespace Modules\Finance\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Finance\Models\Invoice;

class FinanceDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creates 15 invoices, each with its own freshly generated Student
        // via the factory's student_id => Student::factory() relationship.
        Invoice::factory()->count(15)->create();
    }
}