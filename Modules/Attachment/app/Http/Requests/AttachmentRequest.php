<?php

namespace Modules\Attachment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:5120', // 5MB, in kilobytes
                'mimes:pdf,doc,docx,jpg,jpeg,png,xlsx,csv',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please select a file to upload.',
            'file.max'      => 'File size must not exceed 5MB.',
            'file.mimes'    => 'Unsupported file type. Allowed: PDF, Word, Excel, CSV, or images.',
        ];
    }
}