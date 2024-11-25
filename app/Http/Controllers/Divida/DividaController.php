<?php

namespace App\Http\Controllers\Divida;

use App\Http\Controllers\Controller;
use App\Repositories\DividaRepository;
use App\Repositories\MunicipeRepository;
use App\Services\ReportFactory;

class DividaController extends Controller
{
    private $dividaRepository;
    private $reportFactory;
    private $municipeRepository;

    public function __construct(DividaRepository $dividaRepo, ReportFactory $reportFac, MunicipeRepository $municipeRepo)
    {
        $this->dividaRepository = $dividaRepo;
        $this->reportFactory = $reportFac;
        $this->municipeRepository = $municipeRepo;
    }

    public function index()
    {
        return view('tables.dividas');
    }

    public function getBasicReport($id, $tipo)
    {
        $dividas = $this->dividaRepository->getAll($id);

        if ($id != session('inscricao')) {
            return redirect('/')->with('error', 'Permissão de acesso negada.');
        }

        $devidoCorrente = $this->totalByColumn($dividas, 'C', 'originalcorrigido');
        $devidoParcelado = $this->totalByColumn($dividas, 'P', 'originalcorrigido');

        $canceladoCorrente = $this->totalByColumn($dividas, 'C', 'cancelado');
        $canceladoParcelado = $this->totalByColumn($dividas, 'P', 'cancelado');

        $pagoCorrente = $this->totalByColumn($dividas, 'C', 'pago');
        $pagoParcelado = $this->totalByColumn($dividas, 'P', 'pago');

        $saldoCorrente = $this->totalByColumn($dividas, 'C', 'saldo');
        $saldoParcelado = $this->totalByColumn($dividas, 'P', 'saldo');

        if ($tipo == 'geral') {
            $fileName = $id . '_dividas-segurado-relatorio-basico';
            $title = 'LISTAGEM GERAL DAS DIVIDAS';
        }
        if ($tipo == 'correntes') {
            $dividas = $dividas->where('tipo', 'C');
            $fileName = $id . '_dividas-correntes-segurado-relatorio-basico';
            $title = 'LISTAGEM DAS DIVIDAS CORRENTES';
        }
        if ($tipo == 'parceladas') {
            $dividas = $dividas->where('tipo', 'P');
            $fileName = $id . '_dividas-parceladas-segurado-relatorio-basico';
            $title = 'LISTAGEM DAS DIVIDAS PARCELADAS';
        }

        $view = 'reports.dividas.list';

        $args = [
            'tipo' => $tipo,
            'title' => $title,
            'dividas' => $dividas,
            'devidoCorrente' => $devidoCorrente,
            'devidoParcelado' => $devidoParcelado,
            'canceladoCorrente' => $canceladoCorrente,
            'canceladoParcelado' => $canceladoParcelado,
            'pagoCorrente' => $pagoCorrente,
            'pagoParcelado' => $pagoParcelado,
            'saldoCorrente' => $saldoCorrente,
            'saldoParcelado' => $saldoParcelado,

        ];

        return $this->reportFactory->getBasicPdf('landscape', $view, $args, $fileName);
    }

    // Recebe os dados, tipo (C ou P para Corrente ou Parcelado) e qual parâmetro (column) vai ser somado
    public function totalByColumn($data, $type, $column)
    {
        $collection = $data->where('tipo', $type);

        $sum = $collection->sum($column);

        return $sum;
    }

    public function crpView()
    {
        return view('auth.crp');
    }

    public function unregisteredDebt()
    {
        return view('parent.unregistered-debt');
    }

}
