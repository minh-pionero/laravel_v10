<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'category_id' => 'required|int',
            'price' => 'required|int',
            'thumbnail' => 'string',
            'images' => 'string',
            'is_active' => 'bool',
            'short_description' => 'string',
            'description' => 'string',
            'source' => 'string',
            'preview_source_url' => 'string',
            'is_virtual_product' => 'bool',
        ];
    }
}
