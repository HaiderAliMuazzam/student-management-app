<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_view_students_page(): void
    {
        $response = $this->get('/students');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_students_page(): void
    {
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get('/students');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_a_student(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/students', [
            'name' => 'Test Student',
            'grade' => 'A',
            'subject' => 'Math',
            'contact_number' => '+923001234567',
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', ['name' => 'Test Student']);
    }

    public function test_student_role_cannot_create_a_student(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->post('/students', [
            'name' => 'Blocked Student',
            'grade' => 'A',
            'subject' => 'Math',
            'contact_number' => '+923001234567',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('students', ['name' => 'Blocked Student']);
    }

    public function test_creating_a_student_requires_all_fields(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/students', []);

        $response->assertSessionHasErrors(['name', 'grade', 'subject', 'contact_number']);
    }

    public function test_admin_can_delete_a_student(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = Student::factory()->create();

        $response = $this->actingAs($admin)->delete("/students/{$student->id}");

        $response->assertRedirect('/students');
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }

    public function test_teacher_cannot_delete_a_student(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = Student::factory()->create();

        $response = $this->actingAs($teacher)->delete("/students/{$student->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('students', ['id' => $student->id]);
    }
}