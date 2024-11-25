<?php

namespace App\Services;

use DateTime;
use Illuminate\Support\Facades\DB;

class DateService
{
    public static function getCurrentYear()
    {
        return DB::table('ctb_configuracao')
            ->whereRaw('CAST(codigo AS UNSIGNED) = ?', [1])
            ->max('exercicio');
    }

    public static function calcIdade($date)
    {
        $dataNascimento = $date;
        $date = new DateTime($dataNascimento);
        $interval = $date->diff(new DateTime(date('Y-m-d')));
        return $interval->format('%Y anos');
    }

    /**
     * Busca o último dia de um determinado mês
     */
    public static function getLastDayOfMonth($month, $year)
    {
        return date("Y-m-t", strtotime($year . '-' . $month . '-01'));
    }

    public static function getCurrentDayToExtense()
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        return strftime('%d de %B de %Y', strtotime('today'));
    }

    public static function getMonthsToSelect()
    {
        return [
            ['value' => '01', 'description' => 'JANEIRO'],
            ['value' => '02', 'description' => 'FEVEREIRO'],
            ['value' => '03', 'description' => 'MARÇO'],
            ['value' => '04', 'description' => 'ABRIL'],
            ['value' => '05', 'description' => 'MAIO'],
            ['value' => '06', 'description' => 'JUNHO'],
            ['value' => '07', 'description' => 'JULHO'],
            ['value' => '08', 'description' => 'AGOSTO'],
            ['value' => '09', 'description' => 'SETEMBRO'],
            ['value' => '10', 'description' => 'OUTUBRO'],
            ['value' => '11', 'description' => 'NOVEMBRO'],
            ['value' => '12', 'description' => 'DEZEMBRO'],
        ];
    }

    public static function getMonthDescription($code)
    {
        switch ($code) {
            case 1:
                return 'JANEIRO';
                break;
            case 2:
                return 'FEVEREIRO';
                break;
            case 3:
                return 'MARÇO';
                break;
            case 4:
                return 'ABRIL';
                break;
            case 5:
                return 'MAIO';
                break;
            case 6:
                return 'JUNHO';
                break;
            case 7:
                return 'JULHO';
                break;
            case 8:
                return 'AGOSTO';
                break;
            case 9:
                return 'SETEMBRO';
                break;
            case 10:
                return 'OUTUBRO';
                break;
            case 11:
                return 'NOVEMBRO';
                break;
            case 12:
                return 'DEZEMBRO';
                break;

            default:
                return '';
                break;
        }
    }

}
