@extends('reports.page')

@section('header')
@include('partials.reports.header-crp')
@endsection

@section('content')
<br><br>
<table class="content">
    <thead>
        <tr>
            <th style="font-size: 11px; text-align: left;">1. FONTE PAGADORA - PESSOA JURÍDICA
            </th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td style="width: 75%;" class="border-top border-left padding-left">
                Nome empresarial
            </td>
            <td style="width: 25%;" class="border-top border-right border-left padding-left">
                CNPJ
            </td>
        </tr>
        <tr>
            <td style="width: 75%;" class="border-left border-bottom padding-left">
                {{ session('clientName') }}
            </td>
            <td style="width: 25%;" class="border-right border-bottom border-left padding-left">
                {{ session('clientCnpj') }}
            </td>
        </tr>
    </tbody>
</table>

<br><br>

<table class="content">
    <thead>
        <tr>
            <th colspan="2" style="font-size: 11px; text-align: left;">2. PESSOA FÍSICA BENEFICIÁRIA DOS RENDIMENTOS
            </th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            {{-- <td style="width: 15%;" class="border-top border-right border-left padding-left">
                Contrato
            </td> --}}
            <td style="width: 75%;" class="border-top border-left padding-left">
                Nome Completo
            </td>
            <td style="width: 25%;" class="border-top border-left border-right border-left padding-left">
                CPF
            </td>
        </tr>
        <tr>
            {{-- <td style="width: 15%;" class="border-left border-right border-bottom padding-left">
                {{ str_pad($idcontrato, 5, "0", STR_PAD_LEFT) }}
            </td> --}}
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
            <th colspan="2" style="font-size: 11px; text-align: left;">3. RENDIMENTOS TRIBUTÁVEIS, DEDUÇÕES E IMPOSTO
                SOBRE A RENDA RETIDO NA
                FONTE
            </th>
            <th style="font-size: 11px; text-align: left;">Valores em reais</th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td colspan="2" style="width: 75%;" class="border-top border-left padding-left">
                1. Total de rendimentos (inclusive férias)
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-top padding-left padding-right">
                {{-- {{ number_format($rendimento, 2, ',','.') }} --}}
                {{ $rendimento }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                2. Contribuição previdenciária oficial
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($previdencia, 2, ',','.') }} --}}
                {{ $previdencia }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                3. Contribuições a entidades de previdência complementar e a fundos de aposentadoria prog. individual
                (FAPI)
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($complementar, 2, ',','.') }} --}}
                {{ $complementar }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                4. Pensão alimentícia
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($pensao, 2, ',','.') }} --}}
                {{ $pensao }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left border-bottom padding-left">
                5. Imposto sobre a renda retido na fonte
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-bottom padding-left padding-right">
                {{-- {{ number_format($irrf, 2, ',','.') }} --}}
                {{ $irrf }}
            </td>
        </tr>

    </tbody>
</table>

<br><br>
<table class="content">
    <thead>
        <tr>
            <th colspan="2" style="font-size: 11px; text-align: left;">4. RENDIMENTOS ISENTOS E NÃO TRIBUTÁVEIS
            </th>
            <th style="font-size: 11px; text-align: left;">Valores em reais</th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td colspan="2" style="width: 75%;" class="border-top border-left padding-left">
                1. Parcela isenta dos proventos de aposentadoria, reserva remunerada, reforma e pensão (65 anos ou mais), exceto a parcela isenta do 13º
                (décimo terceiro) salário
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-top padding-left padding-right">
                {{-- {{ number_format($isento, 2, ',','.') }} --}}
                {{ $isento }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                2. Parcela isenta dos proventos de aposentadoria, reserva remunerada, reforma e pensão (65 anos ou mais)
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($isento, 2, ',','.') }} --}}
                {{ $isento2 }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                3. Diárias e ajuda de custo
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($diaria, 2, ',','.') }} --}}
                {{ $diaria }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                4. Pensão e proventos de aposentado ou reforma por moléstia grave; proventos de aposentado ou reforma
                por acidente
                em serviço
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($molestia, 2, ',','.') }} --}}
                {{ $molestia }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                5. Lucros e dividendos, apurados a partir de 1996, pagos por pessoa jurídica (lucro real, presumido ou
                arbitrado)
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($dividendo, 2, ',','.') }} --}}
                {{ $dividendo }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                6. Valores pagos ao titular ou sócio de microempresa ou empresa de pequeno porte, exceto por prolabore,
                aluguéis ou
                serviços prestados
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($pagamento, 2, ',','.') }} --}}
                {{ $pagamento }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                7. Indenizações por rescisão de contrato de trabalho, inclusive a título de PDV, e por acidente de
                trabalho
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($indenizacao, 2, ',','.') }} --}}
                {{ $indenizacao }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                8. Juros de mora recebidos, devidos pelo atraso no pagamento de remuneração por exercício de emprego, cargo ou função
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($abono, 2, ',','.') }} --}}
                {{ $juros }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left border-bottom padding-left">
                9. Outros
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-bottom padding-left padding-right">
                {{-- {{ number_format($abono, 2, ',','.') }} --}}
                {{ $abono }}
            </td>
        </tr>

    </tbody>
</table>

<br><br>
<table class="content">
    <thead>
        <tr>
            <th colspan="2" style="font-size: 11px; text-align: left;">5. RENDIMENTOS SUJEITOS A TRIBUTAÇÃO EXCLUSIVA
                (RENDIMENTO LÍQUIDO)
            </th>
            <th style="font-size: 11px; text-align: left;">Valores em reais</th>
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td colspan="2" style="width: 75%;" class="border-top border-left padding-left">
                1. Décimo terceiro salário
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-top padding-left padding-right">
                {{-- {{ number_format($decimo, 2, ',','.') }} --}}
                {{ $decimo }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                2. Imposto sobre a renda retido na fonte sobre o 13º salário
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($irrfdecimo, 2, ',','.') }} --}}
                {{ $irrfdecimo }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left border-bottom padding-left">
                3. Outros
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left border-bottom padding-left padding-right">
                {{-- {{ number_format($outro, 2, ',','.') }} --}}
                {{ $outro }}
            </td>
        </tr>
    </tbody>
</table>

<br><br>
<table class="content">
    <thead>
        <tr>
            <th colspan="3" style="font-size: 11px; text-align: left;">6. RENDIMENTOS RECEBITOS ACUMULADAMENTE - Art.
                12-A Lei nº
                7.713, de 1988 (sujeitos à tributação exclusiva)
            </th>
            {{-- <th style="font-size: 11px; text-align: left;">Valores em reais</th> --}}
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td style="width: 40%;" class="border-left border-top padding-left">
                6.1. Número do processo: (especificar)
            </td>
            <td style="width: 35%;" class="border-top padding-left">
                Quantidade de meses: {{ $rra_meses }}
            </td>
            <td class="border-left">

            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left border-bottom padding-left bg-gray">
                Natureza do Rendimento: (especificar)
            </td>
            <td style="width: 25%; font-size: 11px;" class="border-left border-bottom padding-left">
                <strong>Valores em reais</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                1. Total dos rendimentos tributáveis (inclusive férias e décimo terceiro salário)
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($rra_rendimento, 2, ',','.') }} --}}
                {{ $rra_rendimento }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                2. Exclusão: Despesas com a ação judicial
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($rra_judicial, 2, ',','.') }} --}}
                {{ $rra_judicial }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                3. Dedução: Contribuição previdenciária oficial
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($rra_previdencia, 2, ',','.') }} --}}
                {{ $rra_previdencia }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left">
                4. Dedução: Pensão alimentícia
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right">
                {{-- {{ number_format($rra_pensao, 2, ',','.') }} --}}
                {{ $rra_pensao }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left padding-left bg-gray">
                5. Imposto sobre a renda retido na fonte
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right bg-gray">
                {{-- {{ number_format($rra_irrf, 2, ',','.') }} --}}
                {{ $rra_irrf }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width: 75%;" class="border-left border-bottom padding-left">
                6. Rendimentos isentos de pensão, proventos de aposentadoria ou reforma por moléstia grave ou
                aposentadoria ou reforma por acidente em serviço
            </td>
            <td style="width: 25%; text-align: right;" class="border-right border-left padding-left padding-right border-bottom">
                {{-- {{ number_format($rra_isento, 2, ',','.') }} --}}
                {{ $rra_isento }}
            </td>
        </tr>
    </tbody>
</table>

<br><br>
<table class="content">
    <thead>
        <tr>
            <th colspan="2" style="font-size: 11px; text-align: left;">7. INFORMAÇÕES COMPLEMENTARES
            </th>
            {{-- <th style="font-size: 11px; text-align: left;">Valores em reais</th> --}}
        </tr>
    </thead>
    <tbody style="font-size: 10px;">
        <tr>
            <td colspan="6" style="width: 75%;" class="border-left border-right border-top border-bottom padding-left">
                <table class="content">
                    <tbody>
                        @foreach ($complementares as $item)
                        {{-- <tr>  --}}
                        @if ($loop->index < count($complementares) - 1) <td>
                            {{ $item }}
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
</td>
</tr>
</tbody>
</table>
{{-- <div style="margin-top: 50px; margin-left: 30%;">
    <p>________________________________________________________________</p>
</div> --}}
@endsection



@section('footer')
@include('partials.reports.footer')
@endsection

<style>

</style>
