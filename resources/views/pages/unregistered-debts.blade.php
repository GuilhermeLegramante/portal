@extends('template.page')

@section('page_header')
@include('partials.header.default')
@endsection

@section('page_content')

<div class="card card-primary card-outline mt-1">
    <div class="card-header" data-card-widget="collapse">
        <div class="row mt-1">
            <div class="col-md-11">
                <h3 class="card-title cardTitleCustom"><strong>FILTROS</strong>
                </h3>
            </div>
        </div>
        <div class="card-tools mt-n4">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            @include('partials.inputs.select', [
            'columnSize' => 3,
            'label' => 'Mês',
            'model' => 'month',
            'options' => $months,
            ])
            @include('partials.inputs.number', [
            'columnSize' => 3,
            'label' => 'Ano',
            'model' => 'year',
            ])
        </div>
    </div>
</div>

@include('partials.datatables.default')


<div class="row">
    <div class="col-sm-12 text-right">
        <h6> <strong>Valor Total (Segurado): R$ {{ $totalDebts }}</strong></h6>
    </div>
</div>

@include('partials.table.float-menu')
@endsection
