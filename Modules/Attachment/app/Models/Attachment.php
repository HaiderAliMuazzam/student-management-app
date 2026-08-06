<?php

namespace Modules\Attachment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    protected $fillable = [
        'attachable_type',
        'attachable_id',
        'file_path',
        'file_name',
        'mime_type',
        'size',
        'uploaded_by',
    ];

    // The parent model this attachment belongs to (Announcement, Student, etc.)
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    // The user who uploaded this file
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    // Public URL to the stored file (requires `php artisan storage:link`)
    public function getUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }
}