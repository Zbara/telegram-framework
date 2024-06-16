<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class SetStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer' ,'exists:languages,id'],
            'status' => ['required', 'integer', 'in:0,1'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
