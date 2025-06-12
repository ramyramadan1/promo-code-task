<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePromoCodeRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
          return [
            'promo_cod'            => ['nullable', 'string'],
            'expiry_date'          => ['nullable', 'date'],
            'max_usage_per_user'   => ['nullable', 'integer'],
            'max_usage'            => ['nullable', 'integer'],
            'users'                => ['nullable', 'array'],
            'users.*'              => ['integer'],
            'promo_type'           => ['required', Rule::in(['percentage', 'value'])],
            'value'                => ['required', 'numeric'],
        ];
    }
}
