<?php

namespace Modules\Grade\Repositories;

use Modules\Grade\Models\Grade;
use Modules\Grade\Repositories\Contracts\GradeRepositoryInterface;

class GradeRepository implements GradeRepositoryInterface
{
    public function all()
    {
        return Grade::orderBy('name')->get();
    }

    public function find(int $id): Grade
    {
        return Grade::findOrFail($id);
    }

    public function create(array $data): Grade
    {
        return Grade::create($data);
    }

    public function update(int $id, array $data): Grade
    {
        $grade = Grade::findOrFail($id);
        $grade->update($data);

        return $grade;
    }

    public function delete(int $id): void
    {
        Grade::findOrFail($id)->delete();
    }
}