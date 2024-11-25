<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use PDF;
use Session;

class ContrachequeController extends Controller
{
    public function index()
    {
        return view('auth.painel');
    }

    public function consultaDemonstrativoMensal()
    {
        if (Session::get('login_contracheque')) {
            $token = Session::get('tokenweb');

            $contratos = DB::select(
                "SELECT `contrato`.`idcontrato` AS `id`,
                                            `contrato`.`matricula` AS `matricula`,
                                            `func_fol2_contrato_admissao`(`contrato`.`idcontrato`) AS `dataadmissao`,
                                            (SELECT `funcao`.`descricao`
                                               FROM `hsfol2_contratofuncao` `contratoFuncao`
                                                    INNER JOIN `hsfol2_funcao` `funcao`
                                                       ON `funcao`.`id` = `contratoFuncao`.`idfuncao`
                                              WHERE `contrato`.`idcontratofuncao` = `contratoFuncao`.`id`)
                                               AS `desc_funcao`,
                                            (SELECT `situacao`.`descricao`
                                               FROM `hsfol2_contratoatividade` `contratoAtividade`
                                                    INNER JOIN `hsfol2_situacaocontratual` `situacao`
                                                       ON `situacao`.`id` = `contratoAtividade`.`idsituacaocontratual`
                                              WHERE `contrato`.`idcontratoatividade` = `contratoAtividade`.`id`)
                                               AS `desc_situacao`
                                        FROM `view_fol2_contratorelacaoatual` `contrato`
                                             INNER JOIN `hsfol2_servidor` `servidor`
                                                ON `contrato`.`idservidor` = `servidor`.`id`
                                             INNER JOIN `hscad_cadmunicipal` `municipe`
                                                ON `municipe`.`inscricaomunicipal` = `servidor`.`idmunicipe`
                                       WHERE `municipe`.`tokenweb` = :tk",
                ['tk' => $token]
            );

            $tiposfolha = DB::select('SELECT id, descricao FROM hsfol2_tipofolha');

            $mesNumero = date('n');
            $anoNumero = date('y');

            $meses = array(
                '1' => 'Janeiro',
                '2' => 'Fevereiro',
                '3' => 'Março',
                '4' => 'Abril',
                '5' => 'Maio',
                '6' => 'Junho',
                '7' => 'Julho',
                '8' => 'Agosto',
                '9' => 'Setembro',
                '10' => 'Outubro',
                '11' => 'Novembro',
                '12' => 'Dezembro',
            );
            foreach ($meses as $key => $mes) {
                if ($mesNumero == $key) {
                    $mesAtual = $mes;
                }
            }

            return view('auth.consultaDemonstrativoMensal', compact('contratos', 'tiposfolha', 'mesNumero', 'mesAtual', 'meses', 'anoNumero'));
        }
        return redirect()->route('dashboard');
    }

    public function buscaContrachequeMensal(Request $request)
    {
        if (Session::get('login_contracheque')) {
            $token = Session::get('tokenweb');

            $contrato = $request->contrato;
            $tipofolha = $request->tipofolha;
            $mes = $request->mes;
            $month = utf8_encode(strtoupper(strftime("%B", mktime(20, 0, 0, $mes, 01, 98))));
            $descricaomes = $this->traduzMes($month);
            $ano = $request->ano;

            // CONSULTAS FOL2
            $servidor = DB::select(
                "SELECT `contrato`.`matricula` AS `matricula`,
                                           (SELECT `municipe`.`nome`
                                               FROM `hscad_cadmunicipal` `municipe`
                                               WHERE `servidor`.`idmunicipe` = `municipe`.`inscricaomunicipal`)
                                               AS `nome`,
                                           (SELECT `funcao`.`descricao`
                                               FROM `hsfol2_funcao` `funcao`
                                               WHERE `contratoFuncao`.`idfuncao` = `funcao`.`id`)
                                               AS `desc_funcao`,
                                           (SELECT `lotacao`.`descricao`
                                               FROM `hsfol2_lotacao` `lotacao`
                                               WHERE `contratoLotacao`.`idlotacao` = `lotacao`.`id`)
                                               AS `desc_lotacao`,
                                           `padrao`.`padrao` AS `padrao`,
                                           `padrao`.`nivel` AS `nivel`,
                                           `padrao`.`classe` AS `classe`
                                       FROM `view_fol2_contratorelacaoatual` `contrato`
                                           INNER JOIN `hsfol2_servidor` `servidor`
                                               ON `contrato`.`idservidor` = `servidor`.`id`
                                           INNER JOIN `hsfol2_contratofuncao` `contratoFuncao`
                                               ON `contrato`.`idcontratofuncao` = `contratoFuncao`.`id`
                                           INNER JOIN `hsfol2_contratolotacao` `contratoLotacao`
                                               ON `contrato`.`idcontratolotacao` = `contratoLotacao`.`id`
                                           INNER JOIN `hsfol2_contratopadrao` `contratoPadrao`
                                               ON `contrato`.`idcontratopadrao` = `contratoPadrao`.`id`
                                           INNER JOIN `hsfol2_padraonivelclasse` `padrao`
                                               ON `padrao`.`id` = `contratoPadrao`.`idpadraonivelclasse`
                                       WHERE `contrato`.`idcontrato` = :id",
                ['id' => $contrato]
            );

            $valores = DB::select(
                "SELECT (SELECT `configuracao`.`contracheque`
                                             FROM `hsfol2_configuracao` `configuracao`
                                            WHERE `configuracao`.`idfonte` = 1)
                                             AS `visivel`,
                                          `referencia`.`contracheque` AS `contraCheque`,
                                          `referencia`.`datafolha` AS `dataFolha`,
                                          `evento`.`codigo` AS `codigo`,
                                          `evento`.`descricao` AS `desc_evento`,
                                          `evento`.`classificacao` AS `classificacao`,
                                          (SELECT `tipoFolha`.`descricao`
                                             FROM `hsfol2_tipofolha` `tipoFolha`
                                            WHERE `referencia`.`idtipofolha` = `tipoFolha`.`id`)
                                             AS `desc_tipofolha`,
                                          `calculoEvento`.`referencia` AS `referencia`,
                                          `calculoEvento`.`valor` AS `valor`
                                     FROM `hsfol2_calculoevento` `calculoEvento`
                                          INNER JOIN `hsfol2_calculo` `calculo`
                                             ON `calculo`.`id` = `calculoEvento`.`idcalculo`
                                          INNER JOIN `hsfol2_referencia` `referencia`
                                             ON `referencia`.`id` = `calculo`.`idreferencia`
                                          INNER JOIN `hsfol2_evento` `evento`
                                             ON `evento`.`id` = `calculoEvento`.`idevento`
                                    WHERE MONTH(`referencia`.`datafolha`) = :mes
                                      AND YEAR(`referencia`.`datafolha`) = :exc
                                      AND `referencia`.`encerrada` = 1
                                      AND `calculo`.`idcontrato` = :id
                                      AND `referencia`.`idtipofolha` = :tp
                                      AND `evento`.`classificacao` IN ('P', 'D', 'B')
                                   HAVING (`visivel` = 'E' AND `contracheque` = 1) OR
                                          (`visivel` = 'M' AND (`dataFolha` < CURDATE() OR `contracheque` = 1))
                                    ORDER BY `codigo`",
                ['mes' => $mes, 'exc' => $ano, 'id' => $contrato, 'tp' => $tipofolha]
            );

            $mensagem = "Não existem lançamentos no período informado.";
            $vencimentos = $this->buscaVencimentos($valores);

            $descontos = $this->buscaDescontos($valores);
            $bases = $this->buscaBases($valores);

            $totalVencimentos = $this->calculaTotalValores($vencimentos);
            $totalDescontos = $this->calculaTotalValores($descontos);
            $totalLiquido = $totalVencimentos - $totalDescontos;

            return view('auth.contrachequeMensal', compact(
                'mensagem',
                'contrato',
                'tipofolha',
                'mes',
                'descricaomes',
                'ano',
                'servidor',
                'valores',
                'vencimentos',
                'descontos',
                'bases',
                'totalVencimentos',
                'totalDescontos',
                'totalLiquido'
            ));
        }
        return redirect()->route('dashboard');
    }

    public function geraPdfMensal(Request $request)
    {
        if (Session::get('login_contracheque')) {
            $token = Session::get('tokenweb');

            $dadosOrgao = $this->buscaDadosOrgao();
            $contrato = $request->contrato;
            $tipofolha = $request->tipofolha;
            $mes = $request->mes;
            $month = utf8_encode(strtoupper(strftime("%B", mktime(20, 0, 0, $mes, 01, 98))));
            $descricaomes = $this->traduzMes($month);
            $ano = $request->ano;

            $servidor = DB::select(
                "SELECT (SELECT `municipe`.`nome`
                                              FROM `hscad_cadmunicipal` `municipe`
                                             WHERE `servidor`.`idmunicipe` = `municipe`.`inscricaomunicipal`)
                                              AS `nome`,
                                           `contrato`.`matricula` AS `matricula`,
                                           (SELECT `funcao`.`descricao`
                                              FROM `hsfol2_funcao` `funcao`
                                             WHERE `contratoFuncao`.`idfuncao` = `funcao`.`id`)
                                              AS `desc_funcao`,
                                           (SELECT `lotacao`.`descricao`
                                              FROM `hsfol2_lotacao` `lotacao`
                                             WHERE `contratoLotacao`.`idlotacao` = `lotacao`.`id`)
                                              AS `desc_lotacao`,
                                           `padrao`.`padrao` AS `padrao`,
                                           `padrao`.`nivel` AS `nivel`,
                                           `padrao`.`classe` AS `classe`,
                                           `contrato`.`idcontratosegregacao` AS `idcontratosegregacao`
                                      FROM `view_fol2_contratorelacaoatual` `contrato`
                                           INNER JOIN `hsfol2_servidor` `servidor`
                                              ON `contrato`.`idservidor` = `servidor`.`id`
                                           INNER JOIN `hsfol2_contratofuncao` `contratoFuncao`
                                              ON `contrato`.`idcontratofuncao` = `contratoFuncao`.`id`
                                           INNER JOIN `hsfol2_contratolotacao` `contratoLotacao`
                                              ON `contrato`.`idcontratolotacao` = `contratoLotacao`.`id`
                                           INNER JOIN `hsfol2_contratopadrao` `contratoPadrao`
                                              ON `contrato`.`idcontratopadrao` = `contratoPadrao`.`id`
                                           INNER JOIN `hsfol2_padraonivelclasse` `padrao`
                                              ON `padrao`.`id` = `contratoPadrao`.`idpadraonivelclasse`
                                     WHERE `contrato`.`idcontrato` = :id",
                ['id' => $contrato]
            );

            if ($servidor[0]->idcontratosegregacao == null) {
                $segregacao = '';
            } else {
                $segregacao = DB::select("SELECT `segregacao`.`descricao`
                                            FROM `hsfol2_contratosegregacao` `contratosegregacao`
                                                 INNER JOIN `hsfol2_segregacaomassa` `segregacao`
                                                    ON `segregacao`.`id` = `contratosegregacao`.`idsegregacao`
                                           WHERE `contratosegregacao`.`id` = ?", [$servidor[0]->idcontratosegregacao])[0]->descricao;
            }

            $valores = DB::select(
                "SELECT (SELECT `configuracao`.`contracheque`
                                             FROM `hsfol2_configuracao` `configuracao`
                                            WHERE `configuracao`.`idfonte` = 1)
                                             AS `visivel`,
                                          `referencia`.`contracheque` AS `contraCheque`,
                                          `referencia`.`datafolha` AS `dataFolha`,
                                          `evento`.`codigo` AS `codigo`,
                                          `evento`.`descricao` AS `desc_evento`,
                                          `evento`.`classificacao` AS `classificacao`,
                                          (SELECT `tipoFolha`.`descricao`
                                             FROM `hsfol2_tipofolha` `tipoFolha`
                                            WHERE `referencia`.`idtipofolha` = `tipoFolha`.`id`)
                                             AS `desc_tipofolha`,
                                          `calculoEvento`.`referencia` AS `referencia`,
                                          `calculoEvento`.`valor` AS `valor`
                                     FROM `hsfol2_calculoevento` `calculoEvento`
                                          INNER JOIN `hsfol2_calculo` `calculo`
                                             ON `calculo`.`id` = `calculoEvento`.`idcalculo`
                                          INNER JOIN `hsfol2_referencia` `referencia`
                                             ON `referencia`.`id` = `calculo`.`idreferencia`
                                          INNER JOIN `hsfol2_evento` `evento`
                                             ON `evento`.`id` = `calculoEvento`.`idevento`
                                    WHERE MONTH(`referencia`.`datafolha`) = :mes
                                      AND YEAR(`referencia`.`datafolha`) = :exc
                                      AND `referencia`.`encerrada` = 1
                                      AND `calculo`.`idcontrato` = :id
                                      AND `referencia`.`idtipofolha` = :tp
                                      AND `evento`.`classificacao` IN ('P', 'D', 'B')
                                   HAVING (`visivel` = 'E' AND `contracheque` = 1)
                                       OR (`visivel` = 'M' AND (`dataFolha` < CURDATE() OR `contracheque` = 1))
                                    ORDER BY `codigo`",
                ['id' => $contrato, 'tp' => $tipofolha, 'mes' => $mes, 'exc' => $ano]
            );

            $vencimentos = $this->buscaVencimentos($valores);
            $descontos = $this->buscaDescontos($valores);
            $bases = $this->buscaBases($valores);

            $totalVencimentos = $this->calculaTotalValores($vencimentos);
            $totalDescontos = $this->calculaTotalValores($descontos);
            $totalLiquido = $totalVencimentos - $totalDescontos;

            $pdf = PDF::loadView('auth.pdfDemonstrativoMensal', compact(
                'contrato',
                'tipofolha',
                'mes',
                'descricaomes',
                'ano',
                'servidor',
                'valores',
                'vencimentos',
                'descontos',
                'bases',
                'totalVencimentos',
                'totalDescontos',
                'totalLiquido',
                'dadosOrgao',
                'segregacao'
            ));

            return $pdf->setPaper('a4')->stream('contracheque.pdf');
        }
        return redirect()->route('dashboard');
    }

    public function geraPdfPeriodo(Request $request)
    {
        if (Session::get('login_contracheque')) {
            $token = Session::get('tokenweb');
            $dadosorgao = $this->buscaDadosOrgao();
            $contrato = $request->contrato;
            $tipofolha = $request->tipofolha;
            $datainicial = $request->datainicial;
            $datafinal = $request->datafinal;

            // Dados do Servidor
            $servidor = $this->buscaServidor($token, $contrato);
            $segregacao = $this->buscaSegregacao($token, $contrato);
            $nome = $servidor[0]->nome;
            $matricula = $servidor[0]->matricula;
            $funcao = $servidor[0]->desc_funcao;
            $lotacao = $servidor[0]->desc_lotacao;
            $padrao = $servidor[0]->padrao;
            $nivel = $servidor[0]->nivel;
            $classe = $servidor[0]->classe;

            $queryBase = "SELECT (SELECT `configuracao`.`contracheque`
                                    FROM `hsfol2_configuracao` `configuracao`
                                   WHERE `configuracao`.`idfonte` = 1)
                                    AS `visivel`,
                                 `referencia`.`contracheque` AS `contraCheque`,
                                 `referencia`.`datafolha` AS `dataFolha`,
                                 `calculoEvento`.`valor` AS `valor_calculado`,
                                 `calculoEvento`.`referencia` AS `valor_referencia`,
                                 MONTH(`referencia`.`datafolha`) AS `mes`,
                                 YEAR(`referencia`.`datafolha`) AS `ano`,
                                 `evento`.`codigo` AS `cod_evento`,
                                 `evento`.`descricao` AS `desc_evento`,
                                 `evento`.`classificacao` AS `classificacao`,
                                 (SELECT `tipoFolha`.`descricao`
                                    FROM `hsfol2_tipofolha` `tipoFolha`
                                   WHERE `referencia`.`idtipofolha` = `tipoFolha`.`id`)
                                    AS `desc_tipofolha`
                            FROM `hsfol2_calculoevento` `calculoEvento`
                                 INNER JOIN `hsfol2_calculo` `calculo`
                                    ON `calculo`.`id` = `calculoEvento`.`idcalculo`
                                 INNER JOIN `hsfol2_referencia` `referencia`
                                    ON `referencia`.`id` = `calculo`.`idreferencia`
                                 INNER JOIN `hsfol2_evento` `evento`
                                    ON `evento`.`id` = `calculoEvento`.`idevento`
                           WHERE `referencia`.`datafolha` BETWEEN :dti AND :dtf
                             AND `calculo`.`idcontrato` = :id
                             AND `referencia`.`idtipofolha` :x :tf
                             AND `referencia`.`encerrada` = 1
                             AND `evento`.`classificacao` IN ('P', 'D', 'B')
                         HAVING (`visivel` = 'E' AND `contracheque` = 1)
                             OR (`visivel` = 'M' AND (`dataFolha` < CURDATE() OR `contracheque` = 1))
                          ORDER BY MONTH(`referencia`.`datafolha`),
                                   YEAR(`referencia`.`datafolha`),
                                   CAST(`evento`.`codigo` AS UNSIGNED)";

            // Recupera os dados dos valores no período (1 select pra cada tipo de folha)
            if ($tipofolha == 'TODOS') {
                $queryBase = str_replace(':x', '=', $queryBase);

                $valoresTipoFolha1 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 1]);
                $valoresTipoFolha2 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 2]);
                $valoresTipoFolha3 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 3]);
                $valoresTipoFolha4 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 4]);
                $valoresTipoFolha5 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 5]);
                $valoresTipoFolha6 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 6]);
                $valoresTipoFolha7 = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => 7]);

                if ($valoresTipoFolha1 != null) {
                    $totalMensal1 = $this->buscaTotaisMensalAno($valoresTipoFolha1);
                } else {
                    $totalMensal1 = null;
                }
                if ($valoresTipoFolha2 != null) {
                    $totalMensal2 = $this->buscaTotaisMensalAno($valoresTipoFolha2);
                } else {
                    $totalMensal2 = null;
                }
                if ($valoresTipoFolha3 != null) {
                    $totalMensal3 = $this->buscaTotaisMensalAno($valoresTipoFolha3);
                } else {
                    $totalMensal3 = null;
                }
                if ($valoresTipoFolha4 != null) {
                    $totalMensal4 = $this->buscaTotaisMensalAno($valoresTipoFolha4);
                } else {
                    $totalMensal4 = null;
                }
                if ($valoresTipoFolha5 != null) {
                    $totalMensal5 = $this->buscaTotaisMensalAno($valoresTipoFolha5);
                } else {
                    $totalMensal5 = null;
                }
                if ($valoresTipoFolha6 != null) {
                    $totalMensal6 = $this->buscaTotaisMensalAno($valoresTipoFolha6);
                } else {
                    $totalMensal6 = null;
                }
                if ($valoresTipoFolha7 != null) {
                    $totalMensal7 = $this->buscaTotaisMensalAno($valoresTipoFolha7);
                } else {
                    $totalMensal7 = null;
                }

                if (($valoresTipoFolha1 == null) && ($valoresTipoFolha2 == null) &&
                    ($valoresTipoFolha3 == null) && ($valoresTipoFolha4 == null) &&
                    ($valoresTipoFolha5 == null) && ($valoresTipoFolha6 == null) && ($valoresTipoFolha7 == null)
                ) {
                    return redirect()->back()->with('error', 'Não existem lançamentos no período informado.');
                } else {
                    $pdf = PDF::loadView('auth.pdfDemonstrativoPeriodo', compact(
                        'totalMensal1',
                        'totalMensal2',
                        'totalMensal3',
                        'totalMensal4',
                        'totalMensal5',
                        'totalMensal6',
                        'totalMensal7',
                        'servidor',
                        'dadosorgao',
                        'contrato',
                        'tipofolha',
                        'datainicial',
                        'datafinal',
                        'nome',
                        'matricula',
                        'funcao',
                        'lotacao',
                        'padrao',
                        'nivel',
                        'classe',
                        'valoresTipoFolha1',
                        'valoresTipoFolha2',
                        'valoresTipoFolha3',
                        'valoresTipoFolha4',
                        'valoresTipoFolha5',
                        'valoresTipoFolha6',
                        'valoresTipoFolha7',
                        'segregacao'
                    ));

                    return $pdf->setPaper('a4')->stream('contrachequePeriodo.pdf');
                }
            } else {
                $queryBase = str_replace(':x', '<>', $queryBase);

                // Recupera os dados dos valores no período
                $valores = DB::select($queryBase, ['id' => $contrato, 'dti' => $datainicial, 'dtf' => $datafinal, 'tf' => -1]);
            }

            if ($valores != null) {
                $totalMensal = $this->buscaTotaisMensalAno($valores);
            }
            if ($valores == null) {
                return redirect()->back()->with('error', 'Não existem lançamentos no período informado.');
            } else {
                $pdf = PDF::loadView('auth.pdfDemonstrativoPeriodo', compact(
                    'totalMensal',
                    'servidor',
                    'dadosorgao',
                    'contrato',
                    'tipofolha',
                    'datainicial',
                    'datafinal',
                    'nome',
                    'matricula',
                    'funcao',
                    'lotacao',
                    'padrao',
                    'nivel',
                    'classe',
                    'valores'
                ));

                return $pdf->setPaper('a4')->stream('contrachequePeriodo.pdf');
            }
        }
        return redirect()->route('dashboard');
    }

    public function buscaTotaisMensal($valores)
    {
        $totais[] = [
            "mes" => $valores[0]->mes,
            "ano" => $valores[0]->ano,
            "desc_tipofolha" => $valores[0]->desc_tipofolha,
        ];

        for ($i = 0; $i < sizeof($valores); $i++) {
            if ($i > 0) {
                if ($valores[$i]->mes != $valores[$i - 1]->mes) {
                    $totais[] = [
                        "mes" => $valores[$i]->mes,
                        "ano" => $valores[$i]->ano,
                        "desc_tipofolha" => $valores[$i]->desc_tipofolha,
                    ];
                }
            }
        }
        return $totais;
    }

    public function buscaTotaisMensalAno($valores)
    {
        $totais[] = [
            "mes" => $valores[0]->mes,
            "ano" => $valores[0]->ano,
            "desc_tipofolha" => $valores[0]->desc_tipofolha,
        ];

        for ($i = 0; $i < sizeof($valores); $i++) {
            if ($i > 0) {
                if ($valores[$i]->mes != $valores[$i - 1]->mes) {
                    $totais[] = [
                        "mes" => $valores[$i]->mes,
                        "ano" => $valores[$i]->ano,
                        "desc_tipofolha" => $valores[$i]->desc_tipofolha,
                    ];
                }
                if ($valores[$i]->ano != $valores[$i - 1]->ano) {
                    $totais[] = [
                        "mes" => $valores[$i]->mes,
                        "ano" => $valores[$i]->ano,
                        "desc_tipofolha" => $valores[$i]->desc_tipofolha,
                    ];
                }
            }
        }

        return $totais;
    }

    public function buscaSegregacao($token, $contrato)
    {
        $serv = DB::select("SELECT `contrato`.`idcontratosegregacao` AS `idcontratosegregacao`
                              FROM `view_fol2_contratorelacaoatual` `contrato`
                             WHERE `contrato`.`idcontrato` = :id", ['id' => $contrato]);

        if ($serv[0]->idcontratosegregacao == null) {
            $segregacao = '';
        } else {
            $segregacao = DB::select(
                "SELECT `segregacao`.`descricao`
                                        FROM `hsfol2_contratosegregacao` `contratosegregacao`
                                             INNER JOIN `hsfol2_segregacaomassa` `segregacao`
                                                ON `segregacao`.`id` = `contratosegregacao`.`idsegregacao`
                                       WHERE `contratosegregacao`.`id` = :id",
                ['id' => $serv[0]->idcontratosegregacao]
            )[0]->descricao;
        }

        return $segregacao;
    }

    public function buscaServidor($token, $contrato)
    {
        if (Session::get('fol2') == true) {
            $servidor = DB::select('SELECT hsfol2_contrato.`id` AS `idcontrato`,
                                hsfol2_contrato.matricula,
                                hscad_cadmunicipal.`nome` AS `nome`,
                                (SELECT hsfol2_funcao.`descricao`
                                FROM `hsfol2_funcao`
                                WHERE hsfol2_contratofuncao.`idfuncao` = hsfol2_funcao.`id`)
                                AS `desc_funcao`,
                                (SELECT hsfol2_lotacao.`descricao`
                                FROM `hsfol2_lotacao`
                                WHERE hsfol2_contratolotacao.`idlotacao` = hsfol2_lotacao.`id`)
                                AS `desc_lotacao`,
                                hsfol2_padraonivelclasse.`padrao` AS `padrao`,
                                hsfol2_padraonivelclasse.`nivel` AS `nivel`,
                                hsfol2_padraonivelclasse.`classe` AS `classe`
                        FROM `hsfol2_contrato`
                                INNER JOIN
                                (SELECT hsfol2_contratolotacao.`idcontrato` AS `idcontrato`,
                                        MAX(hsfol2_contratolotacao.`id`) AS `idcontratolotacao`
                                FROM `hsfol2_contratolotacao`
                                GROUP BY hsfol2_contratolotacao.`idcontrato`) `contratolotacaoatual`
                                ON hsfol2_contrato.`id` = `contratolotacaoatual`.`idcontrato`
                                INNER JOIN
                                (SELECT hsfol2_contratofuncao.
                        `idcontrato` AS `idcontrato`,
                                        MAX(hsfol2_contratofuncao.`id`) AS `idcontratofuncao`
                                FROM `hsfol2_contratofuncao`
                                GROUP BY hsfol2_contratofuncao.`idcontrato`) `contratofuncaoatual`
                                ON hsfol2_contrato.`id` = `contratofuncaoatual`.`idcontrato`
                                INNER JOIN
                                (SELECT hsfol2_contratopadrao.`idcontrato` AS `idcontrato`,
                                        MAX(hsfol2_contratopadrao.`id`) AS `idcontratopadrao`
                                FROM `hsfol2_contratopadrao`
                                GROUP BY hsfol2_contratopadrao.`idcontrato`) `contratopadraoatual`
                                ON hsfol2_contrato.`id` = `contratopadraoatual`.`idcontrato`
                                INNER JOIN hsfol2_servidor
                                ON hsfol2_servidor.`id` = hsfol2_contrato.`idservidor`
                                INNER JOIN hscad_cadmunicipal
                                ON hscad_cadmunicipal.`inscricaomunicipal` = hsfol2_servidor.`idmunicipe`
                                INNER JOIN `hsfol2_contratolotacao`
                                ON hsfol2_contratolotacao.`id` = `contratolotacaoatual`.`idcontratolotacao`
                                INNER JOIN `hsfol2_contratofuncao`
                    ON hsfol2_contratofuncao.`id` = `contratofuncaoatual`.`idcontratofuncao`
                                INNER JOIN `hsfol2_contratopadrao`
                                ON hsfol2_contratopadrao.`id` = contratopadraoatual.`idcontratopadrao`
                                INNER JOIN hsfol2_padraonivelclasse
                                ON hsfol2_padraonivelclasse.`id` = hsfol2_contratopadrao.`idpadraonivelclasse`
                        WHERE hscad_cadmunicipal.`tokenweb` = ?
                            AND hsfol2_contrato.`id` = ?', [$token, $contrato]);
        } else {
            $servidor = DB::select('select a.nome, c.matricula, d.descricao as desc_funcao, f.descricao as desc_lotacao, h.padrao,
                h.nivel, h.classe from hscad_cadmunicipal a, hsfol_servidor b, hsfol_contrato c, hsfol_funcao d, hsfol_contratolocal e,
                hsfol_lotacao f, hsfol_contratoadmissao g, hsfol_padraoclasse h where a.tokenweb = ? && c.id = ?
                && a.inscricaomunicipal = b.idcadmunicipal && b.id = c.idservidor && c.idfuncao = d.id &&
                c.id = e.idcontrato && e.idlotacao = f.id && c.id = g.idcontrato && g.idpadraoclasse = h.id', [$token, $contrato]);
        }

        return $servidor;
    }

    public function consultaDemonstrativoPeriodo()
    {
        if (Session::get('login_contracheque')) {
            $token = Session::get('tokenweb');

            $tiposfolha = DB::select('select id, descricao from hsfol2_tipofolha');

            $contratos = DB::select(
                "SELECT `contrato`.`idcontrato` AS `id`,
                                            `contrato`.`matricula` AS `matricula`,
                                            (SELECT `funcao`.`descricao`
                                               FROM `hsfol2_funcao` `funcao`
                                              WHERE `contratoFuncao`.`idfuncao` = `funcao`.`id`)
                                               AS `desc_funcao`,
                                            `func_fol2_contrato_admissao`(`contrato`.`idcontrato`) AS `dataadmissao`,
                                            (SELECT `situacao`.`descricao`
                                               FROM `hsfol2_situacaocontratual` `situacao`
                                              WHERE `contratoAtividade`.`idsituacaocontratual` = `situacao`.`id`)
                                               AS `desc_situacao`
                                       FROM `view_fol2_contratorelacaoatual` `contrato`
                                            INNER JOIN `hsfol2_contratofuncao` `contratoFuncao`
                                               ON `contrato`.`idcontratofuncao` = `contratoFuncao`.`id`
                                            INNER JOIN `hsfol2_contratoatividade` `contratoAtividade`
                                               ON `contrato`.`idcontratoatividade` = `contratoAtividade`.`id`
                                      WHERE `contrato`.`idservidor` =
                                                (SELECT `servidor`.`id`
                                                   FROM `hsfol2_servidor` `servidor`
                                                        INNER JOIN `hscad_cadmunicipal` `municipe`
                                                           ON `municipe`.`inscricaomunicipal` = `servidor`.`idmunicipe`
                                                  WHERE `municipe`.`tokenweb` = :tk)",
                ['tk' => $token]
            );

            $anoNumero = date('Y');
            $dtI = $anoNumero . "-01-01";
            $dtF = $anoNumero . "-12-31";
            //dd($dtI);

            return view('auth.consultaDemonstrativoPeriodo', compact('contratos', 'tiposfolha', 'dtI', 'dtF'));
        }
        return redirect()->route('dashboard');
    }

    public function buscaDadosOrgao()
    {
        $dados = DB::select('select a.nome_empresa, a.numero, a.cnpj, b.nome from hscad_dadosempresa a, hscad_logradouros b
        where a.id = 1 and a.idlogradouro = b.id');

        return $dados;
    }

    public function calculaTotalValores($array)
    {
        $dados = 0;
        if (isset($array)) {
            foreach ($array as $item) {
                $aux = $item->valor;
                $dados = $dados + $aux;
            }
        }

        return $dados;
    }

    public function buscaVencimentos($valores)
    {
        foreach ($valores as $valor) {
            if (($valor->classificacao == '1') || ($valor->classificacao == 'P')) {
                $vencimentos[] = $valor;
            }
        }
        if (isset($vencimentos)) {
            return $vencimentos;
        } else {
            return null;
        }
    }

    public function buscaDescontos($valores)
    {
        foreach ($valores as $valor) {
            if (($valor->classificacao == '2') || ($valor->classificacao == 'D')) {
                $descontos[] = $valor;
            }
        }
        if (isset($descontos)) {
            return $descontos;
        } else {
            return null;
        }
    }

    public function buscaBases($valores)
    {
        foreach ($valores as $valor) {
            if (($valor->classificacao == '4') || ($valor->classificacao == 'B')) {
                $bases[] = $valor;
            }
        }
        if (isset($bases)) {
            return $bases;
        } else {
            return null;
        }
    }

    public function traduzMes($month)
    {
        switch ($month) {
            case "JANUARY":
                $mes = "JANEIRO";
                return $mes;
                break;
            case "FEBRUARY":
                $mes = "FEVEREIRO";
                return $mes;
                break;
            case "MARCH":
                $mes = "MARÇO";
                return $mes;
                break;
            case "APRIL":
                $mes = "ABRIL";
                return $mes;
                break;
            case "MAY":
                $mes = "MAIO";
                return $mes;
                break;
            case "JUNE":
                $mes = "JUNHO";
                return $mes;
                break;
            case "JULY":
                $mes = "JULHO";
                return $mes;
                break;
            case "AUGUST":
                $mes = "AGOSTO";
                return $mes;
                break;
            case "SEPTEMBER":
                $mes = "SETEMBRO";
                return $mes;
                break;
            case "OCTOBER":
                $mes = "OUTUBRO";
                return $mes;
                break;
            case "NOVEMBER":
                $mes = "NOVEMBRO";
                return $mes;
                break;
            case "DECEMBER":
                $mes = "DEZEMBRO";
                return $mes;
                break;
        }
    }
}
