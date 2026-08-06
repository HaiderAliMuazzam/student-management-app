<?php

namespace Modules\Subject\Repositories\Contracts;

use Modules\Subject\Models\Subject;

interface SubjectRepositoryInterface
{
    // Get all subjects
    public function all();

    // Find a single subject by id
    public function find(int $id): Subject;

    // Create a new subject
    public function create(array $data): Subject;

    // Update an existing subject
    public function update(int $id, array $data): Subject;

    // Delete a subject
    public function delete(int $id): void;
}