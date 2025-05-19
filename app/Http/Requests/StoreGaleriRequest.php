<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGaleriRequest extends FormRequest
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
            'category_id' => 'required|exists:category_galeris,id', // Updated to match table name
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:galeris,slug', // Ensure this matches your actual table name
            'desc' => 'required|string',
            'img' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ];
    }
}
