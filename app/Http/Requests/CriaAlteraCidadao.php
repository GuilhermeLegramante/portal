<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriaAlteraCidadao extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'cpf' => 'required|unique:cad_pessoa,documento',
            'password' => 'required|min:6|confirmed',
            'email' => 'required|unique:users,email|max:100',
            'telefone' => 'required',
            'cep' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
        ];
    }

    /*
     * Customizar as mensagens de validação (se preciso)
     */
    public function messages()
    {
        return [];
        // return [
        //     'name.required' => 'o campo Nome Completo é obrigatório.',
        // ];
    }
}
