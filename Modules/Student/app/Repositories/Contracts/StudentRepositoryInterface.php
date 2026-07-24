<?php
namespace Modules\Student\Repositories\Contracts;
use Modules\Student\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
interface StudentRepositoryInterface
{
    public function all(array $filters = []): LengthAwarePaginator;
    public function create(array $data): Student;
    public function update(Student $student, array $data): Student;
    public function delete(Student $student): void;
    public function trashed(): LengthAwarePaginator;
    public function restore(int $id): void;
}