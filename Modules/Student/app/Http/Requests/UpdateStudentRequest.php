<?php

namespace Modules\Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateStudentRequest
 *
 * Handles authorization and input validation for updating an existing Student record.
 */
class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the authenticated user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'           => ['sometimes', 'required', 'string', 'max:255'],
            'grade_id'       => ['sometimes', 'required', 'integer', 'exists:grades,id'],
            'subject_id'     => ['sometimes', 'required', 'integer', 'exists:subjects,id'],
            'contact_number' => ['nullable', 'string', 'max:20'],
        ];
    }
}