<?php

namespace Modules\Announcement\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Attachment\Traits\HasAttachments;

/**
 * Announcement Model
 *
 * Represents an announcement that can be displayed
 * to users within the application.
 */
class Announcement extends Model
{
    use HasAttachments;

    /**
     * The attributes that can be mass assigned.
     *
     * Using $fillable protects against Mass Assignment
     * vulnerabilities by allowing only these fields to
     * be assigned through create() or update().
     */
    protected $fillable = [
        'title',
        'body',
    ];
}