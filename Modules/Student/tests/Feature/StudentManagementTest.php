<?php

namespace Modules\Student\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Grade\Models\Grade;
use Modules\Student\Models\Student;
use Modules\Subject\Models\Subject;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    private function getTestRelations(): array
    {
        $grade = Grade::firstOrCreate(['name' => 'Grade 10']);
        $subject = Subject::firstOrCreate(['name' => 'Mathematics']);

        return [$grade, $subject];
    }

    public function test_guest_cannot_view_students_page(): void
    {
        $response = $this->get('/students');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_students_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($user)->get('/students');
        $response->assertStatus(200);
    }

    public function test_admin_can_create_a_student(): void
    {
        Event::fake();

        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        [$grade, $subject] = $this->getTestRelations();

        $payload = [
            'name'           => 'Test Student',
            'grade_id'       => $grade->id,
            'subject_id'     => $subject->id,
            'contact_number' => '+923001234567',
        ];

        $response = $this->actingAs($admin)->post('/students', $payload);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'name'       => 'Test Student',
            'grade_id'   => $grade->id,
            'subject_id' => $subject->id,
        ]);
    }

    public function test_student_role_cannot_create_a_student(): void
    {
        /** @var User $studentUser */
        $studentUser = User::factory()->create(['role' => 'student']);
        [$grade, $subject] = $this->getTestRelations();

        $payload = [
            'name'           => 'Blocked Student',
            'grade_id'       => $grade->id,
            'subject_id'     => $subject->id,
            'contact_number' => '+923001234567',
        ];

        $response = $this->actingAs($studentUser)->post('/students', $payload);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('students', ['name' => 'Blocked Student']);
    }

    public function test_creating_a_student_requires_all_fields(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/students', []);

        $response->assertSessionHasErrors(['name', 'grade_id', 'subject_id']);
    }

    public function test_admin_can_update_a_student(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        [$grade, $subject] = $this->getTestRelations();

        $student = Student::factory()->create([
            'name'           => 'Old Name',
            'grade_id'       => $grade->id,
            'subject_id'     => $subject->id,
            'contact_number' => '+923001234567',
        ]);

        $payload = [
            'name'           => 'Updated Name',
            'grade_id'       => $grade->id,
            'subject_id'     => $subject->id,
            'contact_number' => '+923001234567',
        ];

        $response = $this->actingAs($admin)->put("/students/{$student->id}", $payload);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'id'   => $student->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_delete_a_student(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $student = Student::factory()->create();

        $response = $this->actingAs($admin)->delete("/students/{$student->id}");

        $response->assertRedirect('/students');
        $this->assertSoftDeleted('students', ['id' => $student->id]);
    }

    public function test_teacher_cannot_delete_a_student(): void
    {
        /** @var User $teacher */
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = Student::factory()->create();

        $response = $this->actingAs($teacher)->delete("/students/{$student->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('students', ['id' => $student->id]);
    }

    public function test_admin_can_restore_a_trashed_student(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $student = Student::factory()->create();
        $student->delete();

        $response = $this->actingAs($admin)->patch("/students/{$student->id}/restore");

        $response->assertRedirect('/students/trashed');
        $this->assertNotSoftDeleted('students', ['id' => $student->id]);
    }

    public function test_admin_can_force_delete_a_trashed_student(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $student = Student::factory()->create();
        $student->delete();

        $response = $this->actingAs($admin)->delete("/students/{$student->id}/force-delete");

        $response->assertRedirect('/students/trashed');
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}