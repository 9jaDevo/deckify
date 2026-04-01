<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RefineGenerationSlideRequest extends FormRequest
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
            'slide_index' => ['required', 'integer', 'min:0'],
            'prompt' => ['required', 'string', 'min:3', 'max:2000'],
        ];
    }
}
