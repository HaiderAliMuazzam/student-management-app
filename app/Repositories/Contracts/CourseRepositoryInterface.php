<?php

namespace App\Repositories\Contracts;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    public function all(): Collection;
    public function create(array $data): Course;
    public function update(Course $course, array $data): Course;
    public function delete(Course $course): void;
}