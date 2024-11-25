<?php

namespace App\Http\Controllers\Autenticacao;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use DB;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    public function loginTeste()
    {
        return view('teste');
    }
    public function chamaViewLogin(Request $request)
    {
        $this->setClientSessions();
        return view('autenticacao.login');
    }

    public function loginView()
    {
        return view('auth.login');
    }

    public function setClientSessions()
    {
        $client = DB::table('hscad_dadosempresa')
            ->join('hscad_logradouros', 'hscad_logradouros.id', '=', 'hscad_dadosempresa.idlogradouro')
            ->where('hscad_dadosempresa.id', '=', 1)
            ->select(
                'hscad_dadosempresa.nome_empresa',
                'hscad_dadosempresa.numero',
                'hscad_dadosempresa.cnpj',
                'hscad_logradouros.nome AS logradouro'
            )
            ->get()
            ->first();

        // Sessões para acesso de sistemas externos
        $_SESSION['clientName'] = $client->nome_empresa;
        $_SESSION['clientNumber'] = $client->numero;
        $_SESSION['clientCnpj'] = $client->cnpj;
        $_SESSION['clientStreet'] = $client->logradouro;

        // Sessões para uso interno do Portal
        Session::put('clientName', $client->nome_empresa);
        Session::put('clientNumber', $client->numero);
        Session::put('clientCnpj', $client->cnpj);
        Session::put('clientStreet', $client->logradouro);
    }

    // Verifica o login na glb_usuarios (usuário tem que estar ativo)
    public function login(LoginRequest $request)
    {
        $usuario = $request->usuario;
        $senha = strtoupper($request->senha);
        $senhasha1 = sha1($senha);

        // Faz a autenticação
        $autenticacao = $this->autenticacao($usuario, $senhasha1);

        if ($autenticacao) {
            // Salva log do acesso
            $request = new Request();
            $this->saveLogAccess($request);
        }

        if ($autenticacao == false) {
            return redirect()
                ->back()
                ->with('error', 'Nome de usuário ou senha incorretos!');
        }
        // Verifica se o usuário está ativo
        if ($autenticacao == true) {
            $ativo = $this->verificaUsuarioAtivo($usuario);
            if ($ativo == true) {
                $this->setSessionLogin();
                $this->setClientSessions();
                $this->setSessionsService($usuario, $senha);
                $this->setSessionFol2();
                $this->setSessionCurrentYear();
            }
            if ($ativo == false) {
                return redirect()
                    ->back()
                    ->with('error', 'O usuário não está ativo, entre em contato com o administrador.');
            }
        }
        return redirect()->route('portal');
    }

    public function saveLogAccess($request)
    {
        DB::beginTransaction();
        try {
            $insert = DB::table('adm_acesso')
                ->insertGetId(
                    [
                        'ip' => request()->ip(),
                        'idusuario' => $_SESSION['idusuario'],
                        'dataHora' => date('Y-m-d H:i:s'),
                        'useragent' => $_SERVER['HTTP_USER_AGENT'],
                    ]
                );
            DB::commit();
        } catch (\Illuminate\Database\QueryException $error) {
            DB::rollback();
            dd($error->getMessage());
        }
    }

    public function setSessionsService($username, $password)
    {
        $_SESSION['username'] = $username;
        $_SESSION['password'] = sha1($password);
        $_SESSION['customer'] = sha1(DB::table('hscad_dadosempresa')->where('id', 1)->get()->first()->identificador);
    }

    public function setSessionLogin()
    {
        $_SESSION['login'] = 'logado';
        $_SESSION['cliente'] = DB::table('hscad_dadosempresa')->where('id', 1)->get()->first()->nome_empresa;
    }

    public function setSessionCurrentYear()
    {
        $database = DB::connection()->getDatabaseName();

        $data = DB::select('SELECT 1 FROM INFORMATION_SCHEMA.TABLES tbl WHERE tbl.`TABLE_NAME`
            LIKE "%ctb_configuracao%" AND `TABLE_SCHEMA` = ? LIMIT 1', [$database]);

        if ($data != null) {
            $_SESSION['currentYear'] = DB::table('ctb_configuracao')
                ->whereRaw('CAST(codigo AS UNSIGNED) = ?', [1])
                ->max('exercicio');
        } else {
            $_SESSION['currentYear'] = DB::table('hsctb_configuracoes')
                ->whereRaw('CAST(codigo AS UNSIGNED) = ?', [1])
                ->max('exercicio');
        }
    }

    public function chamaViewPortal()
    {
        $usuario = DB::table('hsglb_usuarios')
            ->where('IDUSUARIO', '=', $_SESSION['idusuario'])
            ->get()->first();

        return view('servidor.portal', compact('usuario'));
    }

    public function autenticacao($usuario, $senha)
    {
        $autenticacao = DB::table('hsglb_usuarios')
            ->where('LOGIN', '=', $usuario)
            ->where('SENHAWEB', '=', $senha)->get()->first();
        if ($autenticacao != null) {
            $this->setSessionNomeUsuario($autenticacao->NOMEUSUARIO);
            $this->setSessionIdUsuario($autenticacao->IDUSUARIO);
            return true;
        } else {
            return false;
        }
    }

    public function setSessionNomeUsuario($nomeUsuario)
    {
        session_start();
        $_SESSION['nomeusuario'] = $nomeUsuario;
    }

    public function setSessionFol2()
    {
        $database = DB::connection()->getDatabaseName();

        $data = DB::select('SELECT 1 FROM INFORMATION_SCHEMA.TABLES tbl WHERE tbl.`TABLE_NAME`
            LIKE "%hsfol2%" AND `TABLE_SCHEMA` = ? LIMIT 1', [$database]);

        // Retorna o boolean da expressão $data == 1
        $_SESSION['fol2'] = ($data != null);
    }

    public function setSessionIdUsuario($idUsuario)
    {
        $_SESSION['idusuario'] = $idUsuario;
    }

    public function verificaUsuarioAtivo($usuario)
    {
        $ativo = DB::table('hsglb_usuarios')
            ->select('ATIVO')
            ->where('LOGIN', '=', $usuario)->get()->first()->ATIVO;
        if ($ativo == 'S') {
            return true;
        }
        return false;
    }

    public function logout()
    {
        session_start();
        session_destroy();
        return redirect()
            ->route('login')
            ->with('success', 'Log out realizado com sucesso!');
    }
}
