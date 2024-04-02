<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployerRequest extends FormRequest
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
            'departement_id' => 'required|integer',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|unique:employers',
            'telephone' => 'required|unique:employers',
            'montant_journalier' => 'required',
  
        ];
    }

    public function messages(){
        return[
            'first_name.required' => 'Le champs nom est requis',
            'last_name.required' => 'Le champ prenom est requis',
            'email.required' => 'Le champ email est requis',
            'email.unique' => 'le mail est déjà pris',
            'telephone.required' => 'Le champ departement est requis',
            'telephone.unique' => 'Le numéro de téléphone est déjà pris',
            'montant_journalier.required' => 'Le champ montant_journalier est requis',

         ];
    }
}
