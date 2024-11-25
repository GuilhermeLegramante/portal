<?php

namespace App\Http\Livewire;

use DB;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    public $cpfcnpj;
    public $password;
    public $password_confirmation;
    public $pin;

    protected $rules = [
        'cpfcnpj' => 'required|min:10',
        'pin' => 'required|min:5',
        'password' => 'confirmed',
    ];

    protected $validationAttributes = [
        'cpfcnpj' => 'CPF ou CNPJ',
        'password' => 'senha',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'cpfcnpj' => 'required|min:10',
            'pin' => 'required|min:5',
            'password' => 'confirmed',
        ]);
    }

    public function submit()
    {
        $this->validate();

        $updatePassword = $this->updatePassword($this->cpfcnpj, $this->pin);

        if ($updatePassword) {
            session()->flash('success', 'Senha alterada com sucesso.');
            return redirect()->route('loginView');
        } else {
            session()->flash('error', 'Não foi possível alterar a senha.');
            return redirect()->route('loginView');
        }
    }

    public function render()
    {
        if ((strlen($this->cpfcnpj) == 11) && (is_numeric($this->cpfcnpj))) {
            $this->cpfcnpj = substr($this->cpfcnpj, 0, 3) . '.' . substr($this->cpfcnpj, 3, 3) . '.' . substr($this->cpfcnpj, 6, 3) . '-' . substr($this->cpfcnpj, 9);
        }

        if ((strlen($this->cpfcnpj) == 14) && (is_numeric($this->cpfcnpj))) {
            $this->cpfcnpj = substr($this->cpfcnpj, 0, 2) . '.' . substr($this->cpfcnpj, 2, 3) . '.' . substr($this->cpfcnpj, 5, 3) . '/' . substr($this->cpfcnpj, 8, 4) . '-' . substr($this->cpfcnpj, 12, 2);
        }

        return view('livewire.reset-password-form');
    }

    public function updatePassword($cpf, $pin)
    {
        // Verifica o PIN
        $municipe = DB::table('hscad_cadmunicipal')
            ->join('hscad_municipedoc', 'hscad_municipedoc.idmunicipe', '=', 'hscad_cadmunicipal.inscricaomunicipal')
            ->where('hscad_municipedoc.numero', '=', $cpf)
            ->where('hscad_cadmunicipal.pin', '=', $pin)
            ->get()
            ->first();

        if ($municipe == null) {
            session()->flash('error', 'Dados incorretos.');
        } else {
            // Atualiza a senha
            DB::beginTransaction();
            try {
                DB::table('hscad_cadmunicipal')
                    ->where('inscricaomunicipal', $municipe->inscricaomunicipal)
                    ->update([
                        'senhaweb' => sha1($this->password),
                    ]);
                DB::commit();
                return true;
            } catch (\Illuminate\Database\QueryException $error) {
                DB::rollback();
                dd($error->getMessage());
            }
        }

        return false;
    }
}
