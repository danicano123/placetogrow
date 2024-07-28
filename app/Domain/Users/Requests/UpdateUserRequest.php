<?php

namespace App\Domain\Users\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    public function rules()
    {
        // Suponiendo que el método actual del controlador es 'update'
        $userId = $this->route('user')->id ?? null;

        if ($userId === null) {
            // Manejar el caso en que userId es null
            return [
                // reglas de validación para el caso de null
            ];
        }

        return [
            'name' => 'string|max:10',
            'email' => 'string|email|max:100|unique:users,email,' . $userId,
            // otras reglas de validación
        ];
    }

}
