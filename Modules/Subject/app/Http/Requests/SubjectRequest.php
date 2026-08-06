<?php

namespace Modules\Subject\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // route('subject') is the {subject} route param — used to ignore
        // this subject's own row when checking uniqueness during update
        $subjectId = $this->route('subject');

        return [
            'name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[A-Za-z0-9\s\-]+$/', // letters, numbers, spaces, hyphens only — same rule as Grade
                Rule::unique('subjects', 'name')->ignore($subjectId),
            ],
        ];
    }
}