<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlteraDadosUsuarioRequest;
use DB;

class UsuarioController extends Controller
{
    public function edicaoDadosUsuario(AlteraDadosUsuarioRequest $request)
    {
        DB::beginTransaction();
        try {
            $senha = strtoupper($request->senha);
            $update = DB::table('hsglb_usuarios')
                ->where('IDUSUARIO', $_SESSION['idusuario'])
                ->update([
                    'NOMEUSUARIO' => $request->nome,
                    'LOGIN' => $request->login,
                    'EMAIL' => $request->email,
                    'SENHAWEB' => sha1($senha),
                ]);
            DB::commit();
        } catch (\Illuminate\Database\QueryException $error) {
            DB::rollback();
            dd($error->getMessage());
        }

        return redirect()->route('portal')->with('success', 'Dados atualizados com sucesso!');

    }
}
