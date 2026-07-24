<?php

namespace App\Repositories\Contracts;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

interface TeacherRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): Teacher;

    public function update(Teacher $teacher, array $data): Teacher;

    public function delete(Teacher $teacher): void;
}
