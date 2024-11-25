@extends('adminlte::page')

@section('adminlte_css_pre')
<link rel="icon" href="{{ URL::asset('img/logo.png') }}" type="image/x-icon" />
@stop

@section('title', 'Demonstrativo Mensal')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="far fa-calendar-alt"></i> Contracheque Mensal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                class="fas fa-laptop-house"></i>
                            Meus Dados</a></li>
                    <li class="breadcrumb-item active"><i class="far fa-calendar-alt"></i> Contracheque Mensal</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<form id="" action="{{route('geraPdfMensal')}}" class="form" method="post">
    <!-- Dados enviados no Form -->
    @csrf
    <input type="hidden" name="contrato" value="{{$contrato}}">
    <input type="hidden" name="tipofolha" value="{{$tipofolha}}">
    <input type="hidden" name="mes" value="{{$mes}}">
    <input type="hidden" name="descricaomes" value="{{$descricaomes}}">
    <input type="hidden" name="ano" value="{{$ano}}">
    <input type="hidden" name="totalVencimentos" value="{{$totalVencimentos}}">
    <input type="hidden" name="totalDescontos" value="{{$totalDescontos}}">
    <input type="hidden" name="totalLiquido" value="{{$totalLiquido}}">
    <!-- Fim Dados enviados no Form -->

    @if ($valores == null)
    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <p>{{ $mensagem }}</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12" style="text-align: center;">
                    <a href="{{ url()->previous() }}" title="Voltar" class="btn btn-info"><i
                            class="fas fa-chevron-left"></i> Voltar</a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-body">

            <!-- primeira linha -->
            <div style="background: #e9ecef; margin-bottom: -8px;" class="row">
                <div style="text-align: center;" class="col-sm-1 left">
                    <div class="form-group left">
                        <label>Contrato</label>
                        <h3>{{$servidor[0]->matricula}}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Nome</label>
                        <h3>{{$servidor[0]->nome}}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Tipo de Folha - Referência</label>
                        <h3>{{$valores[0]->desc_tipofolha}} - {{$descricaomes}}/{{$ano}}</h3>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>Função</label>
                        <h3>{{$servidor[0]->desc_funcao}}</h3>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Lotação</label>
                        <h3>{{$servidor[0]->desc_lotacao}}</h3>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->
        </div>
    </div>

    <!-- Card Informações Pagamento -->
    <div class="card">
        <div class="card-body">
            <!-- cabeçalho -->
            <div class="row esconder">
                <div style="text-align: center;" class="col-sm-1">
                    <div class="form-group">
                        <label>Código</label>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <label>Descrição</label>
                    </div>
                </div>
                <div style="text-align: right;" class="col-sm-2">
                    <div class="form-group">
                        <label>Referência</label>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div style="text-align: right;" class="form-group">
                        <label>Valor</label>
                    </div>
                </div>
            </div>
            <!-- fim cabeçalho -->

            <!-- Vencimentos -->
            @if(isset($vencimentos))
            @foreach ($vencimentos as $vencimento)
            <div class="row esconder">
                <div class="col-sm-1">
                    <div class="form-group">
                        <input style="text-align: center;" type="text" class="form-control"
                            value="{{$vencimento->codigo}}" disabled>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$vencimento->desc_evento}}" disabled>
                    </div>
                </div>
                <div style="text-align: right;" class="col-sm-2">
                    <div class="form-group">
                        <input style="text-align: right;" type="text" class="form-control"
                            value="{{number_format($vencimento->referencia, 2, ',', '.')}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <input style="background: #28a748; color: white; text-align: right;" type="text"
                            class="form-control" value="{{number_format($vencimento->valor, 2, ',', '.')}}" disabled>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <!-- fim Vencimentos -->

            <!-- Descontos -->
            @if(isset($descontos))
            @foreach ($descontos as $desconto)
            <div class="row esconder">
                <div class="col-sm-1">
                    <div class="form-group">
                        <input style="text-align: center;" type="text" class="form-control"
                            value="{{$desconto->codigo}}" disabled>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$desconto->desc_evento}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <input style="text-align: right;" type="text" class="form-control"
                            value="{{number_format($desconto->referencia, 2, ',', '.')}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <input style="background: #cf3f3f; color: white; text-align: right;" type="text"
                            class="form-control" value="{{number_format($desconto->valor, 2, ',', '.')}}" disabled>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <!-- fim Descontos -->

            <!-- Bases -->
            @if(isset($bases))
            @foreach ($bases as $base)
            <div class="row esconder">
                <div class="col-sm-1">
                    <div class="form-group">
                        <input style="text-align: center;" type="text" class="form-control" value="{{$base->codigo}}"
                            disabled>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{$base->desc_evento}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <input style="text-align: right;" type="text" class="form-control"
                            value="{{number_format($base->referencia, 2, ',', '.')}}" disabled>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <input style="background: gray; color: white; text-align: right;" type="text"
                            class="form-control" value="{{number_format($base->valor, 2, ',', '.')}}" disabled>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <!-- fim Bases -->

            <div class="row">
                <div class="col-sm-4">
                    <div style="text-align: right;" class="form-group">
                        <label>Total Vencimentos</label>
                        <input style="text-align: right;" type="text" class="form-control"
                            value="{{'R$ '.number_format($totalVencimentos, 2, ',', '.')}}" disabled>
                    </div>
                </div>
                <div style="text-align: right;" class="col-sm-4">
                    <div class="form-group">
                        <label>Total Descontos</label>
                        <input style="text-align: right;" type="text" class="form-control"
                            value="{{'R$ '.number_format($totalDescontos, 2, ',', '.')}}" disabled>
                    </div>
                </div>
                <div style="text-align: right;" class="col-sm-4">
                    <div class="form-group">
                        <label>Total Líquido</label>
                        <input id="valor" style="text-align: right;" type="text" class="form-control"
                            value="{{'R$ '.number_format($totalLiquido, 2, ',', '.')}}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Card Informações Pagamento -->

    <div class="card">
        {{-- <div class="card-body">
            <div class="row">
                <div class="col-sm-12" style="text-align: center;">
                    <button type="submit" class="btn btn-outline-info btn-sm" style="width: 20%;">
                        GERAR PDF
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12" style="text-align: center;">
                    <a href="{{ route('consultaDemonstrativoMensal') }}" style="width: 50%;" title="Voltar"
                        class="btn btn-info"><i class="fas fa-chevron-left"></i> Voltar</a>
                </div>
            </div>
        </div> --}}

        <div class="card-footer" style="text-align: center;">
            <a href="{{ route('consultaDemonstrativoMensal') }}" class="btn btn-outline-info btn-sm" style="width: 20%;">
                <i class="fas fa-chevron-left" aria-hidden="true"></i><strong> VOLTAR </strong>
            </a>
            <button type="submit" class="btn btn-outline-success btn-sm" style="width: 20%;">
                <strong>GERAR PDF</strong>
                <i class="fas fa-file-pdf"></i>
            </button>
        </div>
    </div>
    @endif
</form>
<hr>
{{--  <p style="font-size: 15px; text-align:center; color: gray; margin-top: 30px; ">Desenvolvido por HardSoft Informática &copy; - Todos os direitos reservados</p>  --}}

@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<style>
    label {
        font-size: 18px;
        margin-bottom: -15px;
        margin-top: 10px;
    }

    h3 {
        font-size: 16px;
    }

    input[type="text"] {
        font-size: 18px;
    }

    @media only screen and (max-width: 980px) {
        .esconder {
            display: none;
        }

        label {
            font-size: 14px;
            margin-bottom: -12px;
            margin-top: 1px;
        }

        input[type="text"] {
            font-size: 14px;
        }

        .left {
            text-align: left;
            align-items: left;
        }

        #contrato {
            text-align: left;
        }
    }
</style>
@endsection

@section('footer')
    <strong> <a href="#">HardSoft Sistemas</a> {{ date('Y') }}</strong> -
    v{{ config('messages.version') }}
@endsection

@section('js')
<script src="{{asset('js/custom.js')}}"></script>

@stop
