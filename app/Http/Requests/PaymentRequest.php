<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'reference' => 'required',
            'employer_id' => 'required',
            'amount' => 'required|numeric',
            'launch_date' => 'required|date',
            'status' => 'required',
            'month' => 'required',
            'year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reference.required' => 'Le champs reference est requis',
            'employer_id.required' => 'Le champ nom est requis',
            'amount.required' => 'Le champ amount est requis',
            'launch_date.required' => 'le date est déjà pris',
            'status.required' => 'Le champ status est requis',
            'month.unique' => 'Le mois est déjà pris',
            'year.required' => 'L\'année est requis',
        ];
    }
}

