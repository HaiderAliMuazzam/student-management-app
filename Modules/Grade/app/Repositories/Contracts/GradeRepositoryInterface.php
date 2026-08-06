<?php

namespace Modules\Grade\Repositories\Contracts;

use Modules\Grade\Models\Grade;

interface GradeRepositoryInterface
{
    public function all();

    public function find(int $id): Grade;

    public function create(array $data): Grade;

    public function update(int $id, array $data): Grade;

    public function delete(int $id): void;
}