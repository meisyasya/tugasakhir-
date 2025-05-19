<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGaleriRequest extends FormRequest
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
            'category_id' => 'required|exists:category_galeris,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                Rule::unique('galeris', 'slug')->ignore($this->galeri), // <--- ini penting buat update
            ],
            'desc' => 'required|string',
            'img' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // tidak wajib saat update
        ];
    }
}
