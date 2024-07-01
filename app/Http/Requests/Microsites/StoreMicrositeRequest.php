<?php

namespace App\Http\Requests\Microsites;

use App\Constants\DocumentTypes;
use App\Constants\MicrositeTypes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMicrositeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiar a la lógica de autorización que necesites
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'slug' => 'required|string|max:50|unique:microsites,slug',
            'logo_url' => 'nullable|string|url',
            'category' => 'required|string|max:50',
            'microsite_type' => ['required', Rule::in(MicrositeTypes::values())],
            'currency_type' => 'required|string|max:50',
            'payment_expiration_time' => 'nullable|integer',
            'document_type' => ['nullable', Rule::in(DocumentTypes::values())],
            'document' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug must be unique.',
            'logo_url.url' => 'The logo URL must be a valid URL.',
            'category.required' => 'The category field is required.',
            'microsite_type.required' => 'The microsite type field is required.',
            'microsite_type.in' => 'The selected microsite type is invalid.',
            'currency_type.required' => 'The currency type field is required.',
            'payment_expiration_time.integer' => 'The payment expiration time must be an integer.',
            'document_type.in' => 'The selected document type is invalid.',
            'document.max' => 'The document may not be greater than 50 characters.',
            'is_active.boolean' => 'The is active field must be true or false.',
        ];
    }
}
