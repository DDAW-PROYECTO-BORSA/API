<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @OA\Schema(
 *      title="Empresa request",
 *      description="Request de empresa",
 *      type="object",
 *      required={"name","CIF","email","password","direccion","contacto"}
 * )
 */

class EmpresaRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'direccion' => 'required|min:4',
            'contacto' => 'required',
            'web' => ['sometimes','url']
        ];

        if($this->method() == 'post'){
            $rules['email'] = 'email:rfc,dns';
            $rules['password'] = ['required', Password::min(8)->letters()->mixedCase()->numbers()];
            $rules['CIF'] = 'required|min:9|max:9,unique';
        } elseif ($this->method() == 'put' || $this->method() == 'patch') {
            $rules['password'] = ['sometimes', Password::min(8)->letters()->mixedCase()->numbers()];
        }
    return $rules;
    }
}
