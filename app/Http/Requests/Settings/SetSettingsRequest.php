<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SetSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bot_token' => ['required', 'string'],
            'bot_username' => ['required', 'string'],
            'language' => ['required', 'integer', 'exists:languages,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
