<?php

namespace Modules\Attachment\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Attachment\Http\Requests\AttachmentRequest;
use Modules\Attachment\Models\Attachment;
use Modules\Attachment\Repositories\Contracts\AttachmentRepositoryInterface;

class AttachmentController extends Controller
{
    public function __construct(
        protected AttachmentRepositoryInterface $attachments
    ) {}

    /**
     * Store a newly uploaded file, attached to a given model.
     *
     * Expects 'attachable_type' and 'attachable_id' in the request,
     * so the controller knows which model (Announcement, Student, etc.)
     * this file belongs to.
     */
    public function store(AttachmentRequest $request)
    {
        $attachableClass = $request->input('attachable_type');
        $attachableId    = $request->input('attachable_id');

        $attachable = $attachableClass::findOrFail($attachableId);

        $this->attachments->store(
            $attachable,
            $request->file('file'),
            auth()->id()
        );

        return back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Delete an attachment (removes file from disk + DB record).
     */
    public function destroy(Attachment $attachment)
    {
        $this->attachments->delete($attachment);

        return back()->with('success', 'File deleted successfully.');
    }
}