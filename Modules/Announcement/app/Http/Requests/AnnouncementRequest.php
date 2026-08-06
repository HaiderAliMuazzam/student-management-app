<?php

namespace Modules\Announcement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Announcement Request
 *
 * Why a Form Request instead of inline $request->validate()?
 * -------------------------------------------------------------
 * Keeps validation rules out of the controller, reusable for both
 * store() and update(), and testable in isolation — same pattern
 * as StudentRequest/GradeRequest/SubjectRequest.
 */
class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ];
    }
}