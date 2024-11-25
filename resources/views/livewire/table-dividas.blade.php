<div class="card card-primary card-outline">
    <div class="card-body mb-n2">
        <div class="row mb-4">
            <div class="col-sm-1">
                <label>Pag</label>
                <select wire:model="perPage" class="form-control selectCustom">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Busca pelo Serviço</label>
                <input wire:model.debounce.300ms="searchServico" type="text" class="form-control"
                    placeholder="ex: MEDICO...">
            </div>

            <div class="col-md-4">
                <label>Busca pela Descrição</label>
                <input wire:model.debounce.300ms="searchDescricao" type="text" class="form-control"
                    placeholder="ex: EXAME...">
            </div>

            <div class="col-sm-1">
                <label>Status</label>
                <select wire:model="status" class="form-control selectCustom">
                    <option></option>
                    <option>ABERTA</option>
                    <option>ENCERRADA</option>
                </select>
            </div>

            <div class="col-sm-1">
                <label>Tipo</label>
                <select wire:model="tipo" class="form-control selectCustom">
                    <option></option>
                    <option value="P">PARCELADA</option>
                    <option value="C">CORRENTE</option>
                </select>
            </div>

            <div class="col-sm-1">
                <label>Limpar</label><br>
                <a wire:click="cleanFilters()" href="" title="Limpar Filtros" style="width: 100%;"
                    class="btn btn-outline-primary"><i class="fas fa-redo-alt"></i></a>
            </div>

        </div>

        @include('partials.spinner')

        <div class="table-responsive">
            <table style="padding: .3rem;" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th wire:click="sortBy('tiposervico')" style="text-align: left; width: 10%; cursor: pointer;">
                            <i class="fas fa-notes-medical"></i>
                            Serviço
                            @include('partials._sort-icon', ['field' => 'tiposervico'])
                        </th>
                        <th wire:click="sortBy('servico')" style="text-align: left; width: 30%; cursor: pointer;">
                            <i class="fas fa-file-medical"></i>
                            Descrição
                            @include('partials._sort-icon', ['field' => 'servico'])
                        </th>
                        <th wire:click="sortBy('datainscricao')" style="text-align: left; width: 10%; cursor: pointer;">
                            <i class="far fa-calendar-alt"></i>
                            Dt Insc
                            @include('partials._sort-icon', ['field' => 'datainscricao'])
                        </th>
                        <th wire:click="sortBy('originalcorrigido')"
                            style="text-align: left; width: 10%; cursor: pointer;"><i class="fas fa-dollar-sign"></i>
                            Inscrito
                            @include('partials._sort-icon', ['field' => 'originalcorrigido'])
                        </th>
                        <th wire:click="sortBy('cancelado')" style="text-align: left; width: 10%; cursor: pointer;"><i
                                class="fas fa-dollar-sign"></i>
                            Cancelado
                            @include('partials._sort-icon', ['field' => 'cancelado'])
                        </th>
                        <th wire:click="sortBy('pago')" style="text-align: left; width: 10%; cursor: pointer;"><i
                                class="fas fa-dollar-sign"></i> Pago
                            @include('partials._sort-icon', ['field' => 'pago'])
                        </th>
                        <th wire:click="sortBy('saldo')" style="text-align: left; width: 10%; cursor: pointer;"><i
                                class="fas fa-dollar-sign"></i> Saldo
                            @include('partials._sort-icon', ['field' => 'saldo'])
                        </th>
                        <th wire:click="sortBy('status')" style="text-align: left; width: 10%; cursor: pointer;"><i
                                class="fas fa-check"></i> Status
                            @include('partials._sort-icon', ['field' => 'status'])
                        </th>
                        <th wire:click="sortBy('tipo')" style="text-align: left; width: 10%; cursor: pointer;"><i
                                class="fas fa-list"></i> Tipo
                            @include('partials._sort-icon', ['field' => 'tipo'])
                        </th>
                </thead>

                <tbody>

                    @foreach($dividas as $item)
                    <tr>
                        <td style="text-align: left;">{{ $item->tiposervico }}</td>
                        <td style="text-align: left;">{{ $item->servico }}</td>
                        <td style="text-align: center;">{{ date('d/m/Y', strtotime($item->datainscricao)) }}</td>
                        <td style="text-align: right;">{{ 'R$ ' . number_format($item->originalcorrigido, 2, ',','.') }}
                        </td>
                        <td style="text-align: right;">{{ 'R$ ' . number_format($item->cancelado, 2, ',','.') }}</td>
                        <td style="text-align: right;">{{ 'R$ ' . number_format($item->pago, 2, ',','.') }}</td>
                        <td style="text-align: right;">{{ 'R$ ' . number_format($item->saldo, 2, ',','.') }}</td>
                        <td style="text-align: center;">
                            @if( $item->saldo != 0)
                            <span style="width: 90px; height: 20px; font-size: 12px;"
                                class="badge bg-danger float-center">ABERTA</span>
                            @else
                            <span style="width: 90px; height: 20px; font-size: 12px;"
                                class="badge bg-secondary float-center">ENCERRADA</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if( $item->tipo == "P" )
                            <span style="width: 90px; height: 20px; font-size: 12px;"
                                class="badge bg-warning float-center">PARCELADA</span>
                            @else
                            <span style="width: 90px; height: 20px; font-size: 12px;"
                                class="badge bg-info float-center">CORRENTE</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            @if ($dividas->isEmpty())
            <div class="d-flex justify-content-center">
                Nenhum registro encontrado.
            </div>
            @else
            <div class="d-flex mb-3">
                <div class="mr-auto">
                    <p>
                        Mostrando de {{ $dividas->firstItem()}} até {{ $dividas->lastItem() }} de
                        {{ $dividas->total() }}
                        registros.
                    </p>
                </div>
                <div class="p-2">
                    <p>
                        {{ $dividas->links() }}
                    </p>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Resumo</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-sm-6 p-2">
                <h6><strong>DÍVIDA CORRENTE</h6>
            </div>
        </div>
        <div class="row mb-3 mt-n3">
            <div class="col-sm-3">
                <label>Inscrito</label>
                <h6 class="form-control bg-lightblue text-right">R$ {{number_format($devidoCorrente, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Cancelado</label>
                <h6 class="form-control bg-secondary text-right">R$ {{number_format($canceladoCorrente, 2, ',','.')}}
                </h6>
            </div>
            <div class="col-sm-3">
                <label>Pago</label>
                <h6 class="form-control bg-teal text-right">R$ {{number_format($pagoCorrente, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Saldo</label>
                <h6 class="form-control bg-info text-right">R$ {{number_format($saldoCorrente, 2, ',','.')}}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 p-2">
                <h6><strong>DÍVIDA PARCELADA</h6>
            </div>
        </div>
        <div class="row mb-3 mt-n3">
            <div class="col-sm-3">
                <label>Inscrito</label>
                <h6 class="form-control bg-lightblue text-right">R$ {{number_format($devidoParcelado, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Cancelado</label>
                <h6 class="form-control bg-secondary text-right">R$ {{number_format($canceladoParcelado, 2, ',','.')}}
                </h6>
            </div>
            <div class="col-sm-3">
                <label>Pago</label>
                <h6 class="form-control bg-teal text-right">R$ {{number_format($pagoParcelado, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Saldo</label>
                <h6 class="form-control bg-info text-right">R$ {{number_format($saldoParcelado, 2, ',','.')}}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 p-2">
                <h6><strong>TOTAL (CORRENTE + PARCELADA)</h6>
            </div>
        </div>
        <div class="row mb-3 mt-n3">
            <div class="col-sm-3">
                <label>Inscrito</label>
                <h6 class="form-control bg-lightblue text-right">R$
                    {{number_format($devidoCorrente + $devidoParcelado, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Cancelado</label>
                <h6 class="form-control bg-secondary text-right">R$
                    {{number_format($canceladoCorrente + $canceladoParcelado, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Pago</label>
                <h6 class="form-control bg-teal text-right">R$
                    {{number_format($pagoCorrente + $pagoParcelado, 2, ',','.')}}</h6>
            </div>
            <div class="col-sm-3">
                <label>Saldo</label>
                <h6 class="form-control bg-info text-right">R$
                    {{number_format($saldoCorrente + $saldoParcelado, 2, ',','.')}}</h6>
            </div>
        </div>
    </div>
</div>