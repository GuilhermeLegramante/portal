<?php

namespace App\Http\Livewire;

use App\Repositories\DividaRepository;
use App\Services\CustomPaginator;
use Livewire\Component;
use Session;

class TableDividas extends Component
{
    private $dividaRepository;
    public $sortBy = 'datainscricao';
    public $sortDirection = 'desc';
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $searchDescricao = '';
    public $searchServico = '';
    public $status = '';
    public $tipo = '';

    public function render()
    {
        $this->dividaRepository = new DividaRepository();

        $this->searchDescricao = strtoupper($this->searchDescricao);
        $this->searchServico = strtoupper($this->searchServico);

        $data = $this->dividaRepository->getAll(Session::get('idmunicipe'));

        if (count($data) == 0) {
            session()->flash('error', 'O Munícipe não possui dívidas cadastradas.');
            return view('auth.painel');
        } else {
            $devidoCorrente = $this->totalByColumn($data, 'C', 'originalcorrigido');
            $devidoParcelado = $this->totalByColumn($data, 'P', 'originalcorrigido');

            $canceladoCorrente = $this->totalByColumn($data, 'C', 'cancelado');
            $canceladoParcelado = $this->totalByColumn($data, 'P', 'cancelado');

            $pagoCorrente = $this->totalByColumn($data, 'C', 'pago');
            $pagoParcelado = $this->totalByColumn($data, 'P', 'pago');

            $saldoCorrente = $this->totalByColumn($data, 'C', 'saldo');
            $saldoParcelado = $this->totalByColumn($data, 'P', 'saldo');

            if ($this->sortDirection == 'asc') {
                $dividas = $data->sortBy($this->sortBy);
            } else {
                $dividas = $data->sortByDesc($this->sortBy);
            }

            if ($this->searchServico != '') {
                $searchServico = strtoupper($this->searchServico);

                $dividas = $dividas->reject(function ($item) use ($searchServico) {
                    return mb_strpos($item->tiposervico, $searchServico) === false;
                });
            }

            if ($this->searchDescricao != '') {
                $searchDescricao = strtoupper($this->searchDescricao);

                $dividas = $dividas->reject(function ($item) use ($searchDescricao) {
                    return mb_strpos($item->descricao, $searchDescricao) === false;
                });
            }

            if ($this->status != '') {
                $status = $this->status;

                $dividas = $dividas->where('status', $status);
            }

            if ($this->tipo != '') {
                $tipo = $this->tipo;

                $dividas = $dividas->where('tipo', $tipo);
            }

            $dividas = CustomPaginator::paginate($dividas, $this->perPage, null, ['path' => env('PAGINATE_URL_DIVIDAS')]);

            return view('livewire.table-dividas', compact('dividas', 'devidoCorrente', 'devidoParcelado',
                'canceladoCorrente', 'canceladoParcelado', 'pagoCorrente',
                'pagoParcelado', 'saldoCorrente', 'saldoParcelado'));
        }
    }

    // Recebe os dados, tipo (C ou P para Corrente ou Parcelado) e qual parâmetro (column) vai ser somado
    public function totalByColumn($data, $type, $column)
    {
        $collection = $data->where('tipo', $type);

        $sum = $collection->sum($column);

        return $sum;
    }

    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }

    public function cleanFilters()
    {
        $this->perPage = 10;
        $this->searchDescricao = '';
        $this->searchServico = '';
        $this->status = '';
        $this->tipo = '';
    }
}
