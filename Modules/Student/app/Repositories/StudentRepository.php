<?php

namespace Modules\Student\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Grade\Models\Grade;
use Modules\Student\Models\Student;
use Modules\Student\Repositories\Contracts\StudentRepositoryInterface;
use Modules\Subject\Models\Subject;

/**
 * Class StudentRepository
 *
 * Concrete implementation of StudentRepositoryInterface.
 * Encapsulates all Eloquent persistence operations and denormalization logic for the Student domain.
 */
class StudentRepository implements StudentRepositoryInterface
{
    /**
     * Retrieve a paginated collection of active students with optional filtering.
     *
     * @param array $filters Key-value query parameters ('search', 'grade', 'subject')
     * @return LengthAwarePaginator
     */
    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = Student::query();

        // Filter by student name using wildcards
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }

        // Filter by grade name or ID
        if (! empty($filters['grade'])) {
            $query->where('grade', $filters['grade']);
        }

        // Filter by subject name or ID
        if (! empty($filters['subject'])) {
            $query->where('subject', $filters['subject']);
        }

        return $query->paginate(10)->withQueryString();
    }

    /**
     * Store a new Student record.
     * Fetches related Grade and Subject models to populate denormalized string columns.
     *
     * @param array $data Validated input attributes
     * @return Student
     */
    public function create(array $data): Student
    {
        // Fetch related models to resolve string names
        $grade   = Grade::find($data['grade_id'] ?? null);
        $subject = Subject::find($data['subject_id'] ?? null);

        // Populate denormalized columns with nullsafe checks
        $data['grade']   = $grade?->name;
        $data['subject'] = $subject?->name;

        return Student::create($data);
    }

    /**
     * Update an existing Student record.
     *
     * @param Student $student Target model instance
     * @param array $data Validated update parameters
     * @return Student
     */
    public function update(Student $student, array $data): Student
    {
        $student->update($data);

        return $student;
    }

    /**
     * Soft-delete a student model instance.
     *
     * @param Student $student
     * @return void
     */
    public function delete(Student $student): void
    {
        $student->delete();
    }

    /**
     * Retrieve a paginated collection of soft-deleted student records.
     *
     * @return LengthAwarePaginator
     */
    public function trashed(): LengthAwarePaginator
    {
        return Student::onlyTrashed()->paginate(10);
    }

    /**
     * Restore a soft-deleted student record by primary key.
     *
     * @param int $id
     * @return void
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function restore(int $id): void
    {
        Student::onlyTrashed()->findOrFail($id)->restore();
    }
}