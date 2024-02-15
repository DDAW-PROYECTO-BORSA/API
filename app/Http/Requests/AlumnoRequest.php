<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *      title="Alumno request",
 *      description="Request de alumno",
 *      type="object",
 *      required={"name","apellido","email","password","direccion"}
 * )
 */

class AlumnoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'apellido' => 'required',
            'email' => 'email:rfc,dns',
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
            'direccion' => 'required|min:4',
        ];
    }
}
