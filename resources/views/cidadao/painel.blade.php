@extends('adminlte::page')

@section('title', 'hsPortal - Painel')

@section('content_header')

@include('includes.alerts')

@endsection

@section('content')
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<div class="card card-info">
    <div class="card-header">
        <h3 style="margin-bottom: 1px;">Meus Protocolos</h3>
    </div>
    <div class="card-body">
        <div class="callout callout-info">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Busca</label>
                        <div class="input-group input-group-sm">
                            <form action="{{ route('protocolos.buscaPeloId') }}" method="POST" class="form form-inline">
                                @csrf
                                <input name="numeroProtocolo" type="text" placeholder="Nº do Protocolo"
                                    class="form-control" maxlength="15" required>
                                <span class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-flat"><i
                                            class="fas fa-search"></i></button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nº Protocolo</th>
                            <th>Data de Emissão</th>
                            <th>Prioridade</th>
                            <th>Assunto</th>
                            <th>Tipo de Documento</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($protocolos as $protocolo )
                        @php
                        $data = $protocolo->dataemissao;
                        $dataFormatada = date("d/m/Y H:i:s", strtotime($data));
                        @endphp
                        <tr>
                            <td>{{$protocolo->numeroprotocolo}}</td>
                            <td>{{$dataFormatada}}</td>
                            <td>{{$protocolo->prioridade}}</td>
                            <td>{{$protocolo->descricaoassunto}}</td>
                            <td>{{$protocolo->descricaotipodocumento}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a style="color: white; text-decoration: none;"
                                        href="{{ route('protocolo.detalhes', $protocolo->idprotocolo ) }}"
                                        class="btn btn-info btn-sm">Detalhar <i class="fas fa-info-circle"></i></a>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        <div class="d-flex">
            <div class="mx-auto">
                {!! $protocolos->links() !!}
            </div>
        </div>
    </div>
</div>
</div>

@include('includes.footer-hz')

@endsection

@section('plugins.Datatables', true)

@section('css')

@stop

@section('js')
<script>
    console.log('Hi!');
</script>
@stop