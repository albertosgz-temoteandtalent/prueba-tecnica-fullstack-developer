<?php

namespace App\Http\Requests;

use App\Models\PerfilUsuario;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePerfilUsuarioRequest extends FormRequest
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
            'nombre' => ['string', 'max:255','nullable'],
            'apellidos' => ['string', 'max:255','nullable'],
            'telefono' => ['string', 'max:255','nullable'],
            'correo' => ['email', 'max:255','nullable'],
            'imagen' => ['string', 'max:255','nullable'],
        ];
    }
}
