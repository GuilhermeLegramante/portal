<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComprovanteDespesasMedicasController extends Controller
{
    public function view()
    {
        return view('auth.comprovante-despesas-medicas');
    }
}
