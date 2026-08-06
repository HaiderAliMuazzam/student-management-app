<?php

namespace Modules\Attachment\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Modules\Attachment\Models\Attachment;

interface AttachmentRepositoryInterface
{
    // Store an uploaded file and attach it to the given model
    public function store(Model $attachable, UploadedFile $file, ?int $uploadedBy = null): Attachment;

    // Delete an attachment (removes both the DB record and the file from disk)
    public function delete(Attachment $attachment): bool;

    // Get all attachments for a given model
    public function getFor(Model $attachable);
}