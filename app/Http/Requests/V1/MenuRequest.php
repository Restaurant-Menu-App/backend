<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'price' => 'required|integer|min:0',
            'desc' => 'nullable|string|min:3',
            'priority' => 'nullable|integer|max:5',
            'restaurant' => 'required|numeric|exists:restaurants,id',
            'category' => 'required|numeric|exists:categories,id',
            'medias' => 'nullable',
            'medias.*' => 'mimes:jpg,jpeg,png|max:102400',
        ];
    }
}
