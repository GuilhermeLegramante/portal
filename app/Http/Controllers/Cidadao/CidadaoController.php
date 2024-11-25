<?php

namespace App\Http\Controllers\Cidadao;

use App\Http\Controllers\Controller;
use App\Http\Requests\CriaAlteraCidadao;
use App\Mail\Saudacoes;
use App\User;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class CidadaoController extends Controller
{

    public function salvar(CriaAlteraCidadao $request, User $user)
    {

        // Dados do usuário
        $nome = $request->name;
        $cpf = $request->cpf;
        $email = $request->email;
        $senha = $request->password;
        // Dados do Cidadão
        $telefone = $request->telefone;
        $cep = $request->cep;
        $logradouro = strtoupper($request->logradouro);
        $complemento = strtoupper($request->complemento);
        $rua = strtoupper($request->rua);
        $numero = strtoupper($request->numero);
        $bairro = strtoupper($request->bairro);
        $cidade = strtoupper($request->cidade);
        $uf = strtoupper($request->uf);
        $ibge = $request->ibge;

        // A descrição vai ser o nome da rua (em caso de cep genérico)
        // ou o logradouro + complemento
        if ($logradouro == null) {
            $descricaoLogradouro = $rua;
        } else {
            $descricaoLogradouro = $logradouro . " - " . $complemento;
        }

        // Cria Usuário
        $insertUser = $this->insereUsuario($nome, $cpf, $email, $senha);

        // Busca os dados do estado e município
        $idEstado = DB::table('cad_estado')->select('id')->where('sigla', '=', $uf)->first();
        $idMunicipio = DB::table('cad_municipio')->select('id')
            ->where('descricao', '=', $cidade)->where('idestado', $idEstado->id)->first();
        // Busca o logradouro (caso exista)
        $idLogradouro = DB::table('cad_logradouro')->select('id')
            ->where('cep', '=', $cep)
            ->where('descricao', '=', $descricaoLogradouro)->first();
        // Se o logradouro não existe, faz o insert
        if ($idLogradouro == null) {
            $insertLogradouro = DB::table('cad_logradouro')->insert(
                [
                    'idmunicipio' => $idMunicipio->id,
                    'cep' => $cep,
                    'descricao' => $descricaoLogradouro,
                ]
            );

        }
        // Pega o id do logradouro
        $idLogradouro = DB::table('cad_logradouro')->select('id')
            ->where('cep', '=', $cep)
            ->where('descricao', '=', $descricaoLogradouro)->first();

        // INSERÇÃO DO BAIRRO
        // Busca o bairro (caso exista)
        $idBairro = DB::table('cad_bairro')->select('id')
            ->where('idmunicipio', '=', $idMunicipio->id)
            ->where('descricao', '=', $bairro)->first();
        // Se o bairro não existe, faz o insert
        if ($idBairro == null) {
            $insertBairro = DB::table('cad_bairro')->insert(
                [
                    'idmunicipio' => $idMunicipio->id,
                    'descricao' => $bairro,
                ]
            );
        }
        // Pega o id do bairro
        $idBairro = DB::table('cad_bairro')->select('id')
            ->where('idmunicipio', '=', $idMunicipio->id)
            ->where('descricao', '=', $bairro)->first();

        // INSERÇÃO DO CIDADÃO (PESSOA)
        $insertCidadao = DB::table('cad_pessoa')->insert(
            [
                'idlogradouro' => $idLogradouro->id,
                'documento' => $cpf,
                'nome' => $nome,
                'idbairro' => $idBairro->id,
                'telefone' => $telefone,
                'email' => $email,
                'numeroimovel' => $numero,
            ]
        );

        if (($insertUser) && ($insertCidadao)) {
            Mail::to($email)->send(new Saudacoes($nome));
            return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Falha ao inserir Cidadão');
    }

    public function insereUsuario($nome, $cpf, $email, $senha)
    {
        $insert = User::create([
            'name' => $nome,
            'cpf' => $cpf,
            'email' => $email,
            'password' => Hash::make($senha),
        ]);

        return $insert;
    }

    public function testeApi()
    {
        $dados = DB::select('select * from cad_estado');

        return $dados;
    }

}
