@extends('reports.page')

@section('header')
@include('partials.reports.header-crp')
@endsection

<style>
    .striped-table tbody tr:nth-of-type(even) {
        background-color: #EEEEEE;
    }

</style>

@section('content')
<br><br>
<table class="content">
    <thead>
        <tr>
            <th style="font-size: 11px; text-align: left;">1. DADOS DA FONTE RECEBEDORA
            </th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td style="width: 75%;" class="border-top border-left padding-left">
                Razão Social
            </td>
            <td style="width: 25%;" class="border-top border-right border-left padding-left">
                CNPJ
            </td>
        </tr>
        <tr>
            <td style="width: 75%;" class="border-left padding-left">
                {{ session('clientName') }}
            </td>
            <td style="width: 25%;" class="border-right border-left padding-left">
                {{ session('clientCnpj') }}
            </td>
        </tr>
        <tr>
            <td style="width: 75%;" class="border-top border-left padding-left">
                Endereço
            </td>
            <td style="width: 25%;" class="border-top border-right border-left padding-left">
                E-mail
            </td>
        </tr>
        <tr>
            <td style="width: 75%;" class="border-left border-bottom padding-left">
                {{ session('clientStreet') . ' ' }} {{ session('clientNumber') . ' ' }}
            </td>
            <td style="width: 25%;" class="border-right border-bottom border-left padding-left">
                {{ session('clientEmail') }}
            </td>
        </tr>
    </tbody>

</table>

<br><br>

<table class="content">
    <thead>
        <tr>
            <th colspan="2" style="font-size: 11px; text-align: left;">2. DADOS DA FONTE PAGADORA
            </th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td style="width: 75%;" class="border-top border-left padding-left">
                Nome Completo
            </td>
            <td style="width: 25%;" class="border-top border-left border-right border-left padding-left">
                CPF
            </td>
        </tr>
        <tr>

            <td style="width: 75%;" class="border-left border-bottom padding-left">
                {{ session('municipeName') }}
            </td>
            <td style="width: 25%;" class="border-right border-bottom border-left padding-left">
                {{ session('municipeCpf') }}
            </td>
        </tr>

    </tbody>
</table>

<br><br>
<table class="content">
    <thead>
        <tr>
            <th colspan="2" style="font-size: 11px; text-align: left;">3. VALORES PAGOS
            </th>
            <th style="font-size: 11px; text-align: left;">Valores em reais</th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td colspan="2" style="width: 75%;" class="border-top border-left padding-left">
                1. Total pago com Assistência em Saúde
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-top padding-left padding-right">
                <strong>
                    {{ $valorContribuicao }}
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                2. Total pago com Gastos Médicos
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                <strong>
                    {{ $valorPago }}
                </strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left border-bottom padding-left">
                3. Valor total de reembolso
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-bottom padding-left padding-right">
                <strong>
                    {{ $valorReembolso }}
                </strong>
            </td>
        </tr>
    </tbody>
</table>

<br><br>
<table class="content">
    <thead>
        <tr>
            <th colspan="4" style="font-size: 11px; text-align: left;">4. Relação de pagamentos (PG) e anular de pagamento (AP) no período
            </th>
        </tr>
    </thead>
</table>
@foreach ($debts as $month)
<table class="content striped-table">
    <thead>
        <tr class="bg-gray">
            <td style="width: 10%; text-align: center;" class="border-top border-bottom border-left padding-left">
                Data
            </td>
            <td style="width: 50%; text-align: left;" class="border-right border-left border-bottom border-top padding-left padding-right">
                Histórico
            </td>
            <td style="width: 5%; text-align: center;" class="border-right border-top border-bottom padding-left padding-right">
                Tipo
            </td>
            <td style="width: 15%; text-align: right;" class="border-right border-top border-bottom padding-left padding-right">
                Valor (R$)
            </td>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        @foreach ($month as $debt)
        <tr>
            <td style="width: 5%; text-align: center;" class="padding-left">
                {{ date('d/m/Y', strtotime($debt->data)) }}
            </td>
            <td style="width: 80%; text-align: left;" class="padding-left padding-right">
                {{ $debt->historico }}
            </td>
            <td style="width: 5%; text-align: center;" class="padding-left padding-right">
                {{ $debt->tipo }}
            </td>
            <td style="width: 5%; text-align: right;" class="padding-left padding-right">
                {{ number_format($debt->valor, 2, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="width: 80%; text-align: right;" class="border-bottom border-left border-top">
                Total pago do segurado no mês:
            </td>
            <td style="width: 15%; text-align: right;" class="border-right border-bottom border-top padding-right">
                {{ number_format($month->sum('valor'), 2, ',', '.') }}
            </td>
        </tr>
    </tfoot>
</table>
<br><br>
@endforeach
<table class="content">
    <tfoot>
        <tr>
            <td colspan="3" style="width: 80%; text-align: right;" class="border-bottom border-left border-top">
                Total de pagamentos do segurado no período:
            </td>
            <td style="width: 15%; text-align: right;" class="border-right border-bottom border-top padding-right">
                {{ $valorPago }}
            </td>
        </tr>
    </tfoot>
</table>

<br><br>


<br><br>


<br><br>


<br><br>

@endsection



@section('footer')
@include('partials.reports.footer')
@endsection

<style>

</style>
