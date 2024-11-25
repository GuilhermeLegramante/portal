@extends('adminlte::page')

@section('title', 'hsPortal - Meus Dados')

@section('content_header')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ session('error') }}
</div>
@endif

@if(!empty($error))
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    {{ $error }}
</div>
@endif

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-laptop-house"></i> Meus Dados</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><i class="fas fa-laptop-house"></i> Meus Dados</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>


<div class="card">
    <div class="card-body">
        <!-- primeira linha -->
        <div style="margin-bottom: -20px;" class="row">
            <div class="col-sm-1 left">
                <div class="form-group left">
                    <label style="font-weight: 600; margin-bottom: -5px;">Inscrição</label>
                    <h5 style="font-weight: 300;">{{ session('idmunicipe') }}</h5>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="font-weight: 600; margin-bottom: -5px;">Nome</label>
                    <h5 style="font-weight: 300;">{{session('municipeName')}}</h5>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label style="font-weight: 600; margin-bottom: -5px;">CPF</label>
                    <h5 style="font-weight: 300;">{{session('municipeCpf')}}</h5>
                </div>
            </div>
        </div>
        <!-- fim primeira linha -->
    </div>
</div>
<section id="hideDesktop">
    <div class="card mobile">
        <div class="card-body">
            <div class="row">
                @if(session('tem_contrato_ativo'))
                <div style="margin-bottom: 3px;" class="col-sm-3 mb-2">
                    <a href="{{route('consultaDemonstrativoMensal')}}" class="btn btn-block bg-gradient-primary btn-lg">Demonstrativo Mensal</a>
                </div>
                <div class="col-sm-3 mb-2">
                    <a href="{{route('consultaDemonstrativoPeriodo')}}" class="btn btn-block bg-gradient-primary btn-lg">Demonstrativo por Período</a>
                </div>
                @endif

                <div class="col-sm-3 mb-2">
                    <a href="{{route('view.dividas')}}" class="btn btn-block bg-gradient-primary btn-lg">Gastos Médicos</a>
                </div>
                <div class="col-sm-3 mb-2">
                    <a href="{{route('unregisteredDebt')}}" class="btn btn-block bg-gradient-primary btn-lg">Últimos Lançamentos</a>
                </div>
                @if(session('tem_contrato_ativo'))
                <div class="col-sm-3 mb-2">
                    <a href="{{route('consulta.crp')}}" class="btn btn-block bg-gradient-primary btn-lg">Comprovante de Rendimentos</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if(session('tem_contrato_ativo'))
<div class="card">
    <div class="card-body">
        <h4 style="color: gray; font-weight: 100;"> Dados do Exercício Corrente </h4>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3 style="font-weight: 100">
                            {{number_format(session('valor_provento'), 2, ',', '.')}}</h3>
                        <p>Proventos Exercício</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3 style="font-weight: 100">
                            {{number_format(session('valor_desconto'), 2, ',', '.')}}</h3>
                        <p>Descontos Exercício</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3 style="font-weight: 100">
                            {{number_format(session('valor_liquido'), 2, ',', '.')}}
                        </h3>
                        <p>Líquido Exercício</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@endsection

@section('footer')
<strong> <a href="#">HardSoft Sistemas</a> {{ date('Y') }}</strong> -
v{{ config('messages.version') }}
@endsection

@section('plugins.Datatables', true)

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">

@stop

@section('js')
<script>
    console.log('Hi!');

</script>
@stop
