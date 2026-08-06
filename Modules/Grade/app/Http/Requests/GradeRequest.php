<?php

namespace Modules\Grade\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $gradeId = $this->route('grade');

        return [
            'name' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9\s\-]+$/',
                Rule::unique('grades', 'name')->ignore($gradeId),
            ],
        ];
    }
}