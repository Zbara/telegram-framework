<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class CreatedLangTextRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'unique:translations,key'],
            'text' => ['required', 'array'],
            'text.*' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
