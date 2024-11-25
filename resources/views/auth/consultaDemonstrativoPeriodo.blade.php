@extends('adminlte::page')

@section('title', 'Consulta Demonstrativo Mensal')

@section('content_header')

@include('includes.alerts')

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="far fa-calendar-alt"></i> Demonstrativo Período</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                class="fas fa-laptop-house"></i>
                            Meus Dados</a></li>
                    <li class="breadcrumb-item active"><i class="far fa-calendar-alt"></i> Demonstrativo Período</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

<form id="" action="{{route('geraPdfPeriodo')}}" class="form" method="post">
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
                            <option value="TODOS">TODOS</option>
                            @foreach ($tiposfolha as $tipofolha)
                            <option value="{{$tipofolha->id}}">{{$tipofolha->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Data Inicial</label>
                        <input class="form-control" type="date" name="datainicial" id="datainicial" value="{{$dtI}}" required>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Data Final</label>
                        <input class="form-control" type="date" name="datafinal" id="datafinal" value="{{$dtF}}" required>
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

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@endsection

@section('js')
<script src="{{asset('js/custom.js')}}"></script>

@stop
