<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ClientRepository
{
    public static function getAllowedMenus()
    {
        return DB::table('adm_rota')->where('liberado', 1)->where('menu', 1)->get();
    }
}
