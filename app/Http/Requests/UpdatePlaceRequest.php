<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlaceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['string', 'min:3', 'max:120'],
            'city' => ['string', 'min:3', 'max:250'],
            'state' => ['string', 'min:2', 'max:2'],
        ];
    }
}
