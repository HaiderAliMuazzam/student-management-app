<?php

namespace Modules\Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Authorize only admin users to create students.
     * Non-admins receive HTTP 403 Forbidden.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'grade_id'       => ['required', 'exists:grades,id'],
            'subject_id'     => ['required', 'exists:subjects,id'],
            'contact_number' => ['nullable', 'string', 'max:20'],
        ];
    }
}