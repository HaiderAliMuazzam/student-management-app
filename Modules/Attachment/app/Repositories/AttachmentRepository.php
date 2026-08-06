<?php

namespace Modules\Attachment\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Attachment\Models\Attachment;
use Modules\Attachment\Repositories\Contracts\AttachmentRepositoryInterface;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    public function store(Model $attachable, UploadedFile $file, ?int $uploadedBy = null): Attachment
    {
        // Store file on the 'public' disk under an 'attachments' folder
        // Accessible via URL once `php artisan storage:link` has been run
        $path = $file->store('attachments', 'public');

        return $attachable->attachments()->create([
            'file_path'   => $path,
            'file_name'   => $file->getClientOriginalName(),
            'mime_type'   => $file->getClientMimeType(),
            'size'        => $file->getSize(),
            'uploaded_by' => $uploadedBy,
        ]);
    }

    public function delete(Attachment $attachment): bool
    {
        // Remove the physical file first, then the DB record
        Storage::disk('public')->delete($attachment->file_path);

        return $attachment->delete();
    }

    public function getFor(Model $attachable)
    {
        return $attachable->attachments()->get();
    }
}