<?php

namespace App\Http\Controllers\Protocolo;

use App\Http\Controllers\Controller;
use App\Http\Requests\CriaAlteraProtocolo;
use App\Mail\NovoProtocolo;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProtocoloController extends Controller
{
    public function chamaViewEmissao()
    {
        // Busca os tipos de documento
        $tiposDocumento = DB::table('cad_tipodocumento')->get();

        // Busca os assuntos
        $assuntos = DB::table('cad_assunto')->get();

        // Retorna a view com os tipos de documento
        return view('protocolo.emissao', compact('tiposDocumento', 'assuntos'));
    }

    public function salvar(CriaAlteraProtocolo $request)
    {
        // Data de emissão do protocolo
        $dataEmissao = date('Y-m-d H:i:s');

        // Pega o Id do protocolante (usuário)
        $cpfUsuario = Auth::user()->cpf;
        $idProtocolante = DB::table('cad_pessoa')->where('documento', '=', $cpfUsuario)->first()->id;

        // Gera um número de protocolo (pro usuário)
        $numeroProtocolo = $this->gerarNumeroProtocolo();

        // Gera um número de protocolo interno (administrativo)
        $codigoAdministrativo = $this->gerarCodigoAdministrativo();

        // Recupera os dados da requisição
        $tipoDocumento = $request->tipodocumento;
        $prioridade = strtoupper($request->prioridade);
        $origem = strtoupper($request->origem);
        $assunto = strtoupper($request->assunto);
        $informacoesAdicionais = strtoupper($request->informacoesadicionais);
        $descricao = strtoupper($request->descricao);

        // Salva o Protocolo no banco
        $insertProtocolo = DB::table('cad_protocolo')->insert(
            [
                'idprotocolante' => $idProtocolante,
                'idtipodocumento' => $tipoDocumento,
                'idassunto' => $assunto,
                'numero' => $numeroProtocolo,
                'codigo' => $codigoAdministrativo,
                'dataemissao' => $dataEmissao,
                'prioridade' => $prioridade,
                'origem' => $origem,
                'informacoesadicionais' => $informacoesAdicionais,
                'descricao' => $descricao,
                'status' => 'EMITIDO',
            ]
        );

        // Notifica o usuário por email
        $email = Auth::user()->email;
        Mail::to($email)->send(new NovoProtocolo($numeroProtocolo));

        // Faz o upload dos anexos
        if (isset($request->allFiles()['anexos'])) {
            $anexos = $request->allFiles()['anexos'];
            $uploadAnexos = $this->uploadAnexos($anexos, $codigoAdministrativo, $numeroProtocolo);
        }

        // Erro no upload
        if (isset($uploadAnexos) && ($uploadAnexos == false)) {
            return redirect()
                ->back()
                ->with('error', 'Falha no upload dos anexos!')
                ->withInput();
        }

        // Erro no envio do protocolo
        if ($insertProtocolo == false) {
            return redirect()
                ->back()
                ->with('error', 'Falha no envio do Protocolo!')
                ->withInput();
        }

        return redirect()->route('cidadao.painel')->with('success', 'Protocolo nº ' . $numeroProtocolo . ' enviado com sucesso!');
    }

    public function uploadAnexos($anexos, $codigoAdministrativo, $numeroProtocolo)
    {

        if (isset($anexos)) {
            for ($i = 0; $i < count($anexos); $i++) {
                // Define o valor default para a variável que contém o nome da imagem
                $nomeArquivo = null;

                // Verifica se informou o arquivo e se é válido
                if ($anexos[$i] && $anexos[$i]->isValid()) {

                    // Define o nome do arquivo com base no número do protocolo
                    $numeroAnexo = $i + 1;
                    $nome = $numeroProtocolo . "_anexo_" . $numeroAnexo;

                    // Recupera a extensão do arquivo
                    $extensao = $anexos[$i]->extension();

                    // Define o nome
                    $nomeArquivo = "{$nome}.{$extensao}";
                    $nomeOriginal = $anexos[$i]->getClientOriginalName();

                    // Faz o upload:
                    $upload = $anexos[$i]->storeAs($codigoAdministrativo, $nomeArquivo);
                    // Se tiver funcionado o arquivo foi armazenado em storage/app/public/{{$codigoAdministrativo}}/nomedinamicoarquivo.extensao

                    // Salva os anexos no banco
                    $this->salvarAnexos($nomeArquivo, $nomeOriginal, $numeroProtocolo);

                    // Verifica se NÃO deu certo o upload retorna false
                    if (!$upload) {
                        return false;
                    }
                }
            }
        }

    }

    public function salvarAnexos($nomeArquivo, $nomeOriginal, $numeroProtocolo)
    {
        $idProtocolo = DB::table('cad_protocolo')->where('numero', '=', $numeroProtocolo)->first()->id;

        $insert = DB::table('cad_anexo')->insert(
            [
                'idprotocolo' => $idProtocolo,
                'nomearquivo' => $nomeArquivo,
                'nomeoriginal' => $nomeOriginal,
            ]
        );
    }

    public function gerarNumeroProtocolo()
    {
        $numero = time();

        return $numero;
    }

    public function gerarCodigoAdministrativo()
    {
        $exercicio = date('Y');
        $numeroLinhas = DB::table('cad_protocolo')->count();
        $numeroLinhas++;
        $codigo = $exercicio . $numeroLinhas;

        return $codigo;
    }

    public function chamaViewPainel()
    {
        // Pega o cpf e busca os protocolos relacionados
        $cpf = Auth::user()->cpf;

        $protocolos = DB::table('cad_protocolo')
            ->join('cad_pessoa', 'cad_protocolo.idprotocolante', '=', 'cad_pessoa.id')
            ->join('cad_assunto', 'cad_protocolo.idassunto', '=', 'cad_assunto.id')
            ->join('cad_tipodocumento', 'cad_protocolo.idtipodocumento', '=', 'cad_tipodocumento.id')
            ->select(
                'cad_protocolo.id AS idprotocolo',
                'cad_protocolo.idprotocolante',
                'cad_protocolo.idassunto',
                'cad_protocolo.numero AS numeroprotocolo',
                'cad_protocolo.codigo',
                'cad_protocolo.dataemissao',
                'cad_protocolo.prioridade',
                'cad_protocolo.origem',
                'cad_protocolo.informacoesadicionais',
                'cad_protocolo.status',
                'cad_protocolo.descricao AS descricaoprotocolo',
                'cad_assunto.descricao AS descricaoassunto',
                'cad_tipodocumento.descricao AS descricaotipodocumento')
            ->where('cad_pessoa.documento', '=', $cpf)->paginate(5);

        return view('cidadao.painel', compact('protocolos'));
    }

    public function chamaViewDetalhes($id)
    {
        // Busca o protocolo
        $protocolo = DB::table('cad_protocolo')
            ->join('cad_assunto', 'cad_protocolo.idassunto', '=', 'cad_assunto.id')
            ->join('cad_tipodocumento', 'cad_protocolo.idtipodocumento', '=', 'cad_tipodocumento.id')
            ->select(
                'cad_protocolo.id AS idprotocolo',
                'cad_protocolo.idprotocolante',
                'cad_protocolo.idassunto',
                'cad_protocolo.numero AS numeroprotocolo',
                'cad_protocolo.codigo',
                'cad_protocolo.dataemissao',
                'cad_protocolo.prioridade',
                'cad_protocolo.origem',
                'cad_protocolo.informacoesadicionais',
                'cad_protocolo.status',
                'cad_protocolo.descricao AS descricaoprotocolo',
                'cad_assunto.descricao AS descricaoassunto',
                'cad_tipodocumento.descricao AS descricaotipodocumento')
            ->where('cad_protocolo.id', '=', $id)->get()->first();

        // Busca os anexos do protocolo
        $anexos = DB::table('cad_anexo')->where('idprotocolo', '=', $id)->get();

        return view('protocolo.detalhes', compact('protocolo', 'anexos'));
    }

    public function buscaPeloId(Request $request)
    {
        $numeroProtocolo = $request->numeroProtocolo;
        $cpf = Auth::user()->cpf;
        $idProtocolante = DB::table('cad_pessoa')
            ->select('id')
            ->where('documento', '=', $cpf)->get()->first()->id;

        $protocolos = DB::table('cad_protocolo')
            ->join('cad_pessoa', 'cad_protocolo.idprotocolante', '=', 'cad_pessoa.id')
            ->join('cad_assunto', 'cad_protocolo.idassunto', '=', 'cad_assunto.id')
            ->join('cad_tipodocumento', 'cad_protocolo.idtipodocumento', '=', 'cad_tipodocumento.id')
            ->select(
                'cad_protocolo.id AS idprotocolo',
                'cad_protocolo.idprotocolante',
                'cad_protocolo.idassunto',
                'cad_protocolo.numero AS numeroprotocolo',
                'cad_protocolo.codigo',
                'cad_protocolo.dataemissao',
                'cad_protocolo.prioridade',
                'cad_protocolo.origem',
                'cad_protocolo.informacoesadicionais',
                'cad_protocolo.status',
                'cad_protocolo.descricao AS descricaoprotocolo',
                'cad_assunto.descricao AS descricaoassunto',
                'cad_tipodocumento.descricao AS descricaotipodocumento')
            ->where('cad_pessoa.documento', '=', $cpf)
            ->where('numero', '=', $numeroProtocolo)
            ->paginate(1);

        // Número de protocolo não foi encontrado
        if ($protocolos->total() == 0) {
            return redirect()->back()
                ->with('error', 'Protocolo não encontrado!')
                ->withInput();
        }

        return view('cidadao.painel', compact('protocolos'));
    }

}
