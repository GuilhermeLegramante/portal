@extends('reports.page')

@section('header')
@include('includes.reports.header')
@endsection

@section('content')
<table id="content">
    <thead>
        <tr>
            <th class="item-head text-center w-10">Serviço</th>
            <th class="item-head text-center w-30">Descrição</th>
            <th class="item-head text-center w-10">Dt Insc</th>
            <th class="item-head text-center w-10">Inscrito</th>
            <th class="item-head text-center w-10">Cancelado</th>
            <th class="item-head text-center w-10">Pago</th>
            <th class="item-head text-center w-10">Saldo</th>
            <th class=" {{$tipo != 'geral' ? 'item-head' : 'last-item-head'}} text-center w-10">Status</th>
            <th class="last-item-head text-center w-10">Tipo</th>
        </tr>
    </thead>
    <tbody>
        @php $color = false; @endphp

        @foreach ($dividas as $item)
        <tr style="background-color: {{ $color ? '#EEEEEE' : '#FFFFFF' }}">
            <td class="text-center">{{ $item->tiposervico }}</td>
            <td class="text-left pl-5px">{{ $item->servico }}</td>
            <td class="text-center">{{ date('d/m/Y', strtotime($item->datainscricao)) }}</td>
            <td class="text-right">{{ 'R$ ' . number_format($item->originalcorrigido, 2, ',','.') }}
            </td>
            <td class="text-right">{{ 'R$ ' . number_format($item->cancelado, 2, ',','.') }}</td>
            <td class="text-right">{{ 'R$ ' . number_format($item->pago, 2, ',','.') }}</td>
            <td class="text-right">{{ 'R$ ' . number_format($item->saldo, 2, ',','.') }}</td>
            <td class="text-center">{{ $item->tipo == "P" ? 'PARCELADA' : 'CORRENTE' }}</td>
            <td class="text-center">{{ $item->status }}</td>
        </tr>

        @php $color = !$color; @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="9" style="border-top: 1px solid #000000;"></th>
        </tr>
        <tr>
            <th class="item-head text-left w-10" colspan="3" style="text-align: right; padding-right: 5px;">
                Total:
            </th>
            <th class="item-head text-center w-10" colspan="1" style="text-align: right; padding-right: 5px;">R$
                @if($tipo == 'geral')
                {{ number_format($devidoCorrente + $devidoParcelado, 2, ',','.')  }}
                @endif
                @if($tipo == 'correntes')
                {{ number_format($devidoCorrente, 2, ',','.')  }}
                @endif
                @if($tipo == 'parceladas')
                {{ number_format($devidoParcelado, 2, ',','.')  }}
                @endif
            </th>
            <th class="item-head text-center w-10" colspan="1" style="text-align: right; padding-right: 5px;">R$
                @if($tipo == 'geral')
                {{ number_format($canceladoCorrente + $canceladoParcelado, 2, ',','.') }}
                @endif
                @if($tipo == 'correntes')
                {{ number_format($canceladoCorrente, 2, ',','.') }}
                @endif
                @if($tipo == 'parceladas')
                {{ number_format($canceladoParcelado, 2, ',','.') }}
                @endif
            </th>
            <th class="item-head text-center w-10" colspan="1" style="text-align: right; padding-right: 5px;">R$
                @if($tipo == 'geral')
                {{ number_format($pagoCorrente + $pagoParcelado, 2, ',','.') }}
                @endif
                @if($tipo == 'correntes')
                {{ number_format($pagoCorrente, 2, ',','.') }}
                @endif
                @if($tipo == 'parceladas')
                {{ number_format($pagoParcelado, 2, ',','.') }}
                @endif
            </th>
            <th class="item-head text-center w-10" colspan="1" style="text-align: right; padding-right: 5px;">R$
                @if($tipo == 'geral')
                {{ number_format($saldoCorrente + $saldoParcelado, 2, ',','.') }}
                @endif
                @if($tipo == 'correntes')
                {{ number_format($saldoCorrente, 2, ',','.') }}
                @endif
                @if($tipo == 'parceladas')
                {{ number_format($saldoParcelado, 2, ',','.') }}
                @endif
            </th>
            <th class="last-item-head text-right w-10" colspan="2">
                Registros: {{ $dividas->count() }}
            </th>
        </tr>
        <tr>
            <th colspan="9" class="text-left">
                OBS: Dados meramente informativos, sem valor comprobatório.
            </th>
        </tr>
    </tfoot>
   
</table>
@endsection

@section('footer')
@include('includes.reports.footer')
@endsection