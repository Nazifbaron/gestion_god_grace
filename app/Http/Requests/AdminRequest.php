<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
           
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le champ name est requis',
            'email.required' => 'Le champs email est requis',
            'email.email' => 'Ce mail n\'est pas valide',
            'email.unique' => 'Ce mail est déjà pris en compte',
            
        ];
    }
}
