<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class EditLangTextRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'exists:translations,key'],
            'text' => ['required', 'array'],
            'text.*' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
