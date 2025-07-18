<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'whatsapp' => 'required|numeric|digits_between:10,15',
           
            'email' => 'required|email',
        
        ];
    }

    public function messages(): array
    {
        return [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',

        ];
    }
}
