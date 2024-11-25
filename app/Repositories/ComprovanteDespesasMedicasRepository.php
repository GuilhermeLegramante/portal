<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ComprovanteDespesasMedicasRepository
{
    public function resumeData($exc)
    {
        return DB::select("SELECT `contribuinte`.`id`,
        `contribuinte`.`idMunicipe`,
        `contribuinte`.`nome`,
        `contribuinte`.`dataNascimento`,
        `contribuinte`.`dataAfastamento`,
        `contribuinte`.`documento`,
        `contribuinte`.`vinculo`,
        SUM(`contribuinte`.`valorContribuicao`) AS `valorContribuicao`,
        SUM(IF(`contribuinte`.`valorPago` < 0, 0, `contribuinte`.`valorPago`)) AS `valorPago`,
        SUM(`contribuinte`.`valorReembolso`) AS `valorReembolso`
   FROM (SELECT `segurado`.`id` AS `id`,
                `segurado`.`idcadastro` AS `idMunicipe`,
                `segurado`.`matricula` AS `matricula`,
                `segurado`.`vinculo` AS `vinculo`,
                `municipe`.`nome` AS `nome`,
                `municipe`.`datanascimento` AS `dataNascimento`,
                (SELECT `afastamento`.`data`
                   FROM `hsprv_seguradoafastamento` `afastamento`
                  WHERE `afastamento`.`idsegurado` = `segurado`.`id`)
                   AS `dataAfastamento`,
                (SELECT IF(`documento`.`numero` = '000.000.000-00', NULL, `documento`.`numero`)
                   FROM `hscad_municipedoc` `documento`
                  WHERE `documento`.`idmunicipe` = `municipe`.`inscricaomunicipal`
                    AND `documento`.`iddocumento` = 3)
                   AS `documento`,
                IFNULL(
                   IF(`segurado`.`vinculo` = 'I',
                      (SELECT SUM(`calcEvento`.`valor`)
                         FROM `hsfol2_calculoevento` `calcEvento`
                              INNER JOIN `hsfol2_calculo` `calculo`
                                 ON `calculo`.`id` = `calcEvento`.`idcalculo`
                              INNER JOIN `hsfol2_referencia` `referencia`
                                 ON `referencia`.`id` = `calculo`.`idreferencia`
                        WHERE `calcEvento`.`idevento` IN (661, 681, 695)
                          AND YEAR(`referencia`.`datafolha`) = ?
                          AND `calculo`.`idcontrato` = `segurado`.`idcontrato`),
                      (SELECT SUM(`contribuicao`.`valor`)
                         FROM `dmed_contribuicao_titular` `contribuicao`
                        WHERE `contribuicao`.`idsegurado` = `segurado`.`id`
                          AND YEAR(`contribuicao`.`competencia`) = ?
                        GROUP BY YEAR(`contribuicao`.`competencia`))),
                   0.00)
                   AS `valorContribuicao`,
                IFNULL(
                   (SELECT SUM(IF(`movimento`.`tipo` = 'PG',
                                 `movimento`.`valor`, -`movimento`.`valor`))
                              AS `valorPago`
                      FROM `hsprv_dividaparcelamovimento` `movimento`
                           INNER JOIN `hsprv_dividaparcela` `parcela`
                              ON `parcela`.`id` = `movimento`.`iddividaparcela`
                           INNER JOIN `hsprv_divida` `divida`
                              ON `divida`.`id` = `parcela`.`iddivida`
                     WHERE `movimento`.`tipo` IN ('PG', 'AP')
                       AND YEAR(`movimento`.`data`) = ?
                       AND `divida`.`idsegurado` = `segurado`.`id`
                     GROUP BY `divida`.`idsegurado`),
                   0.00)
                   AS `valorPago`,
                IFNULL(
                   (SELECT SUM(`reembolso`.`valor`)
                      FROM `dmed_reembolso` `reembolso`
                     WHERE `reembolso`.`idsegurado` = `segurado`.`id`
                       AND YEAR(`reembolso`.`competencia`) = ?
                     GROUP BY `reembolso`.`idsegurado`),
                   0.00)
                   AS `valorReembolso`
           FROM `hsprv_segurado` `segurado`
                INNER JOIN `hscad_cadmunicipal` `municipe`
                   ON `municipe`.`inscricaomunicipal` = `segurado`.`idcadastro`
          WHERE `segurado`.`idcadastro` = ?
         HAVING `dataAfastamento` IS NULL OR YEAR(`dataAfastamento`) >= ?
          ORDER BY `documento`, `nome`) `contribuinte`
  GROUP BY `contribuinte`.`documento`, `contribuinte`.`nome`
  ORDER BY `nome`", [$exc, $exc, $exc, $exc, session()->get('idmunicipe'), $exc]);
    }

    public function debts($exc)
    {
        return DB::select("SELECT `divida`.`idsegurado` AS `idsegurado`,
        `movimento`.`data` AS `data`,
        `movimento`.`historico` AS `historico`,
        MONTH(`movimento`.`data`) AS `mes`,
        YEAR(`movimento`.`data`) AS `ano`,
        `movimento`.`tipo` AS `tipo`,
        IF(`movimento`.`tipo` = 'PG', `movimento`.`valor`,
           IF(`movimento`.`tipo` = 'AP', -`movimento`.`valor`, 0.00))
           AS `valor`
   FROM `hsprv_dividaparcelamovimento` `movimento`
        INNER JOIN `hsprv_dividaparcela` `parcela`
           ON `parcela`.`id` = `movimento`.`iddividaparcela`
        INNER JOIN `hsprv_divida` `divida`
           ON `divida`.`id` = `parcela`.`iddivida`
        INNER JOIN `hsprv_parametroservico` `servico`
           ON `servico`.`id` = `divida`.`idparamservico`
        INNER JOIN `hsprv_segurado` `segurado`
           ON `divida`.`idsegurado` = `segurado`.`id`
  WHERE `movimento`.`tipo` IN ('PG', 'AP')
    AND YEAR(`movimento`.`data`) = ?
    AND `segurado`.`idcadastro` = ?
 ORDER BY `idsegurado`, `ano`, `mes`", [$exc, session()->get('idmunicipe')]);
    }
}
