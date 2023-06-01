<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'price' => ['required', 'numeric'],
            'crop_id' => ['required', 'exists:crops,id'],
        ];
    }
}
