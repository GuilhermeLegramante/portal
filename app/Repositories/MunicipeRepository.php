<?php

namespace App\Repositories;

use DB;
use Exception;
use Session;

class MunicipeRepository
{

    public function getByAuth($username, $password)
    {
        $data = DB::table('hscad_municipedoc')
            ->join('hscad_cadmunicipal', 'hscad_cadmunicipal.inscricaomunicipal', '=', 'hscad_municipedoc.idmunicipe')
            ->where('hscad_municipedoc.numero', '=', $username)
            ->where('hscad_cadmunicipal.senhaweb', '=', $password)
            ->where('hscad_municipedoc.iddocumento', '=', 3)
            ->select(
                'hscad_municipedoc.idmunicipe',
                'hscad_cadmunicipal.nome',
                'hscad_cadmunicipal.tokenweb',
                'hscad_municipedoc.numero',
            )
            ->get()->first();

        return $data;
    }

    public function getDashboardData($id)
    {
        $data = "";
        // MUDAR PARA TRUE QUANDO TIVER A CONSULTA FOL2
        try {
            $data = DB::select("SELECT `servidor`.`idmunicipe` AS `inscricao`,
                                       (SELECT `municipe`.`nome`
                                          FROM `hscad_cadmunicipal` `municipe`
                                         WHERE `servidor`.`idmunicipe` = `municipe`.`inscricaomunicipal`)
                                          AS `nome`,
                                       (SELECT `documento`.`numero`
                                          FROM `hscad_municipedoc` `documento`
                                         WHERE `documento`.`iddocumento` = 3
                                          AND `servidor`.`idmunicipe` = `documento`.`idmunicipe`)
                                          AS `documento`,
                                       IFNULL(
                                          SUM((SELECT SUM(`calculoevento`.`valor`)
                                                 FROM `hsfol2_calculoevento` `calculoevento`
                                                      INNER JOIN `hsfol2_calculo` `calculo`
                                                         ON `calculo`.`id` = `calculoevento`.`idcalculo`
                                                      INNER JOIN `hsfol2_referencia` `referencia`
                                                         ON `referencia`.`id` = `calculo`.`idreferencia`
                                                      INNER JOIN `hsfol2_evento` `evento`
                                                         ON `evento`.`id` = `calculoevento`.`idevento`
                                                WHERE `calculo`.`idcontrato` = `contrato`.`id`
                                                  AND YEAR(`referencia`.`datafolha`) = ?
                                                  AND `evento`.`classificacao` = 'P'
                                                  AND referencia.encerrada = 1)), 0.00)
                                          AS `valor_provento`,
                                       IFNULL(
                                          SUM((SELECT SUM(`calculoevento`.`valor`)
                                                 FROM `hsfol2_calculoevento` `calculoevento`
                                                      INNER JOIN `hsfol2_calculo` `calculo`
                                                         ON `calculo`.`id` = `calculoevento`.`idcalculo`
                                                      INNER JOIN `hsfol2_referencia` `referencia`
                                                         ON `referencia`.`id` = `calculo`.`idreferencia`
                                                      INNER JOIN `hsfol2_evento` `evento`
                                                         ON `evento`.`id` = `calculoevento`.`idevento`
                                                WHERE `calculo`.`idcontrato` = `contrato`.`id`
                                                  AND YEAR(`referencia`.`datafolha`) = ?
                                                  AND `evento`.`classificacao` = 'D'
                                                  AND referencia.encerrada = 1)), 0.00)
                                          AS `valor_desconto`
                                  FROM `hsfol2_contrato` `contrato`
                                        INNER JOIN `hsfol2_servidor` `servidor`
                                           ON `servidor`.`id` = `contrato`.`idservidor`
                                 WHERE `servidor`.`idmunicipe` = ?
                                 GROUP BY `inscricao`", [date('Y'), date('Y'), $id]);

        } catch (\Illuminate\Database\QueryException $error) {
            dd($error->getMessage());
        }

        return $data;
    }

    /**
     * Busca os dados para o Comprovante de Rendimentos pagos
     * @param $contract (contrato)
     * @param $fol2 (se já tem fol2 (boolean))
     * @param $exc (exercício)
     * @param $config (conteúdo do arquivo de configuração .ini)
     * @return $data
     */
    public function getCrpData($fol2, $config, $exc)
    {
        try {
            $dti = $exc . "-01-01";
            $dtf = $exc . "-12-31";

            $idmunicipe = Session::get('idmunicipe');

            $rendimento_data = $this->extractConfigCrp('rendimento', $config);
            $previdencia_data = $this->extractConfigCrp('previdencia', $config);
            $complementar_data = $this->extractConfigCrp('complementar', $config);
            $pensao_data = $this->extractConfigCrp('pensao', $config);
            $irrf_data = $this->extractConfigCrp('irrf', $config);
            $isento_data = $this->extractConfigCrp('isento', $config);
            $diaria_data = $this->extractConfigCrp('diaria', $config);
            $molestia_data = $this->extractConfigCrp('molestia', $config);
            $dividendo_data = $this->extractConfigCrp('dividendo', $config);
            $pagamento_data = $this->extractConfigCrp('pagamento', $config);
            $indenizacao_data = $this->extractConfigCrp('indenizacao', $config);
            $abono_data = $this->extractConfigCrp('abono', $config);
            $decimo_data = $this->extractConfigCrp('decimo', $config);
            $irrfdecimo_data = $this->extractConfigCrp('irrfdecimo', $config);
            $outro_data = $this->extractConfigCrp('outro', $config);
            $saude_data = $this->extractConfigCrp('saude', $config);

            $rra_rendimento_data = $this->extractConfigCrp('rra_rendimento', $config);
            $rra_judicial_data = $this->extractConfigCrp('rra_judicial', $config);
            $rra_previdencia_data = $this->extractConfigCrp('rra_previdencia', $config);
            $rra_pensao_data = $this->extractConfigCrp('rra_pensao', $config);
            $rra_irrf_data = $this->extractConfigCrp('rra_irrf', $config);
            $rra_isento_data = $this->extractConfigCrp('rra_isento', $config);
            $rra_meses_data = $this->extractConfigCrp('rra_meses', $config);

            $rendimento_type = $rendimento_data['type'];
            $rendimento_add = $rendimento_data['add'];
            $rendimento_sub = $rendimento_data['sub'];

            $previdencia_type = $previdencia_data['type'];
            $previdencia_add = $previdencia_data['add'];
            $previdencia_sub = $previdencia_data['sub'];

            $complementar_type = $complementar_data['type'];
            $complementar_add = $complementar_data['add'];
            $complementar_sub = $complementar_data['sub'];

            $pensao_type = $pensao_data['type'];
            $pensao_add = $pensao_data['add'];
            $pensao_sub = $pensao_data['sub'];

            $irrf_type = $irrf_data['type'];
            $irrf_add = $irrf_data['add'];
            $irrf_sub = $irrf_data['sub'];

            $isento_type = $isento_data['type'];
            $isento_add = $isento_data['add'];
            $isento_sub = $isento_data['sub'];

            $diaria_type = $diaria_data['type'];
            $diaria_add = $diaria_data['add'];
            $diaria_sub = $diaria_data['sub'];

            $molestia_type = $molestia_data['type'];
            $molestia_add = $molestia_data['add'];
            $molestia_sub = $molestia_data['sub'];

            $dividendo_type = $dividendo_data['type'];
            $dividendo_add = $dividendo_data['add'];
            $dividendo_sub = $dividendo_data['sub'];

            $pagamento_type = $pagamento_data['type'];
            $pagamento_add = $pagamento_data['add'];
            $pagamento_sub = $pagamento_data['sub'];

            $indenizacao_type = $indenizacao_data['type'];
            $indenizacao_add = $indenizacao_data['add'];
            $indenizacao_sub = $indenizacao_data['sub'];

            $abono_type = $abono_data['type'];
            $abono_add = $abono_data['add'];
            $abono_sub = $abono_data['sub'];

            $decimo_type = $decimo_data['type'];
            $decimo_add = $decimo_data['add'];
            $decimo_sub = $decimo_data['sub'];

            $irrfdecimo_type = $irrfdecimo_data['type'];
            $irrfdecimo_add = $irrfdecimo_data['add'];
            $irrfdecimo_sub = $irrfdecimo_data['sub'];

            $outro_type = $outro_data['type'];
            $outro_add = $outro_data['add'];
            $outro_sub = $outro_data['sub'];

            $saude_type = $saude_data['type'];
            $saude_add = $saude_data['add'];
            $saude_sub = $saude_data['sub'];

            $rra_rendimento_type = $rra_rendimento_data['type'];
            $rra_rendimento_add = $rra_rendimento_data['add'];
            $rra_rendimento_sub = $rra_rendimento_data['sub'];

            $rra_judicial_type = $rra_judicial_data['type'];
            $rra_judicial_add = $rra_judicial_data['add'];
            $rra_judicial_sub = $rra_judicial_data['sub'];

            $rra_previdencia_type = $rra_previdencia_data['type'];
            $rra_previdencia_add = $rra_previdencia_data['add'];
            $rra_previdencia_sub = $rra_previdencia_data['sub'];

            $rra_pensao_type = $rra_pensao_data['type'];
            $rra_pensao_add = $rra_pensao_data['add'];
            $rra_pensao_sub = $rra_pensao_data['sub'];

            $rra_irrf_type = $rra_irrf_data['type'];
            $rra_irrf_add = $rra_irrf_data['add'];
            $rra_irrf_sub = $rra_irrf_data['sub'];

            $rra_isento_type = $rra_isento_data['type'];
            $rra_isento_add = $rra_isento_data['add'];
            $rra_isento_sub = $rra_isento_data['sub'];

            $rra_meses_type = $rra_meses_data['type'];
            $rra_meses_add = $rra_meses_data['add'];
            $rra_meses_sub = $rra_meses_data['sub'];

            if ($fol2 == false) {
                $sql_fol1 = "SELECT `servidor`.`idcadmunicipal`,
                              ifnull(
                                 SUM(
                                    if(
                                          `tipofolha`.`codigo` IN ($rendimento_type)
                                       AND `evento`.`codigo` IN ($rendimento_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($rendimento_type) AND `evento`.`codigo` IN ($rendimento_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `rendimento`,
                              ifnull(
                                 SUM(
                                    if(
                                          `tipofolha`.`codigo` IN ($previdencia_type)
                                       AND `evento`.`codigo` IN ($previdencia_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($previdencia_type) AND `evento`.`codigo` IN ($previdencia_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `previdencia`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($complementar_type) AND `evento`.`codigo` IN ($complementar_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($complementar_type) AND `evento`.`codigo` IN ($complementar_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `complementar`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($pensao_type) AND `evento`.`codigo` IN ($pensao_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($pensao_type) AND `evento`.`codigo` IN ($pensao_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `pensao`,
                              ifnull(
                                 SUM(
                                    if(
                                          `tipofolha`.`codigo` IN ($irrf_type)
                                       AND `evento`.`codigo` IN ($irrf_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($irrf_type) AND `evento`.`codigo` IN ($irrf_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `irrf`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($isento_type) AND `evento`.`codigo` IN ($isento_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($isento_type) AND `evento`.`codigo` IN ($isento_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `isento`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($diaria_type) AND `evento`.`codigo` IN ($diaria_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($diaria_type) AND `evento`.`codigo` IN ($diaria_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `diaria`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($molestia_type) AND `evento`.`codigo` IN ($molestia_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($molestia_type) AND `evento`.`codigo` IN ($molestia_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `molestia`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($dividendo_type) AND `evento`.`codigo` IN ($dividendo_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($dividendo_type) AND `evento`.`codigo` IN ($dividendo_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `dividendo`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($pagamento_type) AND `evento`.`codigo` IN ($pagamento_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($pagamento_type) AND `evento`.`codigo` IN ($pagamento_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `pagamento`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($indenizacao_type) AND `evento`.`codigo` IN ($indenizacao_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($indenizacao_type) AND `evento`.`codigo` IN ($indenizacao_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `indenizacao`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($abono_type) AND `evento`.`codigo` IN ($abono_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($abono_type) AND `evento`.`codigo` IN ($abono_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `abono`,
                              ifnull(
                                 SUM(
                                    if(
                                          `tipofolha`.`codigo` IN ($decimo_type)
                                       AND `evento`.`codigo` IN ($decimo_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($decimo_type) AND `evento`.`codigo` IN ($decimo_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `decimo`,
                              ifnull(
                                 SUM(
                                    if(
                                          `tipofolha`.`codigo` IN ($irrfdecimo_type)
                                       AND `evento`.`codigo` IN ($irrfdecimo_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($irrfdecimo_type) AND `evento`.`codigo` IN ($irrfdecimo_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `irrfdecimo`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($outro_type) AND `evento`.`codigo` IN ($outro_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($outro_type) AND `evento`.`codigo` IN ($outro_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `outro`,
                              ifnull(
                                 SUM(
                                    if(
                                       `tipofolha`.`codigo` IN ($saude_type) AND `evento`.`codigo` IN ($saude_add),
                                       `calculo`.`valor`,
                                       if(
                                          `tipofolha`.`codigo` IN ($saude_type) AND `evento`.`codigo` IN ($saude_sub),
                                          -`calculo`.`valor`,
                                          0.00))),
                                 0.00)
                                 AS `saude`,
                              ifnull(
                                       SUM(
                                          if(`tipofolha`.`codigo` IN ($rra_rendimento_type) AND `evento`.`codigo` IN ($rra_rendimento_add), `calculo`.`valor`,
                                                if(`tipofolha`.`codigo` IN ($rra_rendimento_type) AND `evento`.`codigo` IN ($rra_rendimento_sub), -`calculo`.`valor`,
                                                      0.00))),
                                             0.00)
                                             AS `rra_rendimento`,
                              ifnull(
                                             SUM(
                                                if(`tipofolha`.`codigo` IN ($rra_judicial_type) AND `evento`.`codigo` IN ($rra_judicial_add), `calculo`.`valor`,
                                                   if(`tipofolha`.`codigo` IN ($rra_judicial_type) AND `evento`.`codigo` IN ($rra_judicial_sub), -`calculo`.`valor`,
                                                      0.00))),
                                             0.00)
                                             AS `rra_judicial`,
                              ifnull(
                                             SUM(
                                                if(`tipofolha`.`codigo` IN ($rra_previdencia_type) AND `evento`.`codigo` IN ($rra_previdencia_add), `calculo`.`valor`,
                                                   if(`tipofolha`.`codigo` IN ($rra_previdencia_type) AND `evento`.`codigo` IN ($rra_previdencia_sub), -`calculo`.`valor`,
                                                      0.00))),
                                             0.00)
                                             AS `rra_previdencia`,
                              ifnull(
                                             SUM(
                                                if(`tipofolha`.`codigo` IN ($rra_pensao_type) AND `evento`.`codigo` IN ($rra_pensao_add), `calculo`.`valor`,
                                                   if(`tipofolha`.`codigo` IN ($rra_pensao_type) AND `evento`.`codigo` IN ($rra_pensao_sub), -`calculo`.`valor`,
                                                      0.00))),
                                             0.00)
                                             AS `rra_pensao`,
                              ifnull(
                                             SUM(
                                                if(`tipofolha`.`codigo` IN ($rra_irrf_type) AND `evento`.`codigo` IN ($rra_irrf_add), `calculo`.`valor`,
                                                   if(`tipofolha`.`codigo` IN ($rra_irrf_type) AND `evento`.`codigo` IN ($rra_irrf_sub), -`calculo`.`valor`,
                                                      0.00))),
                                             0.00)
                                             AS `rra_irrf`,
                              ifnull(
                                             SUM(
                                                if(`tipofolha`.`codigo` IN ($rra_isento_type) AND `evento`.`codigo` IN ($rra_isento_add), `calculo`.`valor`,
                                                   if(`tipofolha`.`codigo` IN ($rra_isento_type) AND `evento`.`codigo` IN ($rra_isento_sub), -`calculo`.`valor`,
                                                      0.00))),
                                             0.00)
                                             AS `rra_isento`,
                              ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_meses_type) AND `evento`.`codigo` IN ($rra_meses_add), `calculo`.`referencia`,
                                 if(`tipofolha`.`codigo` IN ($rra_meses_type) AND `evento`.`codigo` IN ($rra_meses_sub), -`calculo`.``referencia``,
                                    0.00))),
                           0.00)
                           AS `rra_meses`
                  FROM `hsfol_calculo` `calculo`
                     INNER JOIN `hsfol_referencia` `referencia`
                        ON `referencia`.`id` = `calculo`.`idreferencia`
                     INNER JOIN `hsfol_evento` `evento`
                        ON `evento`.`id` = `calculo`.`idevento`
                     INNER JOIN `hsfol_tipofolha` `tipofolha`
                        ON `tipofolha`.`id` = `referencia`.`idtipofolha`
                     INNER JOIN `hsfol_contrato` `contrato`
                        ON `contrato`.`id` = `calculo`.`idcontrato`
                     INNER JOIN `hsfol_servidor` `servidor`
                        ON `servidor`.`id` = `contrato`.`idservidor`
                     WHERE EXTRACT(YEAR FROM `referencia`.`datafolha`) = '$exc'
                        AND `servidor`.`idcadmunicipal` = '$idmunicipe'
                        AND `referencia`.`datafolha` BETWEEN '$dti' AND '$dtf'
                     GROUP BY `servidor`.`idcadmunicipal`";

                $data = DB::select(DB::raw($sql_fol1));

            }

            if ($fol2 == true) {
                $sql_fol2 = "SELECT `query`.`idmunicipe`,
                              SUM(if(`query`.`rendimento` < 0, 0, `query`.`rendimento`)) AS `rendimento`,
                              SUM(if(`query`.`previdencia` < 0, 0, `query`.`previdencia`)) AS `previdencia`,
                              SUM(if(`query`.`complementar` < 0, 0, `query`.`complementar`)) AS `complementar`,
                              SUM(if(`query`.`pensao` < 0, 0, `query`.`pensao`)) AS `pensao`,
                              SUM(if(`query`.`irrf` < 0, 0, `query`.`irrf`)) AS `irrf`,
                              SUM(if(`query`.`isento` < 0, 0, `query`.`isento` + if(`query`.`rendimento` < 0, `query`.`rendimento`, 0))) AS `isento`,
                              SUM(if(`query`.`diaria` < 0, 0, `query`.`diaria`)) AS `diaria`,
                              SUM(if(`query`.`molestia` < 0, 0, `query`.`molestia`)) AS `molestia`,
                              SUM(if(`query`.`dividendo` < 0, 0, `query`.`dividendo`)) AS `dividendo`,
                              SUM(if(`query`.`pagamento` < 0, 0, `query`.`pagamento`)) AS `pagamento`,
                              SUM(if(`query`.`indenizacao` < 0, 0, `query`.`indenizacao`)) AS `indenizacao`,
                              SUM(if(`query`.`abono` < 0, 0, `query`.`abono`)) AS `abono`,
                              SUM(if(`query`.`decimo` < 0, 0, `query`.`decimo`)) AS `decimo`,
                              SUM(if(`query`.`irrfdecimo` < 0, 0, `query`.`irrfdecimo`)) AS `irrfdecimo`,
                              SUM(if(`query`.`outro` < 0, 0, `query`.`outro`)) AS `outro`,
                              SUM(if(`query`.`saude` < 0, 0, `query`.`saude`)) AS `saude`,
                              SUM(if(`query`.`rra_rendimento` < 0, 0, `query`.`rra_rendimento`)) AS `rra_rendimento`,
                              SUM(if(`query`.`rra_judicial` < 0, 0, `query`.`rra_judicial`)) AS `rra_judicial`,
                              SUM(if(`query`.`rra_previdencia` < 0, 0, `query`.`rra_previdencia`)) AS `rra_previdencia`,
                              SUM(if(`query`.`rra_pensao` < 0, 0, `query`.`rra_pensao`)) AS `rra_pensao`,
                              SUM(if(`query`.`rra_irrf` < 0, 0, `query`.`rra_irrf`)) AS `rra_irrf`,
                              SUM(if(`query`.`rra_isento` < 0, 0, `query`.`rra_isento`)) AS `rra_isento`,
                              SUM(if(`query`.`rra_meses` < 0, 0, `query`.`rra_meses`)) AS `rra_meses`
                        FROM (SELECT `servidor`.`idmunicipe` AS `idmunicipe`,
                                    MONTH(`referencia`.`datafolha`) AS `mes`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($rendimento_type)
                                 AND `evento`.`codigo` IN ($rendimento_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($rendimento_type)
                                    AND `evento`.`codigo` IN ($rendimento_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rendimento`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($previdencia_type)
                                 AND `evento`.`codigo` IN ($previdencia_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($previdencia_type)
                                    AND `evento`.`codigo` IN ($previdencia_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `previdencia`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($complementar_type)
                                 AND `evento`.`codigo` IN ($complementar_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($complementar_type)
                                    AND `evento`.`codigo` IN ($complementar_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `complementar`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($pensao_type)
                                 AND `evento`.`codigo` IN ($pensao_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($pensao_type)
                                    AND `evento`.`codigo` IN ($pensao_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `pensao`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($irrf_type)
                                 AND `evento`.`codigo` IN ($irrf_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($irrf_type)
                                    AND `evento`.`codigo` IN ($irrf_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `irrf`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($isento_type)
                                 AND `evento`.`codigo` IN ($isento_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($isento_type)
                                    AND `evento`.`codigo` IN ($isento_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `isento`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($diaria_type)
                                 AND `evento`.`codigo` IN ($diaria_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($diaria_type)
                                    AND `evento`.`codigo` IN ($diaria_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `diaria`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($molestia_type)
                                 AND `evento`.`codigo` IN ($molestia_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($molestia_type)
                                    AND `evento`.`codigo` IN ($molestia_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `molestia`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($dividendo_type)
                                 AND `evento`.`codigo` IN ($dividendo_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($dividendo_type)
                                    AND `evento`.`codigo` IN ($dividendo_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `dividendo`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($pagamento_type)
                                 AND `evento`.`codigo` IN ($pagamento_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($pagamento_type)
                                    AND `evento`.`codigo` IN ($pagamento_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `pagamento`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($indenizacao_type)
                                 AND `evento`.`codigo` IN ($indenizacao_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($indenizacao_type)
                                    AND `evento`.`codigo` IN ($indenizacao_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `indenizacao`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($abono_type)
                                 AND `evento`.`codigo` IN ($abono_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($abono_type)
                                    AND `evento`.`codigo` IN ($abono_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `abono`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($decimo_type)
                                 AND `evento`.`codigo` IN ($decimo_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($decimo_type)
                                    AND `evento`.`codigo` IN ($decimo_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `decimo`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($irrfdecimo_type)
                                 AND `evento`.`codigo` IN ($irrfdecimo_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($irrfdecimo_type)
                                    AND `evento`.`codigo` IN ($irrfdecimo_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `irrfdecimo`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($outro_type)
                                 AND `evento`.`codigo` IN ($outro_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($outro_type)
                                    AND `evento`.`codigo` IN ($outro_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `outro`,
                        ifnull(
                           SUM(
                              if(
                                    `tipofolha`.`codigo` IN ($saude_type)
                                 AND `evento`.`codigo` IN ($saude_add),
                                 `calcevento`.`valor`,
                                 if(
                                       `tipofolha`.`codigo` IN ($saude_type)
                                    AND `evento`.`codigo` IN ($saude_sub),
                                    -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `saude`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_rendimento_type) AND `evento`.`codigo` IN ($rra_rendimento_add), `calcevento`.`valor`,
                              if(`tipofolha`.`codigo` IN ($rra_rendimento_type) AND `evento`.`codigo` IN ($rra_rendimento_sub), -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rra_rendimento`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_judicial_type) AND `evento`.`codigo` IN ($rra_judicial_add), `calcevento`.`valor`,
                                 if(`tipofolha`.`codigo` IN ($rra_judicial_type) AND `evento`.`codigo` IN ($rra_judicial_sub), -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rra_judicial`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_previdencia_type) AND `evento`.`codigo` IN ($rra_previdencia_add), `calcevento`.`valor`,
                                 if(`tipofolha`.`codigo` IN ($rra_previdencia_type) AND `evento`.`codigo` IN ($rra_previdencia_sub), -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rra_previdencia`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_pensao_type) AND `evento`.`codigo` IN ($rra_pensao_add), `calcevento`.`valor`,
                                 if(`tipofolha`.`codigo` IN ($rra_pensao_type) AND `evento`.`codigo` IN ($rra_pensao_sub), -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rra_pensao`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_irrf_type) AND `evento`.`codigo` IN ($rra_irrf_add), `calcevento`.`valor`,
                                 if(`tipofolha`.`codigo` IN ($rra_irrf_type) AND `evento`.`codigo` IN ($rra_irrf_sub), -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rra_irrf`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_isento_type) AND `evento`.`codigo` IN ($rra_isento_add), `calcevento`.`valor`,
                                 if(`tipofolha`.`codigo` IN ($rra_isento_type) AND `evento`.`codigo` IN ($rra_isento_sub), -`calcevento`.`valor`,
                                    0.00))),
                           0.00)
                           AS `rra_isento`,
                        ifnull(
                           SUM(
                              if(`tipofolha`.`codigo` IN ($rra_meses_type) AND `evento`.`codigo` IN ($rra_meses_add), `calcevento`.`referencia`,
                                 if(`tipofolha`.`codigo` IN ($rra_meses_type) AND `evento`.`codigo` IN ($rra_meses_sub), -`calcevento`.`referencia`,
                                    0.00))),
                           0.00)
                           AS `rra_meses`
                  FROM `hsfol2_calculoevento` `calcevento`
                     INNER JOIN `hsfol2_calculo` `calculo`
                        ON `calculo`.`id` = `calcevento`.`idcalculo`
                     INNER JOIN `hsfol2_evento` `evento`
                        ON `evento`.`id` = `calcevento`.`idevento`
                     INNER JOIN `hsfol2_referencia` `referencia`
                        ON `referencia`.`id` = `calculo`.`idreferencia`
                     INNER JOIN `hsfol2_tipofolha` `tipofolha`
                        ON `tipofolha`.`id` = `referencia`.`idtipofolha`
                     INNER JOIN `hsfol2_contrato` `contrato`
                        ON `contrato`.`id` = `calculo`.`idcontrato`
                     INNER JOIN `hsfol2_servidor` `servidor`
                        ON `servidor`.`id` = `contrato`.`idservidor`
                  WHERE EXTRACT(YEAR FROM `referencia`.`datafolha`) = '$exc'
                        AND `servidor`.`idmunicipe` = '$idmunicipe'
                        AND `referencia`.`datafolha` BETWEEN '$dti' AND '$dtf'
                        GROUP BY `servidor`.`idmunicipe`, MONTH(`referencia`.`datafolha`)) `query`
                  GROUP BY `query`.`idmunicipe`";

                $data = DB::select(DB::raw($sql_fol2));
            }

            if ($data != null) {
                return $data[0];
            } else {
                return false;
            }
        } catch (Exception $error) {
            dd($error->getMessage());
        }
    }

    public function getComplementarDataCrp($exc)
    {
        try {
            $idmunicipe = Session::get('idmunicipe');
            $sql = "SELECT `beneficiario`.`idservidor` AS `idservidor`,
                           `servidor`.`idmunicipe` AS `idmunicipe`,
                           `municipe`.`inscricaomunicipal` AS `inscricao`,
                           `municipe`.`nome` AS `nome`,
                           `beneficiario`.`datanascimento` AS `datanascimento`,
                           (SELECT `documento`.`numero` FROM `hscad_municipedoc` `documento` WHERE `documento`.`iddocumento` = 3 AND `documento`.`idmunicipe` = `municipe`.`inscricaomunicipal`) AS `documento`,
                           ROUND(
                              IFNULL(
                                 (SELECT SUM(`calculoevento`.`valor`)
                                    FROM `hsfol2_calculoevento` `calculoevento`
                                       INNER JOIN `hsfol2_calculo` `calculo`
                                          ON `calculo`.`id` = `calculoevento`.`idcalculo`
                                       INNER JOIN `hsfol2_referencia` `referencia`
                                          ON `referencia`.`id` = `calculo`.`idreferencia`
                                       INNER JOIN `hsfol2_contrato` `contrato`
                                          ON `contrato`.`id` = `calculo`.`idcontrato`
                                    WHERE     YEAR(`referencia`.`datafolha`) = '$exc'
                                          AND `calculoevento`.`idevento` =
                                             `beneficiario`.`idevento`
                                          AND `contrato`.`idservidor` = `servidor`.`id`
                                    GROUP BY `contrato`.`idservidor`),
                                 0.00) * `beneficiario`.`percentual` / 100, 2)
                              AS `valor_beneficio`,
                           ROUND(
                              IFNULL(
                                 (SELECT SUM(`calculoevento`.`valor`)
                                    FROM `hsfol2_calculoevento` `calculoevento`
                                       INNER JOIN `hsfol2_calculo` `calculo`
                                          ON `calculo`.`id` = `calculoevento`.`idcalculo`
                                       INNER JOIN `hsfol2_referencia` `referencia`
                                          ON `referencia`.`id` = `calculo`.`idreferencia`
                                       INNER JOIN `hsfol2_contrato` `contrato`
                                          ON `contrato`.`id` = `calculo`.`idcontrato`
                                    WHERE     YEAR(`referencia`.`datafolha`) = '$exc'
                                          AND `calculoevento`.`idevento` =
                                             `beneficiario`.`ideventorra`
                                          AND `contrato`.`idservidor` = `servidor`.`id`
                                    GROUP BY `contrato`.`idservidor`),
                                 0.00) * `beneficiario`.`percentualrra` / 100, 2)
                              AS `valor_rra`
                              FROM `hsfol2_servidorbeneficiario` `beneficiario`
                              INNER JOIN `hscad_cadmunicipal` `municipe`
                                 ON `municipe`.`inscricaomunicipal` = `beneficiario`.`idbeneficiario`
                              INNER JOIN `hsfol2_servidor` `servidor`
                                 ON `servidor`.`id` = `beneficiario`.`idservidor`
                              INNER JOIN `hsfol2_evento` `evento`
                                 ON `evento`.`id` = `beneficiario`.`idevento`
                              LEFT JOIN `hsfol2_evento` `acumulado`
                                 ON `acumulado`.`id` = `beneficiario`.`ideventorra`
                              WHERE `servidor`.`idmunicipe` = '$idmunicipe'
                              ORDER BY `beneficiario`.`idservidor`, `municipe`.`nome`";

            $data = DB::select(DB::raw($sql));

            if ($data != null) {
                return $data;
            } else {
                return false;
            }

        } catch (Exception $error) {
            dd($error->getMessage());
        }
    }

    public function getContracts()
    {
        if (Session::get('login_contracheque')) {
            $data = DB::select("SELECT `contrato`.`idcontrato` AS `id`,
                                    `contrato`.`matricula` AS `matricula`,
                                    (SELECT `funcao`.`descricao`
                                       FROM `hsfol2_contratofuncao` `contratoFuncao`
                                             INNER JOIN `hsfol2_funcao` `funcao`
                                                ON `funcao`.`id` = `contratoFuncao`.`idfuncao`
                                       WHERE `contrato`.`idcontratofuncao` = `contratoFuncao`.`id`)
                                       AS `desc_funcao`,
                                    `func_fol2_contrato_admissao`(`contrato`.`idcontrato`) AS `dataadmissao`,
                                    (SELECT `situacao`.`descricao`
                                       FROM `hsfol2_contratoatividade` `contratoAtividade`
                                             INNER JOIN `hsfol2_situacaocontratual` `situacao`
                                                ON `situacao`.`id` = `contratoAtividade`.`idsituacaocontratual`
                                       WHERE `contrato`.`idcontratoatividade` = `contratoAtividade`.`id`)
                                       AS `desc_situacao`
                               FROM `view_fol2_contratorelacaoatual` `contrato`
                                    INNER JOIN `hsfol2_servidor` `servidor`
                                       ON `contrato`.`idservidor` = `servidor`.`id`
                              WHERE `servidor`.`idmunicipe` = ?", [Session::get('idmunicipe')]);
        } else {
            return false;
        }

        return collect($data);
    }

    /**
     * Extrai as configurações do CRP
     * @param $key (chave a ser buscada)
     * @param $config (array com os dados)
     * @return $data (array com 3 posições (soma, diminui e tipofolha))
     */
    public function extractConfigCrp($key, $config)
    {
        if (array_key_exists($key, $config)) {
            $array = $config[$key];
            $add = "";
            $sub = "";
            $type = "";
            foreach ($array as $key => $value) {
                if (str_contains($key, 'soma')) {
                    $add = $add . '"' . $value . '"' . ',';
                }
                if (str_contains($key, 'diminui')) {
                    $sub = $sub . '"' . $value . '"' . ',';
                }
                if (str_contains($key, 'tipofolha')) {
                    $type = $type . '"' . $value . '"' . ',';
                }
            }
            if ($add == false) {
                $add = -11;
            }
            if ($sub == false) {
                $sub = -11;
            }
            if ($type == false) {
                $type = -11;
            }
        } else {
            $add = -11;
            $sub = -11;
            $type = -11;
        }

        if (str_contains($add, '-1')) {
            $add = -1;
        } else {
            $add = substr($add, 0, -1);
        }

        if (str_contains($sub, '-1')) {
            $sub = -1;
        } else {
            $sub = substr($sub, 0, -1);
        }

        if (str_contains($type, '-1')) {
            $type = -1;
        } else {
            $type = substr($type, 0, -1);
        }

        $data = [
            'add' => $add,
            'sub' => $sub,
            'type' => $type,
        ];

        return $data;

    }

    public function getCrpConfig($exc)
    {
        $data = DB::table('hsctb_anexo')
            ->where('anexo', 62)
            ->where('gestora', $exc)
            ->get()->first();

        if ($data != null) {
            return $data->arquivo;
        } else {
            return false;
        }
    }
}
