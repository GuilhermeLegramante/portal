<?php

namespace App\Services;

class CrpTxtFile
{
    public function getCrpDataFromExternalFile($year)
    {
        //https://pdftotext.com/pt/
        $array = file(env('PARTITION_DIRF_FILE') . '\dirf-' . $year . '.txt');

        $starts = $this->getAllStarts($array, $year);
        $ends = $this->getAllEnds($array, $year);

        $people = [];
        for ($i = 0; $i < count($starts); $i++) {
            $end = isset($ends[$i]) ? $ends[$i] : count($ends);
            $person = $this->getPerson($array, $starts[$i], $end);
            array_push($people, $person);
        }

        // Seta a posição que o CPF/CNPJ se encontra no arquivo
        $documentPosition = 14;

        /**
         * Trecho para resolver diferenças de posição no arquivo
         */
        // $config = env('CRP_CONFIG') ? env('CRP_CONFIG') : null;

        // if ($config != null && $config == 'PELOTAS') {
        //     /**
        //      * Este trecho funcionou para PELOTAS
        //      */
        //     $documentPosition = 14;
        // }

        // if ($config != null && $config == 'SISPREM') {
        //     /**
        //      * Este trecho funcionou para o SISPREM
        //      */
        //     switch ($year) {
        //         case '2020':
        //             $documentPosition = 14;
        //             break;
        //         case '2021':
        //             $documentPosition = 15;
        //             break;
        //         case '2022':
        //             $documentPosition = 14;
        //             break;
        //         default:
        //             # code...
        //             break;
        //     }
        // }

        $person = [];
        foreach ($people as $value) {
            for ($i = 0; $i < count($value); $i++) {
                // Verifica se o documento é o mesmo do contribuinte que está logado
                if (strlen(trim(session()->get('municipeCpf'))) == 14) {
                    if (substr(trim($value[$documentPosition]), 0, 14) == trim(session()->get('municipeCpf'))) {
                        // if (substr(trim($value[$documentPosition]), 0, 14) == '542.299.950-91') {
                        $person = $value;
                    }
                } else {
                    if (substr(trim($value[$documentPosition]), 0, 18) == trim(session()->get('municipeCpf'))) {
                        $person = $value;
                    }
                }
            }
        }

        return $this->getValuesFromFilePosition($year, $person);
    }

    /**
     * Busca as informações de acordo com a posição no .txt
     * Para cada ano é necessário verificar a posição que o valor se encontra
     */
    public function getValuesFromFilePosition($year, $person)
    {
        $config = env('CRP_CONFIG') ? env('CRP_CONFIG') : null;

        if ($config != null && $config == 'PELOTAS') {
            return $this->pelotas($year, $person);
        }

        if ($config != null && $config == 'SISPREM') {
            return $this->sisprem($year, $person);
        }
    }

    public function pelotas($year, $person)
    {
        switch ($year) {
            case '2021':
                return [
                    'rendimento' => trim($person[27]),
                    'previdencia' => trim($person[31]),
                    'complementar' => trim($person[36]),
                    'pensao' => trim($person[40]),
                    'irrf' => trim($person[44]),
                    'isento' => trim($person[52]),
                    'diaria' => trim($person[56]),
                    'molestia' => trim($person[60]),
                    'dividendo' => trim($person[64]),
                    'pagamento' => trim($person[68]),
                    'indenizacao' => trim($person[72]),
                    'abono' => trim($person[76]),
                    'decimo' => trim($person[84]),
                    'irrfdecimo' => trim($person[88]),
                    'outro' => trim($person[92]),
                    'rra_meses' => trim($person[99]),
                    'rra_rendimento' => trim($person[107]),
                    'rra_judicial' => trim($person[111]),
                    'rra_previdencia' => trim($person[115]),
                    'rra_pensao' => trim($person[119]),
                    'rra_irrf' => trim($person[123]),
                    'rra_isento' => trim($person[128]),
                    'complementares' => $this->getComplementaryData($person),
                ];
                break;

            case '2022':
                return [
                    'rendimento' => trim($person[27]),
                    'previdencia' => trim($person[31]),
                    'complementar' => trim($person[36]),
                    'pensao' => trim($person[40]),
                    'irrf' => trim($person[44]),
                    'isento' => trim($person[53]),
                    'diaria' => trim($person[57]),
                    'molestia' => trim($person[61]),
                    'dividendo' => trim($person[65]),
                    'pagamento' => trim($person[69]),
                    'indenizacao' => trim($person[73]),
                    'abono' => trim($person[77]),
                    'decimo' => trim($person[93]),
                    'irrfdecimo' => trim($person[97]),
                    'outro' => trim($person[101]),
                    'rra_meses' => trim($person[108]),
                    'rra_rendimento' => trim($person[116]),
                    'rra_judicial' => trim($person[120]),
                    'rra_previdencia' => trim($person[124]),
                    'rra_pensao' => trim($person[128]),
                    'rra_irrf' => trim($person[132]),
                    'rra_isento' => trim($person[137]),
                    'complementares' => $this->getComplementaryData($person),
                ];
                break;
        }
    }

    public function sisprem($year, $person)
    {
        switch ($year) {
            case '2022' || '2023':
                return [
                    'rendimento' => trim($person[27]),
                    'previdencia' => trim($person[31]),
                    'complementar' => trim($person[36]),
                    'pensao' => trim($person[40]),
                    'irrf' => trim($person[44]),
                    'isento' => trim($person[53]),
                    'isento2' => trim($person[57]),
                    'diaria' => trim($person[61]),
                    'molestia' => trim($person[65]),
                    'dividendo' => trim($person[69]),
                    'pagamento' => trim($person[73]),
                    'indenizacao' => trim($person[77]),
                    'juros' => trim($person[81]),
                    'abono' => trim($person[85]),
                    'decimo' => trim($person[93]),
                    'irrfdecimo' => trim($person[97]),
                    'outro' => trim($person[101]),
                    'rra_meses' => trim($person[108]),
                    'rra_rendimento' => trim($person[116]),
                    'rra_judicial' => trim($person[120]),
                    'rra_previdencia' => trim($person[124]),
                    'rra_pensao' => trim($person[128]),
                    'rra_irrf' => trim($person[132]),
                    'rra_isento' => trim($person[137]),
                    'complementares' => $this->getComplementaryData($person),
                ];
                break;
            case '2020':
                return [
                    'rendimento' => trim($person[27]),
                    'previdencia' => trim($person[31]),
                    'complementar' => trim($person[36]),
                    'pensao' => trim($person[40]),
                    'irrf' => trim($person[44]),
                    'isento' => trim($person[52]),
                    'diaria' => trim($person[56]),
                    'molestia' => trim($person[60]),
                    'dividendo' => trim($person[64]),
                    'pagamento' => trim($person[68]),
                    'indenizacao' => trim($person[72]),
                    'abono' => trim($person[76]),
                    'decimo' => trim($person[84]),
                    'irrfdecimo' => trim($person[88]),
                    'outro' => trim($person[92]),
                    'rra_meses' => trim($person[99]),
                    'rra_rendimento' => trim($person[107]),
                    'rra_judicial' => trim($person[111]),
                    'rra_previdencia' => trim($person[115]),
                    'rra_pensao' => trim($person[119]),
                    'rra_irrf' => trim($person[123]),
                    'rra_isento' => trim($person[128]),
                    'complementares' => $this->getComplementaryData($person),
                ];
                break;
            case '2021':
                // Teste pra ajustar os valores pq tem uma linha em branco na posição 16 do array
                if (trim($person[18]) == "") {
                    return [
                        'rendimento' => trim($person[25]),
                        'previdencia' => trim($person[28]),
                        'complementar' => trim($person[68]),
                        'pensao' => trim($person[70]),
                        'irrf' => trim($person[72]),
                        'isento' => trim($person[76]),
                        'diaria' => trim($person[78]),
                        'molestia' => trim($person[80]),
                        'dividendo' => trim($person[82]),
                        'pagamento' => trim($person[84]),
                        'indenizacao' => trim($person[86]),
                        'abono' => trim($person[88]),
                        'decimo' => trim($person[92]),
                        'irrfdecimo' => trim($person[94]),
                        'outro' => trim($person[96]),
                        'rra_meses' => trim($person[102]),
                        'rra_rendimento' => trim($person[129]),
                        'rra_judicial' => trim($person[131]),
                        'rra_previdencia' => trim($person[133]),
                        'rra_pensao' => trim($person[135]),
                        'rra_irrf' => trim($person[137]) == '' ? '0,00' : trim($person[137]),
                        'rra_isento' => isset($person[139]) ? trim($person[139]) : '0,00',
                        'complementares' => $this->getComplementaryData($person),


                    ];
                    break;
                } else {
                    return [
                        'rendimento' => trim($person[24]),
                        'previdencia' => trim($person[27]),
                        'complementar' => trim($person[67]),
                        'pensao' => trim($person[69]),
                        'irrf' => trim($person[71]),
                        'isento' => trim($person[75]),
                        'diaria' => trim($person[77]),
                        'molestia' => trim($person[79]),
                        'dividendo' => trim($person[81]),
                        'pagamento' => trim($person[83]),
                        'indenizacao' => trim($person[85]),
                        'abono' => trim($person[87]),
                        'decimo' => trim($person[91]),
                        'irrfdecimo' => trim($person[93]),
                        'outro' => trim($person[95]),
                        'rra_meses' => trim($person[101]),
                        'rra_rendimento' => trim($person[128]),
                        'rra_judicial' => trim($person[130]),
                        'rra_previdencia' => trim($person[132]),
                        'rra_pensao' => trim($person[134]),
                        'rra_irrf' => trim($person[136]) == '' ? '0,00' : trim($person[136]),
                        'rra_isento' => isset($person[138]) ? trim($person[138]) : '0,00',
                        'complementares' => $this->getComplementaryData($person),

                    ];
                    break;
                }
                break;
            default:
                # code...
                break;
        }
    }

    public function getComplementaryData($person)
    {
        $slice = array_slice($person, 139);

        $data = [];

        // Para remover o primeiro e último item do array
        for ($i = 1; $i < count($slice) - 1; $i++) {
            array_push($data, $slice[$i]);
        }

        return $data;

        // foreach ($slice as $key => $value) {
        //     dd($key);
        //     if (($value == "Pág. 1\n") || ($value == "7. Informações Complementares\n")) {
        //         return array_splice($slice, 0, $key);
        //         break;
        //     } else {
        //         return [];
        //     }
        // }
    }

    public function getAllStarts($array, $year)
    {
        /**
         * Estes trechos de código resolviam o problema de arquivos com diferentes configurações
         */
        // $str = '';
        // $config = env('CRP_CONFIG') ? env('CRP_CONFIG') : null;

        // if ($config != null && $config == 'PELOTAS') {
        //     /**
        //      * Este trecho funciona para PELOTAS
        //      */
        //     $str = "1. Fonte Pagadora Pessoa Jurídica\n";
        // }

        // if ($config != null && $config == 'SISPREM') {
        //     /**
        //      * Este trecho funciona para o SISPREM
        //      */
        //     switch ($year) {
        //         case '2021':
        //             $str = "1. Fonte Pagadora Pessoa Jurídica\r\n";
        //             break;
        //         case '2020':
        //             $str = "1. Fonte Pagadora Pessoa Jurídica\n";
        //             break;
        //         default:
        //             # code...
        //             break;
        //     }
        // }

        $str = "1. Fonte Pagadora Pessoa Jurídica\n";

        $starts = [];
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $str) {
                $start = $i;
                array_push($starts, $start);
            }
        }

        return $starts;
    }

    public function getAllEnds($array, $year)
    {
        /**
         * Estes trechos de código resolviam o problema de arquivos com diferentes configurações
         */
        // $str = '';
        // $config = env('CRP_CONFIG') ? env('CRP_CONFIG') : null;

        // if ($config != null && $config == 'PELOTAS') {
        //     /**
        //      * Este trecho funciona para PELOTAS
        //      */
        //     $str = "8. Responsável pelas Informações\n";
        // }

        // if ($config != null && $config == 'SISPREM') {
        //     /**
        //      * Este trecho funciona para o SISPREM
        //      */
        //     switch ($year) {
        //         case '2021':
        //             $str = "8. Responsável pelas Informações\r\n";
        //             break;
        //         case '2020':
        //             $str = "8. Responsável pelas Informações\n";
        //             break;
        //         default:
        //             # code...
        //             break;
        //     }
        // }

        $str = "8. Responsável pelas Informações\n";

        $ends = [];
        for ($i = 0; $i < count($array); $i++) {
            if ($array[$i] == $str) {
                $end = $i;
                array_push($ends, $end);
            }
        }

        return $ends;
    }

    public function getPerson($array, $start, $end)
    {
        $person = [];
        for ($i = $start; $i <= $end; $i++) {
            array_push($person, $array[$i]);
        }

        return $person;
    }
}
