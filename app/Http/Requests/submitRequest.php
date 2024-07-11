<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class submitRequest extends FormRequest
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
            "code" => "required|exists:reset_codes,code",
            "password" => "required|same:confirmpassword",
            "confirmpassword" => "required|same:password"
        ];
    }
    public function messages(){
        return[
            'code.required' => 'le code est requis',
            'code.exists' => 'le code n\'est pas valide.Consulter votre boîte email',
            'password.same' => 'Le mot de passe ne correspond pas',
            'confirmpassword.same' => 'Le mot de passe n\'est pas correcte',
        ];
    }
}
