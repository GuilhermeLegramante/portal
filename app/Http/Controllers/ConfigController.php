<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    public function index($serverName, $dbName)
    {
        // $this->admin('admin', $serverName, $dbName);

        config('DB_HOST', $serverName);
        config('DB_DATABASE', $dbName);

        return 'Configuração realizada com sucesso!';
    }

    public function admin($value, $serverName, $dbName)
    {
        $base = dirname(__DIR__, 4);

        $path = $base . '\\' . $value . '\.env';


        


    }

  
}
