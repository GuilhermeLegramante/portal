@extends('adminlte::page')

@section('title', 'hsCidadao - Emissão Protocolo')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')

<div class="card card-info">
    <div class="card-header">
        <h3 style="margin-bottom: 1px;">Dados do Protocolo</h3>
    </div>

    <form id="" action="{{route('protocolo.emissao')}}" class="form" method="post" enctype="multipart/form-data">
        <div class="card-body">
            @csrf

            <div class="callout callout-info">
                <!-- primeira linha -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Protocolante</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Protocolante"
                                    value="{{Auth::user()->name}}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Tipo de Documento</label>
                            <select name="tipodocumento" id="tipodocumento" class="form-control">
                                <option disabled selected value> </option>
                                @foreach ($tiposDocumento as $tipoDocumento)
                                <option value="{{$tipoDocumento->id}}"> {{$tipoDocumento->descricao}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Prioridade</label>
                            <select name="prioridade" id="prioridade" class="form-control">
                                <option value="NORMAL"> NORMAL </option>
                                <option value="ALTA"> ALTA </option>
                                <option value="URGENTE"> URGENTE </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>Origem</label><br>
                            <input type="hidden" name="origem" value="EXTERNO">
                            <input type="text" value="EXTERNO" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <!-- fim primeira linha -->
            </div>
        </div>

        <div style="margin-top: -2%;" class="card-body">
            <div class="callout callout-info">
                <!-- primeira linha -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Assunto</label>
                            <select name="assunto" id="assunto" class="form-control">
                                <option disabled selected value> </option>
                                @foreach ($assuntos as $assunto)
                                <option value="{{$assunto->id}}"> {{$assunto->descricao}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Anexos</label>&nbsp;<i data-toggle="tooltip"
                                title="Os arquivos devem estar no mesmo diretório. Segure CTRL para selecionar mais de um anexo."
                                class="fas fa-question-circle"></i></a>
                            <div class="custom-file">
                                <input name="anexos[]" type="file" class="form-control" multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- fim primeira linha -->
                <!-- segunda linha -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Informações adicionais do assunto</label>
                            <input type="text" name="informacoesadicionais" placeholder="Opcional"
                                value="{{old('informacoesadicionais')}}" id="" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- fim segunda linha -->
                <!-- terceira linha -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Descrição do Protocolo</label>
                            <textarea name="descricao" class="form-control" rows="4"
                                placeholder="Informe detalhadamente o assunto do protocolo ..."
                                value="{{old('descricao')}}"></textarea>
                        </div>
                    </div>
                </div>
                <!-- fim terceira linha -->

            </div>
        </div>

        <div style="margin-top: -2%;" class="card-body">
            <div class="callout callout-info">
                <!-- primeira linha -->
                <div class="row">
                    <div class="col-sm-12" style="text-align: center; margin-top: 1%;">
                        <button type="submit" class="btn btn-info" style="width: 50%;">
                            Emitir Protocolo
                            <i class="fa fa-file-alt" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <!-- fim primeira linha -->
            </div>
        </div>



    </form>


</div>
@include('includes.footer-hz')
@stop




@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

@stop