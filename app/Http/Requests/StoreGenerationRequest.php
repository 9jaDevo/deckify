<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreGenerationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'source_text' => ['nullable', 'string', 'max:50000'],
            'source_file' => ['nullable', 'file', 'mimes:doc,docx', 'max:10240'],
            'provider' => ['required', 'in:openai,grok'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'source_text.max' => 'Text input must be 50,000 characters or fewer.',
            'source_file.mimes' => 'Upload a DOC or DOCX file only.',
            'source_file.max' => 'The uploaded file must be 10MB or smaller.',
            'provider.required' => 'Choose an AI provider to continue.',
            'provider.in' => 'Selected AI provider is not supported.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $sourceText = (string) ($this->input('source_text') ?? '');

            if (trim($sourceText) === '' && ! $this->hasFile('source_file')) {
                $validator->errors()->add('source_text', 'Provide text or upload a DOCX file.');
            }
        });
    }
}
