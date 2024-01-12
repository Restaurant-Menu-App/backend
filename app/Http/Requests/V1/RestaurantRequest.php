<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
        // $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        return [
            'name' => 'required|string|min:3',
            'phone' => 'required|numeric',
            'email' => 'nullable|email',
            'website_url' => 'nullable|url:http,https',
            'desc' => 'nullable|string',
            'open_time' => 'nullable|date',
            'close_time' => 'nullable|date'
        ];
    }
}
