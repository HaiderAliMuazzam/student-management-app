<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class StudentRepository implements StudentRepositoryInterface
{
    public function all(array $filters = []): \Illuminate\Pagination\LengthAwarePaginator
{
    $query = Student::query();

    if (!empty($filters['search'])) {
        $query->where('name', 'like', '%' . $filters['search'] . '%');
    }

    if (!empty($filters['grade'])) {
        $query->where('grade', $filters['grade']);
    }

    if (!empty($filters['subject'])) {
        $query->where('subject', $filters['subject']);
    }

    return $query->paginate(10)->withQueryString();
}

    public function create(array $data): Student
    {
        return Student::create($data);
    }

    public function update(Student $student, array $data): Student
    {
        $student->update($data);
        return $student;
    }

    public function delete(Student $student): void
    {
        $student->delete();
    }

    public function trashed(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Student::onlyTrashed()->paginate(10);
    }

    public function restore(int $id): void
    {
        Student::onlyTrashed()->findOrFail($id)->restore();
    }
}