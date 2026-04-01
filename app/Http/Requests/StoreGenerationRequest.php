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
            'source_text' => ['nullable', 'string'],
            'source_file' => ['nullable', 'file', 'mimes:doc,docx', 'max:10240'],
            'provider' => ['required', 'in:openai,grok'],
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
