<?php

namespace Modules\Grade\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Core only, same as Subject — no factory, soft deletes, or activity log.

    protected $fillable = [
        'name',
    ];
}
