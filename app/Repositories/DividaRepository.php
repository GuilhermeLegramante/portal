<?php

namespace App\Repositories;

use DB;

class DividaRepository
{
    /**
     * Busca todas as dívidas do usuário
     * @param $id (id do munícipe)
     * @return Collection $data
     */
    public function getAll($id)
    {
        $data = DB::select("SELECT `divida`.`id`,
                                   `divida`.`idusuario`,
                                   `divida`.`idsegurado`,
                                   `divida`.`idparamservico`,
                                   `servico`.`idservico` AS `idtiposervico`,
                                   `divida`.`inscricao` AS `inscricao`,
                                   `divida`.`tipo` AS `tipo`,
                                   `divida`.`descricao` AS `descricao`,
                                   `servico`.`nome` AS `servico`,
                                   (SELECT `tipoServico`.`descricao`
                                      FROM `hsprv_servico` `tipoServico`
                                     WHERE `servico`.`idservico` = `tipoServico`.`id`)
                                      AS `tiposervico`,
                                   `divida`.`datainscricao` AS `datainscricao`,
                                   SUM(IF(`movimento`.`tipo` = 'MI', `movimento`.`valor`, 0)) AS `devido`,
                                   SUM(IF(`movimento`.`tipo` = 'AI', `movimento`.`valor`, 0)) AS `cancelado`,
                                   SUM(IF(`movimento`.`tipo` IN ('JR', 'MT', 'CR'), `movimento`.`valor`, 0)) AS `atualizacao`,
                                   SUM(IF(`movimento`.`tipo` = 'PG', `movimento`.`valor`,
                                          IF(`movimento`.`tipo` = 'AP', -`movimento`.`valor`, 0))) AS `pago`,
                                   SUM(IF(`movimento`.`tipo` IN ('MI', 'JR', 'MT', 'CR'), `movimento`.`valor`, 0)) AS `originalcorrigido`,
                                   SUM(IF(`movimento`.`tipo` IN ('MI', 'JR', 'MT', 'CR', 'AP'), `movimento`.`valor`,
                                          IF(`movimento`.`tipo` IN ('AI', 'PG'), -`movimento`.`valor`, 0))) AS `saldo`,
                                   IF(SUM(IF(`movimento`.`tipo` IN ('MI', 'JR', 'MT', 'CR', 'AP'), `movimento`.`valor`,
                                            IF(`movimento`.`tipo` IN ('AI', 'PG'), -`movimento`.`valor`, 0))) = 0, 'ENCERRADA', 'ABERTA') AS `status`
                              FROM `hsprv_dividaparcelamovimento` `movimento`
                                   INNER JOIN `hsprv_dividaparcela` `parcela`
                                      ON `parcela`.`id` = `movimento`.`iddividaparcela`
                                   INNER JOIN `hsprv_divida` `divida`
                                      ON `divida`.`id` = `parcela`.`iddivida`
                                   INNER JOIN `hsprv_segurado` `segurado`
                                      ON `segurado`.`id` = `divida`.`idsegurado`
                                   INNER JOIN `hsprv_parametroservico` `servico`
                                      ON `servico`.`id` = `divida`.`idparamservico`
                             WHERE `segurado`.`idcadastro` = ?
                             GROUP BY `divida`.`id`", [$id]);

        return collect($data);
    }

    /**
     * Buscar o saldo das dívidas do segurado
     * @param $id (id do munícipe)
     * @return Collection $data
     */
    public function getSummary(int $id) {
        $data = DB::select("SELECT `segurado`.`idcadastro` AS `idmunicipe`,
                                   SUM(IF(`movimento`.`tipo` = 'MI', `movimento`.`valor`, 0)) AS `inscrito`,
                                   SUM(IF(`movimento`.`tipo` = 'AI', `movimento`.`valor`, 0)) AS `cancelado`,
                                   SUM(IF(`movimento`.`tipo` IN ('JR', 'MT', 'CR'), `movimento`.`valor`, 0)) AS `atualizacao`,
                                   SUM(IF(`movimento`.`tipo` = 'PG', `movimento`.`valor`,
                                           IF(`movimento`.`tipo` = 'AP', -`movimento`.`valor`, 0))) AS `pago`,
                                   SUM(IF(`movimento`.`tipo` IN ('MI', 'JR', 'MT', 'CR', 'AP'), `movimento`.`valor`,
                                           IF(`movimento`.`tipo` IN ('AI', 'PG'), -`movimento`.`valor`, 0))) AS `saldo`
                              FROM `hsprv_dividaparcelamovimento` `movimento`
                                   INNER JOIN `hsprv_dividaparcela` `parcela`
                                      ON `parcela`.`id` = `movimento`.`iddividaparcela`
                                   INNER JOIN `hsprv_divida` `divida`
                                      ON `divida`.`id` = `parcela`.`iddivida`
                                   INNER JOIN `hsprv_segurado` `segurado`
                                      ON `segurado`.`id` = `divida`.`idsegurado`
                                   INNER JOIN `hsprv_parametroservico` `servico`
                                      ON `servico`.`id` = `divida`.`idparamservico`
                             WHERE `segurado`.`idcadastro` = ?
                             GROUP BY `segurado`.`idcadastro`", [$id]);

        return collect($data);
    }
}
