<?php

namespace Modules\Subject\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // Kept minimal per our "core only" standard for this module —
    // no factory, no soft deletes, no activity log for now.

    protected $fillable = [
        'name',
    ];
}