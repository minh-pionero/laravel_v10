<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|int',
            'title' => 'required|string|max:255',
            'thumbnail' => 'string',
            'short_description' => 'string',
            'content' => 'string',
            'is_draft' => 'bool',
            'is_delete' => 'bool',
        ];
    }
}
