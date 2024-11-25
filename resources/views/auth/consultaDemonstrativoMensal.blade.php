@extends('adminlte::page')

@section('title', 'hsContracheque - Consulta Demonstrativo Mensal')

@section('content_header')

@section('content')


@include('includes.alerts')


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="far fa-calendar-alt"></i> Demonstrativo Mensal</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                class="fas fa-laptop-house"></i>
                            Meus Dados</a></li>
                    <li class="breadcrumb-item active"><i class="far fa-calendar-alt"></i> Demonstrativo Mensal</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<form id="" action="{{route('buscaContrachequeMensal')}}" method="post">
    <div class="card">
        <div class="card-body">
            @csrf
            <!-- primeira linha -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Contratos</label>
                        <select name="contrato" id="contrato" class="form-control">
                            @foreach ($contratos as $contrato)
                            <option value="{{$contrato->id}}">{{$contrato->matricula}} | {{$contrato->desc_funcao}} |
                                {{$contrato->dataadmissao}} | {{$contrato->desc_situacao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- fim primeira linha -->

            <!-- segunda linha -->
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tipo de Folha</label>
                        <select name="tipofolha" id="tipofolha" class="form-control">
                            @foreach ($tiposfolha as $tipofolha)
                            <option value="{{$tipofolha->id}}">{{$tipofolha->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Ano</label>
                        <select name="ano" id="ano" class="form-control">
                            {{ $now = date('Y') }}
                            @for ($i=$now; $i>=1990; $i--)
                            <option value="{{$i}}"> {{$i}} </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Mês</label>
                        <select name="mes" id="mes" class="form-control">
                            <option value="{{$mesNumero}}"> {{$mesAtual}} </option>
                            @foreach ($meses as $key => $mes)
                            <option value="{{$key}}"> {{$mes}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- fim segunda linha -->
        </div>
        <div class="card-footer" style="text-align: center;">
            <div class="row">
                <div class="col-sm-12 mt-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i><strong> VOLTAR </strong>
                    </a>
                    <button type="submit" class="btn btn-outline-success btn-sm">
                        <strong>CONSULTAR </strong>
                        <i class="far fa-eye" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('footer')
    <strong> <a href="#">HardSoft Sistemas</a> {{ date('Y') }}</strong> -
    v{{ config('messages.version') }}
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@stop
