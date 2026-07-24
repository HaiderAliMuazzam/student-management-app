<?php
namespace Modules\Student\Repositories;
use Modules\Student\Events\StudentCreated;
use Modules\Student\Models\Student;
use Modules\Student\Repositories\Contracts\StudentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
class StudentRepository implements StudentRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator
    {
        $query = Student::query();
        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%'.$filters['search'].'%');
        }
        if (! empty($filters['grade'])) {
            $query->where('grade', $filters['grade']);
        }
        if (! empty($filters['subject'])) {
            $query->where('subject', $filters['subject']);
        }
        return $query->paginate(10)->withQueryString();
    }
    public function create(array $data): Student
    {
        $student = Student::create($data);
        StudentCreated::dispatch($student);
        return $student;
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
    public function trashed(): LengthAwarePaginator
    {
        return Student::onlyTrashed()->paginate(10);
    }
    public function restore(int $id): void
    {
        Student::onlyTrashed()->findOrFail($id)->restore();
    }
}