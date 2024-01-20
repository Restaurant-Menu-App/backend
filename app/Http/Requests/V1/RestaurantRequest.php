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
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|numeric|digits_between:5,11',
            'email' => 'nullable|email',
            'website_url' => 'nullable|url:http,https',
            'facebook_url' => 'nullable|url:http,https',
            'address' => "nullable|string|max:255",
            'desc' => 'nullable|string',
            'open_time' => 'nullable|date',
            'close_time' => 'nullable|date',
            'close_on' => 'nullable|string',
            'categories' => 'required|array',
            'categories.*' => 'numeric|exists:categories,id',
            // image
            'image' => 'nullable|mimes:jpg,jpeg,png|max:102400',
        ];
    }
}
