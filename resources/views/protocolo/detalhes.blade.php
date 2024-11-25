@extends('adminlte::page')

@section('title', 'hsCidadao - Detalhes Protocolo')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-12">
        <div class="card card-primary card-tabs">
            <div style="background: #17a2b8" class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                            href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                            aria-selected="true">Detalhes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                            href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                            aria-selected="false">Movimentação</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel"
                        aria-labelledby="custom-tabs-one-home-tab">
                        <div class="callout callout-info">
                            <!-- primeira linha -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Nº do Protocolo</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-file-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control"
                                                value="{{$protocolo->numeroprotocolo}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Data de Emissão</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" value="{{$protocolo->dataemissao}}"
                                                disabled>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Prioridade</label>
                                        <input type="text" class="form-control" value="{{$protocolo->prioridade}}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Origem</label>
                                        <input type="text" class="form-control" value="{{$protocolo->origem}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" class="form-control" value="{{$protocolo->status}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- fim primeira linha -->

                            <!-- segunda linha -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Assunto</label>
                                        <input type="text" class="form-control" value="{{$protocolo->descricaoassunto}}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo de Documento</label>
                                        <input type="text" class="form-control"
                                            value="{{$protocolo->descricaotipodocumento}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- fim segunda linha -->

                            <!-- terceira linha -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Informações Adicionais</label>
                                        <input type="text" class="form-control"
                                            value="{{$protocolo->informacoesadicionais}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- fim terceira linha -->

                            <!-- quarta linha -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Descricao do Protocolo</label>
                                        <textarea class="form-control" rows="4"
                                            disabled>{{$protocolo->descricaoprotocolo}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- fim quarta linha -->

                            <!-- quinta linha -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Anexos</label> <br>
                                        @foreach ($anexos as $anexo)
                                        <a class="btn-link text-secondary" style="text-decoration: none;" href="{{asset('storage/'.$protocolo->codigo.'/'.$anexo->nomearquivo)}}"
                                            target="_blank">{{$anexo->nomeoriginal}}</a> <br>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- fim quinta linha -->
                        </div>

                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                        aria-labelledby="custom-tabs-one-profile-tab">
                        <div class="callout callout-info">
                            <!-- quarta linha -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Movimentação</label>
                                        <textarea class="form-control" rows="4"
                                            disabled>{{$protocolo->descricaoprotocolo}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- fim quarta linha -->
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
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