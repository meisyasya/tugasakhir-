<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
            'category_id' => 'required|exists:category_articles,id', // Ubah ke tabel yang benar
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string',
            'desc' => 'required|string',
            'img' => 'nullable|image|file|mimes:png,jpg,jpeg|max:2024', // Tidak wajib
            'status' => 'required|in:0,1',
            'publish_date' => 'required|date',
        ];
    }
}
