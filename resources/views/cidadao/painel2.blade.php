@extends('adminlte::master')

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('adminlte_css')
@stack('css')
@yield('css')
@stop


@section('body')
<div class="login-page" style="background-image: url('vendor/adminlte/dist/img/fundo.jpg');
    background-size: cover; width:100%; opacity: 90%;">

    <div class="container-fluid" style="margin-top: -30%;">
        <nav class="navbar navbar-expand-sm">
            <a class="navbar-brand" href="#"><img src="vendor/adminlte/dist/img/logo_default.png"
                    style="border-radius: 5px" width="115" height="42"></a>
            <button class="navbar-toggler custom-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">

                </ul>
                <span class="navbar-text">
                    <ul class="navbar-nav mr-auto" style="list-style-type: none">
                        <li class="nav-item">
                        <a style="color: white !important" class="nav-link" href="{{route('logout')}}"><i
                                    class="fas fa-sign-out-alt"></i> Sair</a>
                        </li>
                    </ul>
                </span>
            </div>
        </nav>
        <br />
        <div class="row">
            <div class="col-12" style="text-align: center;">
                <h1 style="color: white;">hsPortal  <strong>CIDADÃO</strong> </h1>
            </div>
        </div>
        <hr>
        <div class="row">
            <div style="text-align: center;" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="#">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-file-alt faa-float animated"></i>
                        </div>
                        <div class="details">
                            <div class="number">hsProtocolo</div>
                            <div class="desc">Registro e controle de Protocolos</div>
                        </div>
                    </div>
                </a>
            </div>
            <div style="text-align: center;" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="#">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-info faa-float animated"></i>
                        </div>
                        <div class="details">
                            <div class="number">hsSIC</div>
                            <div class="desc">Serviço de Informação ao Cidadão</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        
        <!--
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a href="../hspatrimonio/">
                    <div class="dashboard-stat blue">
                        <div class="visual">
                            <i class="fa fa-lock faa-float animated"></i>
                        </div>
                        <div class="details">
                            <div class="number">hsPatrimônio</div>
                            <div class="desc">Controle do Patrimônio</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a href="../hsgestor/portal-gestor.php">
                    <div class="dashboard-stat green">
                        <div class="visual">
                            <i class="fa fa-chart-pie faa-float animated"></i>
                        </div>
                        <div class="details">
                            <div class="number">hsGestor</div>
                            <div class="desc">Indicadores de Gestão</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <a href="../hsprotestocartorial/index.php">
                    <div class="dashboard-stat yellow">
                        <div class="visual">
                            <i class="fa fa-file-invoice-dollar faa-float animated"></i>
                        </div>
                        <div class="details">
                            <div class="number">hsProtestoCartorial</div>
                            <div class="desc">Sistema de Protesto Cartorial</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-archive faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsArquivo</div>
                        <div class="desc">Controle do Arquivo</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-receipt faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsAtuarial</div>
                        <div class="desc">Controle para Cálculo Atuarial</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-folder-open faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsCadastro</div>
                        <div class="desc">Controle de Munícipes e Fornecedores</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-shopping-basket faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsCompras</div>
                        <div class="desc">Controle de Compras</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-calculator faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsContab</div>
                        <div class="desc">Controle de Contabilidade Pública</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-money-check-alt faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsDIRF</div>
                        <div class="desc">Controle de IRRF</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-window-close faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsEncerramento</div>
                        <div class="desc">Controle de Encerramento do Exercício Contábil</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-globe faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hseSocial</div>
                        <div class="desc">Controle de Remessas do eSocial</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-file-signature faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsFolha</div>
                        <div class="desc">Controle de Folha de Pagamento</div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-truck-moving faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsFrotas</div>
                        <div class="desc">Controle de Frotas</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsHórus</div>
                        <div class="desc">Controle de Prestação ao Hórus</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsLeis</div>
                        <div class="desc">Controle de Leis</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsLicitação</div>
                        <div class="desc">Controle de Licitações e Contratos</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsLicitacon</div>
                        <div class="desc">Sistema de Licitações e Contratos</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsMANAD</div>
                        <div class="desc">Manual Normativo de Arquivos Digitais</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsNfse</div>
                        <div class="desc">Sistema de Nota Fiscal de Serviços</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsOrçamento</div>
                        <div class="desc">Controle do Orçamento</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsPatrimônio</div>
                        <div class="desc">Controle de Patrimônio</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsPrevidência</div>
                        <div class="desc">Controle de Contribuições Previdenciárias</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsProtocolo</div>
                        <div class="desc">Controle de Protocolo</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsRAIS</div>
                        <div class="desc">Relação Anual de Informações Sociais</div>
                    </div>
                </div>
            </div>
        </div>
         <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsRH</div>
                        <div class="desc">Controle de Recursos Humanos</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsRPPS</div>
                        <div class="desc">Controle de Previdência Municipal</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsSaúde</div>
                        <div class="desc">Controle de Saúde Pública</div>
                    </div>
                </div>
            </div>
        </div>                
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat green">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsSIAPC</div>
                        <div class="desc">Auditoria e Prestação de Contas</div>
                    </div>
                </div>
            </div>                        
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat yellow">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">hsTributos</div>
                        <div class="desc">Controle de Tributos Municipais</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue">
                    <div class="visual">
                        <i class="fa fa-arrow-up faa-float animated"></i>
                    </div>
                    <div class="details">
                        <div class="number">HelpDesk</div>
                        <div class="desc">Solicitação de Assistência</div>
                    </div>
                </div>
            </div>
        </div>-->
    </div>

</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
<link rel="icon" href="{{ URL::asset('img/logo.jpg') }}" type="image/x-icon" />
@endsection

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@endsection

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('js')
@yield('js')
@stop