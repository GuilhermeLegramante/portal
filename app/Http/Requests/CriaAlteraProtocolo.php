<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriaAlteraProtocolo extends FormRequest
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
        $rules = [
            'prioridade' => 'required',
            'assunto' => 'required',
            'descricao' => 'required|min:10|max:5000',
            'tipodocumento' => 'required',
            'origem' => 'required',
            'assunto' => 'required',
            'informacoesadicionais' => 'max:100',
        ];

        $anexos = (is_array($this->input('anexos')) ? count($this->input('anexos')) : 0);

        foreach (range(0, $anexos) as $index) {
            $rules['anexos.' . $index] = 'mimes:pdf,xlx,csv,jpeg,bmp,png|max:2048';
        }

        return $rules;
    }
}
