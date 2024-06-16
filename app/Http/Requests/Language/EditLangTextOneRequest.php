<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class EditLangTextOneRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'exists:translations,key'],
            'lang' => ['required', 'string', 'exists:languages,code'],
            'text' => ['required', 'string', 'min:1']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
