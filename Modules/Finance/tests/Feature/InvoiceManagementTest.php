<?php

namespace Modules\Finance\Tests\Feature;

use App\Models\User;
use Modules\Finance\Models\Invoice;
use Modules\Student\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_invoices_page(): void
    {
        $response = $this->get('/invoices');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_invoices_page(): void
    {
        $user = User::factory()->create(['role' => 'student']);
        $response = $this->actingAs($user)->get('/invoices');
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_create_an_invoice(): void
    {
        // NOTE: no Gate restriction on invoice creation yet — any authenticated
        // user can create one. Update this test once manage-invoices Gate exists.
        $user = User::factory()->create(['role' => 'admin']);
        $student = Student::factory()->create();

        $response = $this->actingAs($user)->post('/invoices', [
            'student_id' => $student->id,
            'title' => 'Test Invoice',
            'amount' => 5000,
            'due_date' => now()->addMonth()->format('Y-m-d'),
        ]);

        $response->assertRedirect('/invoices');
        $this->assertDatabaseHas('invoices', ['title' => 'Test Invoice']);
    }

    public function test_creating_an_invoice_requires_all_fields(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($user)->post('/invoices', []);
        $response->assertSessionHasErrors(['student_id', 'title', 'amount', 'due_date']);
    }

    public function test_authenticated_user_can_update_an_invoice(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $invoice = Invoice::factory()->create(['title' => 'Old Title']);

        $response = $this->actingAs($user)->put("/invoices/{$invoice->id}", [
            'student_id' => $invoice->student_id,
            'title' => 'Updated Title',
            'amount' => $invoice->amount,
            'due_date' => $invoice->due_date->format('Y-m-d'),
        ]);

        $response->assertRedirect('/invoices');
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'title' => 'Updated Title']);
    }

    public function test_authenticated_user_can_delete_an_invoice(): void
    {
        // NOTE: no Gate restriction on invoice deletion yet — any authenticated
        // user can delete one. Update this test once delete-invoice Gate exists.
        $user = User::factory()->create(['role' => 'admin']);
        $invoice = Invoice::factory()->create();

        $response = $this->actingAs($user)->delete("/invoices/{$invoice->id}");

        $response->assertRedirect('/invoices');
        $this->assertSoftDeleted('invoices', ['id' => $invoice->id]);
    }

    public function test_authenticated_user_can_restore_a_deleted_invoice(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $invoice = Invoice::factory()->create();
        $invoice->delete();

        $response = $this->actingAs($user)->patch("/invoices/{$invoice->id}/restore");

        $response->assertRedirect('/invoices/trashed');
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'deleted_at' => null]);
    }
}