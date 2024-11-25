<?php

namespace App\Repositories;

use DB;
use Session;

class ClienteRepository
{

    public function getData()
    {
        try {
            return DB::table('hscad_dadosempresa')
                ->join('hscad_logradouros', 'hscad_logradouros.id', '=', 'hscad_dadosempresa.idlogradouro')
                ->where('hscad_dadosempresa.id', '=', 1)
                ->select(
                    'hscad_dadosempresa.nome_empresa',
                    'hscad_dadosempresa.numero',
                    'hscad_dadosempresa.identificador',
                    'hscad_dadosempresa.cnpj',
                    'hscad_dadosempresa.email',
                    'hscad_logradouros.nome AS logradouro'
                )
                ->get()
                ->first();
        } catch (\Exception $error) {
            dd($error->getMessage());
        }
    }

    public function setSessionFol2()
    {
        $database = DB::connection()->getDatabaseName();

        $fol2 = '%hsfol2_%';
        $verificaFol2 = DB::select('SELECT 1 FROM INFORMATION_SCHEMA.TABLES tbl WHERE tbl.`TABLE_NAME`
        LIKE ? AND `TABLE_SCHEMA` = ? LIMIT 1', [$fol2, $database]);

        if ($verificaFol2 == null) {
            Session::put('fol2', false);
        }

        if ($verificaFol2 != null) {
            Session::put('fol2', true);
        }
    }

    public static function getAllowedMenus()
    {
        return DB::table('adm_rota')->where('liberado', 1)->where('menu', 1)->get();
    }

}
