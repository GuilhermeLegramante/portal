<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function teste()
    {
        dd('teste');
    }

    public function getServices()
    {
        return DB::table('hsprv_parametroservico')
            ->select(
                'codigo AS code',
                'nome AS name',
                'tratamento AS value',
                'indicetitular AS titularValue',
                'indicemaior AS dependentValue',
            )
            ->where('bloqueado', 0)
            ->get();
    }

    public function getPeople()
    {
        $people = DB::table('hscad_cadmunicipal')
            ->select(
                'hscad_cadmunicipal.inscricaomunicipal AS inscricao',
                'hscad_cadmunicipal.nome AS nome'
            )
            ->addSelect([
                'conveniado' => DB::table('hsprv_conveniado')
                    ->select(DB::raw(1))
                    ->whereColumn('hsprv_conveniado.idcadastro', '=', 'hscad_cadmunicipal.inscricaomunicipal')
                    ->whereNull('hsprv_conveniado.dataafastamento')
                    ->take(1)
            ])
            ->addSelect([
                'segurado' => DB::raw(
                    '(SELECT 1
                    FROM
                        (SELECT seg.id, seg.idcadastro, (SELECT 1 FROM hsprv_seguradoafastamento afast WHERE afast.idsegurado = seg.id) AS afastado
                           FROM hsprv_segurado seg
                         HAVING afastado IS NULL) segurado
                   WHERE segurado.idcadastro = hscad_cadmunicipal.inscricaomunicipal
                   GROUP BY segurado.idcadastro) segurado'
                )
            ])
            ->addSelect([
                'dependente' => DB::table('hsprv_seguradodependente')
                    ->select(DB::raw(1))
                    ->whereColumn('hsprv_seguradodependente.iddependente', '=', 'hscad_cadmunicipal.inscricaomunicipal')
                    ->take(1)
            ])
            ->where('hscad_cadmunicipal.ativo', '=', 1)
            ->get();

        $people = $people->filter(function ($person) {
            return $person->conveniado != null || $person->segurado != null || $person->dependente != null;
        })->values();

        return $people;
    }

    /**
     * Calcula os valores do Serviço
     * @param $date (data do atendimento)
     * @param $serviceCode (codigo do serviço)
     * @param $type (0 = segurado, 1 = dependente)
     * @param $citizenId (id do munícipe)
     *
     * @return $collection
     */
    public function getServiceValue(Request $request)
    {
        $service = DB::table('hsprv_parametroservico')
            ->where('codigo', '=', $request->serviceCode)
            ->get()
            ->first();

        if ($service != null) {
            if ($service->quantidade != null) {
                $chValue = $this->getChMonthIndex($request->date, $service->id);
                $qtdCh = $service->quantidade;
            } else {
                $chValue = 0;
                $qtdCh = 0;
            }

            if ($service->tratamento != null) {
                $baseValue = (float) $service->tratamento;
            } else {
                $baseValue = (float) $qtdCh * (float) $chValue;
            }

            // Se for dependente (type = 1) precisa verificar se é maior de idade ou não
            // para aplicar o respectivo índice
            if ($request->type == 0) {
                $patientIndex = $service->indicetitular;
            } else {
                $isOlder = $this->verifyMajority($request->citizenId);
                if ($isOlder) {
                    $patientIndex = $service->indicemaior;
                } else {
                    $patientIndex = $service->indicemenor;
                }
            }
        }

        $patientValue = ($baseValue * (int) $patientIndex) / 100;

        $data = [
            'chValue' => $chValue,
            'qtdCh' => $qtdCh,
            'baseValue' => $baseValue,
            'patientIndex' => (float) $patientIndex,
            'patientValue' => $patientValue,
        ];

        return collect($data);
    }

    private function getChMonthIndex($date, $serviceId)
    {
        $sql = "SELECT `indice`.`idindice` AS `idindice`,
                        CASE MONTH('$date')
                        WHEN 1 THEN `indice`.ijaneiro
                        WHEN 2 THEN `indice`.ifevereiro
                        WHEN 3 THEN `indice`.imarco
                        WHEN 4 THEN `indice`.iabril
                        WHEN 5 THEN `indice`.imaio
                        WHEN 6 THEN `indice`.ijunho
                        WHEN 7 THEN `indice`.ijulho
                        WHEN 8 THEN `indice`.iagosto
                        WHEN 9 THEN `indice`.isetembro
                        WHEN 10 THEN `indice`.ioutubro
                        WHEN 11 THEN `indice`.inovembro
                        WHEN 12 THEN `indice`.idezembro
                        END
                        AS `indice_ch`
                FROM `hscad_indicereferencia` `indice`
                WHERE `indice`.`ano` = YEAR('$date')
                    AND `indice`.`idindice` = (SELECT `parametro`.`idindice`
                                                FROM `hsprv_parametroservico` `parametro`
                                                WHERE `parametro`.`id` = '$serviceId')";

        $data = DB::select(DB::raw($sql));

        if ($data != null) {
            return $data[0]->indice_ch;
        } else {
            return false;
        }
    }

    private function verifyMajority($dependentId)
    {
        $dependent = DB::table('hsprv_seguradodependente')
            ->where('iddependente', '=', $dependentId)->get()->first();

        $reference = DB::table('hsprv_referencia')
            ->where('exercicio', '=', date('Y'))
            ->where('mes', '=', date('m'))
            ->get()
            ->first();

        $majority = 21;

        if ($reference != null) {
            $majority = $reference->maioridade;
        }

        $age = 0;

        if ($dependent != null) {
            $currentYear = date('Y');
            $person = DB::table('hscad_cadmunicipal')
                ->where('inscricaomunicipal', $dependent->iddependente)
                ->select('datanascimento')
                ->get()
                ->first();

            $dependentBornDate = $person->datanascimento;

            $sub = strtotime($currentYear) - strtotime($dependentBornDate);

            $age = floor($sub / (60 * 60 * 24)) / 365;
        }

        if ($age >= $majority) {
            return true;
        } else {
            return false;
        }
    }
}
