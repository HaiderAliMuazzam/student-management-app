<?php

namespace App\Repositories\Contracts;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;

interface EnrollmentRepositoryInterface
{
    public function all(): Collection;

    public function create(array $data): Enrollment;

    public function update(Enrollment $enrollment, array $data): Enrollment;

    public function delete(Enrollment $enrollment): void;
}
