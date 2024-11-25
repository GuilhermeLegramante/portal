<?php

namespace App\Http\Livewire;

use App\Mail\SendPinMarkdown;
use DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Session;

class SendPinForm extends Component
{
    public $cpfcnpj;
    public $email;

    protected $rules = [
        'cpfcnpj' => 'required|min:10',
        'email' => 'required|email',
    ];

    protected $validationAttributes = [
        'cpfcnpj' => 'CPF ou CNPJ',
        'email' => 'E-mail',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'cpfcnpj' => 'required|min:10',
            'email' => 'required|email',
        ]);
    }

    public function submit()
    {
        $this->validate();
        $sendPin = $this->sendPin();

        if ($sendPin) {
            request()->session()->flash(
                'success',
                'E-mail enviado com sucesso.'
            );
            return redirect()->route('loginView');
        }
    }

    public function sendPin()
    {
        $search = DB::table('hscad_cadmunicipal')
            ->join('hscad_municipedoc', 'hscad_municipedoc.idmunicipe', '=', 'hscad_cadmunicipal.inscricaomunicipal')
            ->where('hscad_municipedoc.numero', '=', $this->cpfcnpj)
            ->where('hscad_cadmunicipal.email', '=', $this->email)
            ->whereIn('hscad_municipedoc.iddocumento', [1, 3])
            ->select('hscad_cadmunicipal.pin')
            ->get()
            ->first();

        if ($search == null) {
            session()->flash('error', 'Dados incorretos. Verifique seu cadastro junto à Administração.');
        } else {
            try{
                Mail::to($this->email)->send(new SendPinMarkdown($this->cpfcnpj, $search->pin));
            } catch (\Exception $error) {
                dd($error->getMessage());
               session()->flash('error', 'Não foi possível enviar o e-mail. Por favor, tente mais tarde.');
               return false;
            }
            return true;
        }

        return false;
    }

    public function render()
    {
        if ((strlen($this->cpfcnpj) == 11) && (is_numeric($this->cpfcnpj))) {
            $this->cpfcnpj = substr($this->cpfcnpj, 0, 3) . '.' . substr($this->cpfcnpj, 3, 3) . '.' . substr($this->cpfcnpj, 6, 3) . '-' . substr($this->cpfcnpj, 9);
        }

        if ((strlen($this->cpfcnpj) >= 14) && (is_numeric($this->cpfcnpj))) {
            $this->cpfcnpj = substr($this->cpfcnpj, 0, 2) . '.' . substr($this->cpfcnpj, 2, 3) . '.' . substr($this->cpfcnpj, 5, 3) . '/' . substr($this->cpfcnpj, 8, 4) . '-' . substr($this->cpfcnpj, 12, 2);
        }

        return view('livewire.send-pin-form');
    }
}
