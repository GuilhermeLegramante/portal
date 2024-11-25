<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\WithDatatable;
use App\Services\DateService;
use App\Services\Mask;
use App\Services\SessionService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithPagination;

class UnregisteredDebt extends Component
{
    use WithDatatable, WithPagination;

    public $entity;
    public $pageTitle;
    public $icon = 'fas fa-list';
    public $formModalEmitMethod = '';
    public $formType = 'modal';

    public $totalDebts;

    public $month;
    public $year;

    public $months = [];

    public $pageDescription = '<strong>Atenção!</strong> Os atendimentos listados são aqueles que ainda não foram lançados em dívidas,
    por esse motivo, ainda podem sofrer alterações e, portanto, não podem ser usados
    como nenhum tipo de comprovante. <br>
    Esta listagem tem por objetivo a informação ao segurado dos lançamentos que ainda
    estão pendentes para desconto em folha de pagamento.';

    public $headerColumns = [
        [
            'field' => 'id',
            'label' => 'Código',
            'css' => 'text-center w-10',
            'visible' => 'true',
        ],
        [
            'field' => 'codigoProcedimento',
            'label' => 'Código do Procedimento',
            'css' => 'w-15',
            'visible' => false,
        ],
        [
            'field' => 'descricaoProcedimento',
            'label' => 'Descrição do Procedimento',
            'css' => 'w-15',
            'visible' => 'true',
        ],
        [
            'field' => 'dataConsulta',
            'label' => 'Data',
            'css' => 'w-10 text-center',
            'visible' => 'true',
        ],
        [
            'field' => 'nomeConveniado',
            'label' => 'Conveniado',
            'css' => 'w-20',
            'visible' => 'true',
        ],
        [
            'field' => 'nomePaciente',
            'label' => 'Paciente',
            'css' => 'w-20',
            'visible' => false,
        ],
        [
            'field' => 'quantidade',
            'label' => 'Quantidade',
            'css' => 'w-10',
            'visible' => false,
        ],
        [
            'field' => 'valorSegurado',
            'label' => 'Valor Segurado',
            'css' => 'w-20 text-right',
            'visible' => 'true',
        ],
        [
            'field' => 'valorConveniado',
            'label' => 'Valor Conveniado',
            'css' => 'w-20 text-right',
            'visible' => false,
        ],
        [
            'field' => 'valorTotal',
            'label' => 'Valor Total',
            'css' => 'w-20 text-right',
            'visible' => false,
        ],
        // [
        //     'field' => null,
        //     'label' => 'Ações',
        //     'css' => 'text-center w-5',
        //     'visible' => 'true',
        // ],
    ];

    public $bodyColumns = [
        [
            'field' => 'id',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'codigoProcedimento',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => false,
            'editable' => 'false',
        ],
        [
            'field' => 'descricaoProcedimento',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'dataConsulta',
            'type' => 'date',
            'css' => 'text-center',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'nomeConveniado',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'nomePaciente',
            'type' => 'string',
            'css' => 'pl-12px',
            'visible' => false,
            'editable' => 'false',
        ],
        [
            'field' => 'quantidade',
            'type' => 'string',
            'css' => 'text-center',
            'visible' => false,
            'editable' => 'false',
        ],
        [
            'field' => 'valorSegurado',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => 'true',
            'editable' => 'false',
        ],
        [
            'field' => 'valorConveniado',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => 'false',
        ],
        [
            'field' => 'valorTotal',
            'type' => 'monetary',
            'css' => 'text-right',
            'visible' => false,
            'editable' => 'false',
        ],
    ];

    protected $repositoryClass = 'App\Repositories\UnregisteredDebtRepository';

    public function mount()
    {
        $this->hasForm = false;
        $this->entity = '';
        $this->sortDirection = 'desc';
        $this->pageTitle = 'Atendimentos não Inscritos em Dívida';

        SessionService::start();

        // $date = Carbon::now();
        // $this->year = $date->format('Y');
        // $this->month = $date->format('m');

        $this->months = DateService::getMonthsToSelect();
    }

    public function rowButtons(): array
    {
        return [
            // Button::create('Selecionar')
            //     ->method('showForm')
            //     ->class('btn-primary')
            //     ->icon('fas fa-search'),
        ];
    }

    public function render()
    {
        if ($this->month != '' && $this->year != '') {
            $this->search = $this->month . '/' . $this->year;
        }

        $repository = App::make($this->repositoryClass);

        $data = $repository->all($this->search, $this->sortBy, $this->sortDirection, $this->perPage);

        if ($data->total() == $data->lastItem()) {
            $this->emit('scrollTop');
        }

        $this->totalDebts = Mask::money($data->sum('valorSegurado'));

        $buttons = $this->rowButtons();

        $this->reset('search');

        return view('livewire.unregistered-debt', compact('data'));
    }
}
