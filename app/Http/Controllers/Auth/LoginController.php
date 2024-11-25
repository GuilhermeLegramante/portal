<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\ClienteRepository;
use App\Repositories\MunicipeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    private $municipeRepository;
    private $clienteRepository;

    public function __construct(MunicipeRepository $municipeRepo, ClienteRepository $clienteRepo)
    {
        $this->municipeRepository = $municipeRepo;
        $this->clienteRepository = $clienteRepo;
    }

    public function loginView()
    {
        $this->setClientSessions();
        return view('auth.login');
    }

    public function resetPasswordView()
    {
        $this->setClientSessions();
        return view('auth.reset');
    }

    public function login(LoginRequest $request)
    {
        $username = $request->usuario;
        $password = sha1($request->senha);

        $municipe = $this->getMunicipeByAuth($username, $password);

        if ($municipe == null) {
            return redirect()->back()->with('error', 'Dados incorretos.');
        } else {
            $this->setMunicipeSessions($municipe);
            $this->setClientSessions();
            $this->clienteRepository->setSessionFol2();

            // if ($this->setDashboardSessions() == false) {
            //     return redirect()->back()->with('error', 'Você não possui contratos vigentes.');
            // } else {
            //     return redirect()->route('dashboard');
            // }

            $this->setDashboardSessions();

            return redirect()->route('dashboard');
        }
    }

    public function setMunicipeSessions($municipe)
    {
        Session::put('login_contracheque', true);
        Session::put('idmunicipe', $municipe->idmunicipe);
        Session::put('municipeCpf', $municipe->numero);
        Session::put('municipeName', $municipe->nome);
        Session::put('tokenweb', $municipe->tokenweb);

    }

    public function setClientSessions()
    {
        $client = $this->clienteRepository->getData();

        Session::put('clientName', $client->nome_empresa);

        Session::put('clientNumber', $client->numero);

        Session::put('clientCnpj', $client->cnpj);

        Session::put('clientStreet', $client->logradouro);

        Session::put('clientEmail', $client->email);

        Session::put('clientIdentifier', $client->identificador);

    }

    public function setDashboardSessions()
    {
        $data = $this->municipeRepository->getDashboardData(Session::get('idmunicipe'));

        if ($data != null) {
            Session::put('tem_contrato_ativo', true);
            Session::put('inscricao', $data[0]->inscricao);
            Session::put('nome', $data[0]->nome);
            Session::put('documento', $data[0]->documento);
            Session::put('valor_provento', $data[0]->valor_provento);
            Session::put('valor_desconto', $data[0]->valor_desconto);
            Session::put('valor_liquido', $data[0]->valor_provento - $data[0]->valor_desconto);
        }

    }

    // Para o caso de logar, porém o munícipe não possuir contratos como servidor.
    public function logoutNotServer(Request $request)
    {
        session()->flush();
        return redirect()
            ->route('loginView')
            ->with('error', 'Você não possui contratos vigentes.');
    }

    public function getMunicipeByAuth($username, $password)
    {
        return $this->municipeRepository->getByAuth($username, $password);
    }

    public function logout(Request $request)
    {
        session()->flush();
        return redirect()
            ->route('loginView')
            ->with('success', 'Log out realizado com sucesso!');
    }

    public function getPin()
    {
        $this->setClientSessions();
        return view('auth.send-pin');
    }
}
