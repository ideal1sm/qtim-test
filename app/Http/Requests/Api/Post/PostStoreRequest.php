<?php

namespace App\Http\Requests\Api\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:App\Models\Post',
            'description' => 'required|string|max:2000',
            'preview_image' => 'nullable|file|mimes:pdf,jpg,jpeg,png,bmp',
            'detail_image'  => 'nullable|file|mimes:pdf,jpg,jpeg,png,bmp',
        ];
    }
}
