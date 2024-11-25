<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UnregisteredDebtRepository
{
    private $table = 'hsprv_atendimentomedico';

    private $baseQuery;

    public function __construct()
    {
        $this->baseQuery = DB::table('hsprv_atendimentomedico AS atendimento')
            ->join('hsprv_segurado AS segurado', 'segurado.id', '=', 'atendimento.idsegurado')
            ->join('hsprv_conveniado AS conveniado', 'conveniado.id', '=', 'atendimento.idconveniado')
            ->join('hsprv_parametroservico AS servico', 'servico.id', '=', 'atendimento.idservico')
            ->leftJoin('hsprv_seguradodependente AS dependente', 'dependente.id', '=', 'atendimento.iddependente')
            ->select(
                'atendimento.id AS id',
                DB::raw("IF(atendimento.situacao = 1, 'I', 'P') AS situacao"),
                'atendimento.valor AS valorTotal',
                'atendimento.valorsegurado AS valorSegurado',
                'atendimento.valorconveniado AS valorConveniado',
                'atendimento.quantidade AS quantidade',
                'atendimento.dataconsulta AS dataConsulta',
                'atendimento.observacao AS observacao',
                'servico.codigo AS codigoProcedimento',
                'servico.nome AS descricaoProcedimento',
                DB::raw("(
                    SELECT
                       municipe.nome
                    FROM
                       hscad_cadmunicipal municipe
                    WHERE
                       conveniado.idcadastro = municipe.inscricaomunicipal
                 ) AS nomeConveniado"),
                DB::raw("IF(
                    atendimento.iddependente IS NOT NULL,
                    (
                       SELECT
                          municipe.nome
                       FROM
                          hscad_cadmunicipal municipe
                       WHERE
                          dependente.iddependente = municipe.inscricaomunicipal
                    ),
                    (
                       SELECT
                          municipe.nome
                       FROM
                          hscad_cadmunicipal municipe
                       WHERE
                          segurado.idcadastro = municipe.inscricaomunicipal
                    )
                 ) AS nomePaciente"),
                DB::raw("DATE_FORMAT(atendimento.dataconsulta,'%m/%Y') as dataBusca")
            );
    }

    public function all(string $search = null, string $sortBy = 'dataConsulta', string $sortDirection = 'desc', string $perPage = '30')
    {
        $query = $this->baseQuery
            ->where([
                ['segurado.idcadastro', '=', session()->get('idmunicipe')],
                ['atendimento.revisado', 1],
            ])
            ->having('situacao', 'P');

        if (isset($search)) {
            $query = $query->having('dataBusca', $search);
        }

        return $query->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    public function allSimplified()
    {
        // return $this->baseQuery->get();
    }

    public function save($data)
    {

    }

    public function update($data)
    {

    }

    public function delete($data)
    {

    }

    public function findById($id)
    {
        // return $this->baseQuery
        //     ->where($this->table . '.id', $id)
        //     ->get()
        //     ->first();
    }
}
