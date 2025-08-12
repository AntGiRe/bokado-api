<?php

namespace App\Http\Requests\Manage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'address' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
            'show_prices' => 'boolean',
            'timezone' => 'string|max:50',
        ];
    }
}
