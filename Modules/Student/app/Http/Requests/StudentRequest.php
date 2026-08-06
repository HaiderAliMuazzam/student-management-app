<?php

namespace Modules\Student\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('manage-students');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            // Student must belong to an existing grade record
            'grade_id' => ['required', 'integer', 'exists:grades,id'],

            // Student must belong to an existing subject record
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],

            // Restricts input strictly to digits and enforces standard phone length
            'contact_number' => ['required', 'numeric', 'digits_between:10,15'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'contact_number.numeric' => 'The contact number must contain numbers only.',
            'contact_number.digits_between' => 'The contact number must be between 10 and 15 digits long.',
            'grade_id.exists' => 'The selected grade does not exist in the database.',
            'subject_id.exists' => 'The selected subject does not exist in the database.',
        ];
    }
}