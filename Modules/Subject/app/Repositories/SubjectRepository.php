<?php

namespace Modules\Subject\Repositories;

use Modules\Subject\Models\Subject;
use Modules\Subject\Repositories\Contracts\SubjectRepositoryInterface;

class SubjectRepository implements SubjectRepositoryInterface
{
    public function all()
    {
        // Ordered alphabetically — subjects are a small lookup table,
        // so a plain list (no pagination) makes more sense than Invoice/Student.
        return Subject::orderBy('name')->get();
    }

    public function find(int $id): Subject
    {
        return Subject::findOrFail($id);
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(int $id, array $data): Subject
    {
        $subject = Subject::findOrFail($id);
        $subject->update($data);

        return $subject;
    }

    public function delete(int $id): void
    {
        Subject::findOrFail($id)->delete();
    }
}