<?php

namespace App\Repositories\Contracts;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

interface StudentRepositoryInterface
{
    public function all(array $filters = []): \Illuminate\Pagination\LengthAwarePaginator;
    public function create(array $data): Student;
    public function update(Student $student, array $data): Student;
    public function delete(Student $student): void;
    public function trashed(): \Illuminate\Pagination\LengthAwarePaginator;
    public function restore(int $id): void;
}