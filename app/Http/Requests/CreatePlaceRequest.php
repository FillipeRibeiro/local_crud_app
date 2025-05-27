<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePlaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'city' => ['required', 'string', 'min:3', 'max:250'],
            'state' => ['required', 'string', 'min:2', 'max:2'],
        ];
    }
}
