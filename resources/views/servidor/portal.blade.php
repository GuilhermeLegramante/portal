<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>HardSoft - hsPortal</title>
    <meta content="" name="descriptison">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/logo-nova.png" rel="icon">
    <link href="assets/img/logo-nova.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/vendor/venobox/venobox.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">

    <!-- CSS CUSTOMIZADO -->
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">


    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- =======================================================
  * Template Name: Vesperr - v2.0.0
  * Template URL: https://bootstrapmade.com/vesperr-free-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    @isset($usuario)
    @include('includes.modal.meusDados')
    @endisset

    @if(session('success'))
    @include('includes.modal.success')
    @endif

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex align-items-center">

            <div class="logo mr-auto">
                <h1 class="text-light"><a href="{{url('/')}}"><span>hsPortal</span></a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            </div>

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <li class="active"><a href="#header"><i class="fas fa-laptop-house"></i> Home</a></li>
                    {{-- <li><a href="#about">About</a></li> --}}
                    <li class="drop-down"><a href="#services"><i class="fas fa-laptop-code"></i> Sistemas</a>
                        <ul>
                            <li class="drop-down"><a href="#">Administrativos</a>
                                <ul>
                                    <li><a href="{{url('../../cadastro/')}}" target="_blank"><i class="fas fa-user"></i> hsCadastro</a></li>
                                    <li><a href="#" target="_blank"><i class="fas fa-shopping-cart"></i> hsCompras</a></li>
                                    <li><a href="{{url('../../contabilidade/')}}" target="_blank"><i class="fas fa-calculator"></i> hsContabilidade</a></li>
                                    <li><a href="{{url('../../licitacao/')}}" target="_blank"><i class="fas fa-gavel"></i> hsLicitacao</a></li>
                                    <li><a href="{{ env('APP_MARCAS_URL') }}" target="_blank"><i class="fas fa-signature"></i> hsMarcas</a></li>
                                    <li><a href="{{url('../../patrimonio/')}}" target="_blank"><i class="fas fa-luggage-cart"></i> hsPatrimonio</a></li>
                                    <li><a href="{{url('../../produtor/')}}" target="_blank"><i class="fas fa-tractor"></i> hsProdutor</a></li>
                                    <li><a href="{{url('../../pncp/')}}" target="_blank"><i class="fas fa-gavel"></i> hsPNCP</a></li>
                                    <li><a href="{{url('../../protocolo/')}}" target="_blank"><i class="fas fa-book"></i> hsProtocolo</a></li>
                                    <li><a href="{{url('../../servicos/')}}" target="_blank"><i class="far fa-hospital"></i> hsServiços</a></li>
                                </ul>
                            </li>
                            <li class="drop-down"><a href="#">Externos</a>
                                <ul>
                                    <li><a href="{{url('../../cidadao/')}}" target="_blank"><i class="fas fa-user"></i> hsCidadao</a></li>
                                    <li><a href="{{url('../../contracheque/')}}" target="_blank"><i class="fas fa-dollar-sign"></i> hsContracheque</a></li>
                                    <li><a href="{{url('../../iptu/')}}" target="_blank"><i class="fas fa-hand-holding-usd"></i> hsIPTU</a></li>
                                    <li><a href="{{url('../../protocolo-externo/')}}" target="_blank"><i class="fas fa-book"></i> hsProtocoloExterno</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{url('../../admin/')}}" target="_blank"><i class="fas fa-user-lock"></i> hsAdmin</a></li>
                    {{-- <li><a href="#portfolio">Portfolio</a></li> --}}
                    {{-- <li><a href="#team">Team</a></li> --}}
                    {{-- <li><a href="#pricing">Meu Perfil</a></li> --}}
                    {{-- <li class="drop-down"><a href="">Drop Down</a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="drop-down"><a href="#">Drop Down 2</a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
              <li><a href="#">Drop Down 5</a></li>
            </ul>
          </li> --}}
                    <li><a href="" data-toggle="modal" data-target="#modalMeusDados"><i class="fa fa-user"></i> Meus Dados</a>
                    </li>

                    <li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Sair</a></li>
                </ul>
            </nav><!-- .nav-menu -->

        </div>
    </header><!-- End Header -->

    <!-- MODAL MSG SUCESSO -->
    <div class="modal fade" id="modalInfo" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div style="background-color: #3498db;" class="modal-header">
                    <h3 style="font-size: 19px; color: floralwhite;" class="modal-title"><i class="fas fa-user-lock"></i>
                        Mensagem </h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Módulo não disponível para o cliente.
                </div>
            </div>
        </div>
    </div>
    <!-- FIM MODAL MSG SUCESSO -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up">HardSoft Informática</h1>
                    <h2 data-aos="fade-up" data-aos-delay="400">Gestão Pública Eficiente</h2>
                    <div data-aos="fade-up" data-aos-delay="800">
                        <a href="#services" class="btn-get-started scrollto">SISTEMAS</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= Clients Section ======= -->
        {{-- <section id="clients" class="clients clients">
      <div class="container">

        <div class="row">

          <div class="col-lg-3 col-md-4 col-6">
            {{-- <h3 class="img-fluid" alt="" data-aos="zoom-in"><a href=""> hsProtocolo</a></h3> --}}
        {{-- <a href="{{url('../../protocolo/')}}" target="_blank"><img src="assets/img/clients/hsProtocolo.png" class="img-fluid" alt="" data-aos="zoom-in"></a>
        </div> --}}

        {{-- <div class="col-lg-3 col-md-4 col-6"> --}}
        {{-- <h3 class="img-fluid" alt="" data-aos="zoom-in"><a href="">hsCidadao</a></h3> --}}
        {{-- <img src="assets/img/clients/client-2.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100"> --}}
        {{-- <a href="{{url('../../cidadao/')}}" target="_blank"><img src="assets/img/clients/hsCidadao.png" class="img-fluid" alt="" data-aos="zoom-in"></a>
        </div> --}}

        {{-- <div class="col-lg-3 col-md-4 col-6">
            <a href="{{url('../../contracheque/')}}" target="_blank"><img src="assets/img/clients/hsContracheque.png" class="img-fluid" alt="" data-aos="zoom-in"></a> --}}
        {{-- <img src="assets/img/clients/client-3.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="200"> --}}
        {{-- </div> --}}

        {{-- <div class="col-lg-3 col-md-4 col-6">
            <a href="#"><img src="assets/img/clients/hsGestor.png" class="img-fluid" alt="" data-aos="zoom-in"></a> --}}
        {{-- <img src="assets/img/clients/client-4.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="300"> --}}
        {{-- </div> --}}

        {{-- <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-5.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="400">
          </div> --}}

        {{-- <div class="col-lg-2 col-md-4 col-6">
            <img src="assets/img/clients/client-6.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="500">
          </div>

        </div>


      </div>
      </div>
    </section> --}}
        <!-- End Clients Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Sistemas</h2>
                    {{-- <p>Principais sistemas da empresa</p> --}}
                </div>
                <div style="max-height: 30%;" class="row">
                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-box-open"></i></div>
                            <h4 class="title"><a data-target="#modalInfo" data-toggle="modal" href="#modalInfo" target="_blank">hsAlmoxarifado</a></h4>
                            <p class="description">Controle Eletrônico de Estoque</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <h4 class="title">
                                <a data-target="#modalInfo" data-toggle="modal" href="#modalInfo" target="_blank">hsCadastro</a>
                            </h4>
                            <p class="description">Controle do Cadastro de Munícipes</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                            <h4 class="title"><a data-target="#modalInfo" data-toggle="modal" href="#modalInfo" target="_blank">hsCompras</a></h4>
                            <p class="description">Sistema Eletrônico de Compras</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-user-shield"></i></div>
                            <h4 class="title"><a data-target="#modalInfo" data-toggle="modal" href="#modalInfo" target="_blank">hsControleInterno</a></h4>
                            <p class="description">Sistema Eletrônico de Auditorias</p>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 20px;" class="row">
                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-signature"></i></div>
                            <h4 class="title"><a href="{{ env('APP_MARCAS_URL') }}" target="_blank">hsMarcas</a></h4>
                            <p class="description">Gestão Eletrônica de Marcas</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-car"></i></div>
                            <h4 class="title"><a href="">hsFrotas</a></h4>
                            <p class="description">Controle e Gestão de Frotas</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon"><i class="fas fa-chart-line"></i></div>
                            <h4 class="title"><a href="{{ url('../../gestor/') }}" target="_blank">hsGestor</a></h4>
                            <p class="description">Demonstrativo de Gestão Pública</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="200">
                            <div class="icon"><i class="fas fa-balance-scale"></i></div>
                            <h4 class="title"><a href="{{ url('../../juridico/') }}" target="_blank">hsJurídico</a></h4>
                            <p class="description">Assessoria Jurídica Integrada</p>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 20px;" class="row">
                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-gavel"></i></div>
                            <h4 class="title"><a href="{{ url('../../licitacao/') }}" target="_blank">hsLicitacao</a></h4>
                            <p class="description">Gestão de Processos Licitatórios</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="fas fa-luggage-cart"></i></div>
                            <h4 class="title"><a href="{{url('../../patrimonio/')}}" target="_blank">hsPatrimônio</a></h4>
                            <p class="description">Gestão de Bens Móveis e Imóveis.</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-gavel"></i></div>
                            <h4 class="title"><a href="{{url('../../pncp/')}}" target="_blank">hsPNCP</a></h4>
                            <p class="description">Portal Nacional de Contratações Públicas</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-book"></i></div>
                            <h4 class="title"><a href="{{url('../../protocolo/')}}" target="_blank">hsProtocolo</a></h4>
                            <p class="description">Gestão Eletrônica de Processos</p>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                            <h4 class="title"><a href="{{url('../../tributos/')}}" target="_blank">hsTributos</a></h4>
                            <p class="description">Gestão de Tributos Municipais</p>
                        </div>
                    </div>

                </div>

                <div style="margin-top: 20px;" class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="fas fa-user"></i></div>
                            <h4 class="title"><a href="{{url('../../cidadao/')}}" target="_blank">hsCidadao</a></h4>
                            <p class="description">Portal de Serviços do Cidadão.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="far fa-hospital"></i></div>
                            <h4 class="title"><a href="{{url('../../servicos/')}}" target="_blank">hsServicos</a></h4>
                            <p class="description">Gestão de Atendimentos Médico-Hospitalares.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="fas fa-calculator"></i></div>
                            <h4 class="title"><a href="{{url('../../contabilidade/')}}" target="_blank">hsContabilidade</a></h4>
                            <p class="description">Gestão e Controle da Contabilidade.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
                        <div style="border-color: lightblue; border-style: solid; text-align: center;" class="icon-box" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon"><i class="fas fa-tractor"></i></div>
                            <h4 class="title"><a href="{{url('../../produtor/')}}" target="_blank">hsProdutor</a></h4>
                            <p class="description">Gestão e Controle de Produtor.</p>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- End Services Section -->



        <!-- ======= About Us Section ======= -->
        {{-- <section id="about" class="about">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Quem Somos</h2>
        </div>

        <div class="row content">
          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="150">
            <p>
              Fundada em Julho de 1992 na cidade de Alegrete-RS, a Hard Soft Informática tinha por objetivo atender
              empresas públicas e privadas visando a informatização da gestão de seus setores, que antes era feita de
              forma manual.
            </p>
            <p>
              Em 1993 a Hard Soft Informática direcionou seu desenvolvimento somente para a área pública definindo seus
              softwares de forma a atender as leis e critérios aplicados a este setor. Nesta nova fase o desenvolvimento
              já começou a utilizar uma linha de desenvolvimento única para todos os clientes. Neste mesmo ano mudou-se
              para São Francisco de Assis-RS para ficar no centro de sua área de atendimentos.
            </p>
            <p>
              Atualmente a empresa investe em qualidade de atendimento ao cliente, oferecendo além dos treinamentos
              locais, cursos sobre as diversas áreas do setor público com foco no cumprimento das leis e diretrizes
              atuais.
            </p>
            <ul>
              <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
              <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate velit</li>
              <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>
            </ul>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <p>
              Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
              voluptate
              velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
              culpa qui officia deserunt mollit anim id est laborum.
            </p>
            <a href="#" class="btn-learn-more">Learn More</a>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section --> --}}

        <!-- ======= Counts Section ======= -->
        {{-- <section id="counts" class="counts">
      <div class="container">

        <div class="row">
          <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-xl-start"
            data-aos="fade-right" data-aos-delay="150">
            <img src="assets/img/counts-img.svg" alt="" class="img-fluid">
          </div>

          <div class="col-xl-7 d-flex align-items-stretch pt-4 pt-xl-0" data-aos="fade-left" data-aos-delay="300">
            <div class="content d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="icofont-simple-smile"></i>
                    <span data-toggle="counter-up">65</span>
                    <p><strong>Happy Clients</strong> consequuntur voluptas nostrum aliquid ipsam architecto ut.</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="icofont-document-folder"></i>
                    <span data-toggle="counter-up">85</span>
                    <p><strong>Projects</strong> adipisci atque cum quia aspernatur totam laudantium et quia dere tan
                    </p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="icofont-clock-time"></i>
                    <span data-toggle="counter-up">12</span>
                    <p><strong>Years of experience</strong> aut commodi quaerat modi aliquam nam ducimus aut voluptate
                      non vel</p>
                  </div>
                </div>

                <div class="col-md-6 d-md-flex align-items-md-stretch">
                  <div class="count-box">
                    <i class="icofont-award"></i>
                    <span data-toggle="counter-up">15</span>
                    <p><strong>Awards</strong> rerum asperiores dolor alias quo reprehenderit eum et nemo pad der</p>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Counts Section --> --}}

        <!-- ======= Services Section ======= -->
        {{-- <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Áreas de Atuação</h2>
          <p>Principais áreas de atuação da empresa</p>
        </div>

        <div class="row">
          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
              <div class="icon"><i class="fas fa-clipboard"></i></div>
              <h4 class="title"><a href="">Administrativo</a></h4>
              <p class="description">Sistemas multi-tarefas e multi-usuários</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
              <div class="icon"><i class="fas fa-calculator"></i></div>
              <h4 class="title"><a href="">Contábil</a></h4>
              <p class="description">Gestão contábil segura e em acordo com a legislação</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
              <div class="icon"><i class="fas fa-users"></i></div>
              <h4 class="title"><a href="">Recursos Humanos</a></h4>
              <p class="description">Agilidade, praticidade e eficiência no RH</p>
            </div>
          </div>

          <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
            <div class="icon-box" data-aos="fade-up" data-aos-delay="400">
              <div class="icon"><i class="fas fa-stamp"></i></div>
              <h4 class="title"><a href="">Legislativo</a></h4>
              <p class="description">Gestão de sessões legislativas de forma prática.</p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Services Section --> --}}

        <!-- ======= More Services Section ======= -->
        {{-- <section id="more-services" class="more-services">
      <div class="container">

        <div class="row">
          <div class="col-md-6 d-flex align-items-stretch">
            <div class="card" style='background-image: url("assets/img/more-services-1.jpg");' data-aos="fade-up"
              data-aos-delay="100">
              <div class="card-body">
                <h5 class="card-title"><a href="{{url('../../protocolo/')}}" target="_blank">hsProtocolo</a></h5>
        <p class="card-text">Acesso e Controle de Protocolo Interno</p>
        <div class="read-more"><a href="{{url('../../protocolo/')}}" target="_blank"><i class="icofont-arrow-right"></i>
                Acessar</a></div>
        </div>
        </div>
        </div>
        <div class="col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="card" style='background-image: url("assets/img/more-services-5.jpg");' data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{url('../../cidadao/')}}">hsCidadao</a></h5>
                    <p class="card-text">Emissão de Protocolos Externos</p>
                    <div class="read-more"><a href="{{url('../../cidadao/')}}"><i class="icofont-arrow-right"></i>
                            Acessar</a></div>
                </div>
            </div>

        </div>
        <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/more-services-4.jpg");' data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <h5 class="card-title"><a href="{{url('../../contracheque/')}}">hsContracheque</a></h5>
                    <p class="card-text">Consulta de contracheques</p>
                    <div class="read-more"><a href="{{url('../../contracheque/')}}"><i class="icofont-arrow-right"></i>
                            Acessar</a></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 d-flex align-items-stretch mt-4">
            <div class="card" style='background-image: url("assets/img/more-services-3.jpg");' data-aos="fade-up" data-aos-delay="200">
                <div class="card-body">
                    <h5 class="card-title"><a href="">hsGestor</a></h5>
                    <p class="card-text">Controle do Município na palma da mão</p>
                    <div class="read-more"><a href="#"><i class="icofont-arrow-right"></i> Read More</a></div>
                </div>
            </div>
        </div>
        </div>

        </div>
        </section><!-- End More Services Section --> --}}

        <!-- ======= Features Section ======= -->
        {{-- <section id="features" class="features">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Features</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="300">
          <div class="col-lg-3 col-md-4">
            <div class="icon-box">
              <i class="ri-store-line" style="color: #ffbb2c;"></i>
              <h3><a href="">Lorem Ipsum</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="ri-bar-chart-box-line" style="color: #5578ff;"></i>
              <h3><a href="">Dolor Sitema</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-md-0">
            <div class="icon-box">
              <i class="ri-calendar-todo-line" style="color: #e80368;"></i>
              <h3><a href="">Sed perspiciatis</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4 mt-lg-0">
            <div class="icon-box">
              <i class="ri-paint-brush-line" style="color: #e361ff;"></i>
              <h3><a href="">Magni Dolores</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-database-2-line" style="color: #47aeff;"></i>
              <h3><a href="">Nemo Enim</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-gradienter-line" style="color: #ffa76e;"></i>
              <h3><a href="">Eiusmod Tempor</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-file-list-3-line" style="color: #11dbcf;"></i>
              <h3><a href="">Midela Teren</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-price-tag-2-line" style="color: #4233ff;"></i>
              <h3><a href="">Pira Neve</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-anchor-line" style="color: #b2904f;"></i>
              <h3><a href="">Dirada Pack</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-disc-line" style="color: #b20969;"></i>
              <h3><a href="">Moton Ideal</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-base-station-line" style="color: #ff5828;"></i>
              <h3><a href="">Verdo Park</a></h3>
            </div>
          </div>
          <div class="col-lg-3 col-md-4 mt-4">
            <div class="icon-box">
              <i class="ri-fingerprint-line" style="color: #29cc61;"></i>
              <h3><a href="">Flavor Nivelanda</a></h3>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Features Section --> --}}

        <!-- ======= Testimonials Section ======= -->
        {{-- <section id="testimonials" class="testimonials section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Testimonials</h2>
          <p>Magnam dolores commodi suscipit eum quidem consectetur velit</p>
        </div>

        <div class="owl-carousel testimonials-carousel" data-aos="fade-up" data-aos-delay="200">

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
              <h3>Saul Goodman</h3>
              <h4>Ceo &amp; Founder</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium
                quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
              <h3>Sara Wilsson</h3>
              <h4>Designer</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis
                quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
              <h3>Jena Karlis</h3>
              <h4>Store Owner</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor
                labore quem eram duis noster aute amet eram fore quis sint minim.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
              <h3>Matt Brandon</h3>
              <h4>Freelancer</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim
                dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

          <div class="testimonial-wrap">
            <div class="testimonial-item">
              <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
              <h3>John Larson</h3>
              <h4>Entrepreneur</h4>
              <p>
                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa
                labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
              </p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Testimonials Section --> --}}

        <!-- ======= Portfolio Section ======= -->
        {{-- <section id="portfolio" class="portfolio">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Portfolio</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem</p>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>
          </div>
        </div>

        <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="400">

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 1</h4>
                <p>App</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-1.jpg" data-gall="portfolioGallery" class="venobox"
                    title="App 1"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-2.jpg" data-gall="portfolioGallery" class="venobox"
                    title="Web 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 2</h4>
                <p>App</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-3.jpg" data-gall="portfolioGallery" class="venobox"
                    title="App 2"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 2</h4>
                <p>Card</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-4.jpg" data-gall="portfolioGallery" class="venobox"
                    title="Card 2"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 2</h4>
                <p>Web</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-5.jpg" data-gall="portfolioGallery" class="venobox"
                    title="Web 2"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>App 3</h4>
                <p>App</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-6.jpg" data-gall="portfolioGallery" class="venobox"
                    title="App 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 1</h4>
                <p>Card</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-7.jpg" data-gall="portfolioGallery" class="venobox"
                    title="Card 1"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Card 3</h4>
                <p>Card</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-8.jpg" data-gall="portfolioGallery" class="venobox"
                    title="Card 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web">
            <div class="portfolio-wrap">
              <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
                <div class="portfolio-links">
                  <a href="assets/img/portfolio/portfolio-9.jpg" data-gall="portfolioGallery" class="venobox"
                    title="Web 3"><i class="bx bx-plus"></i></a>
                  <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Section --> --}}

        <!-- ======= Team Section ======= -->
        {{-- <section id="team" class="team section-bg">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Team</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="100">
              <div class="member-img">
                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Walter White</h4>
                <span>Chief Executive Officer</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="200">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Sarah Jhonson</h4>
                <span>Product Manager</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="300">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>William Anderson</h4>
                <span>CTO</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="400">
              <div class="member-img">
                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Amanda Jepson</h4>
                <span>Accountant</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Team Section --> --}}

        <!-- ======= Pricing Section ======= -->
        {{-- <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title">
          <h2>Pricing</h2>
          <p>Sit sint consectetur velit nemo qui impedit suscipit alias ea</p>
        </div>

        <div class="row">

          <div class="col-lg-4 col-md-6">
            <div class="box" data-aos="zoom-in-right" data-aos-delay="200">
              <h3>Free</h3>
              <h4><sup>$</sup>0<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li class="na">Pharetra massa</li>
                <li class="na">Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
            <div class="box recommended" data-aos="zoom-in" data-aos-delay="100">
              <h3>Business</h3>
              <h4><sup>$</sup>19<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li>Pharetra massa</li>
                <li class="na">Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
            <div class="box" data-aos="zoom-in-left" data-aos-delay="200">
              <h3>Developer</h3>
              <h4><sup>$</sup>29<span> / month</span></h4>
              <ul>
                <li>Aida dere</li>
                <li>Nec feugiat nisl</li>
                <li>Nulla at volutpat dola</li>
                <li>Pharetra massa</li>
                <li>Massa ultricies mi</li>
              </ul>
              <div class="btn-wrap">
                <a href="#" class="btn-buy">Buy Now</a>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Pricing Section --> --}}

        <!-- ======= F.A.Q Section ======= -->
        {{-- <section id="faq" class="faq">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Frequently Asked Questions</h2>
        </div>

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>Non consectetur a erat nam at lectus urna duis?</h4>
          </div>
          <div class="col-lg-7">
            <p>
              Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida.
              Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?</h4>
          </div>
          <div class="col-lg-7">
            <p>
              Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec
              ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit
              ullamcorper dignissim.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi?</h4>
          </div>
          <div class="col-lg-7">
            <p>
              Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum
              integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt.
              Lectus urna duis convallis convallis tellus.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h4>
          </div>
          <div class="col-lg-7">
            <p>
              Aperiam itaque sit optio et deleniti eos nihil quidem cumque. Voluptas dolorum accusantium sunt sit enim.
              Provident consequuntur quam aut reiciendis qui rerum dolorem sit odio. Repellat assumenda soluta sunt
              pariatur error doloribus fuga.
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

        <div class="row faq-item d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="500">
          <div class="col-lg-5">
            <i class="ri-question-line"></i>
            <h4>Tempus quam pellentesque nec nam aliquam sem et tortor consequat?</h4>
          </div>
          <div class="col-lg-7">
            <p>
              Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel
              risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida
              quis blandit turpis cursus in
            </p>
          </div>
        </div><!-- End F.A.Q Item-->

      </div>
    </section><!-- End F.A.Q Section --> --}}

        <!-- ======= Contact Section ======= -->
        {{-- <section id="contact" class="contact">
       <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Fale conosco</h2>
        </div>

        <div class="row">

          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="contact-about">
              <h3>HardSoft Informática</h3>
              <p>Gestão Pública eficiente.</p>
              <div class="social-links"> --}}
        {{-- <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
                <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
                <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
                <a href="#" class="linkedin"><i class="icofont-linkedin"></i></a> --}}
        {{-- </div>
            </div>
          </div> --}}

        {{-- <div class="col-lg-3 col-md-6 mt-4 mt-md-0" data-aos="fade-up" data-aos-delay="200">
            <div class="info">
              <div>
                <i class="ri-map-pin-line"></i>
                <p>Rua Cap. Vasco da Cunha, 350,<br>Santa Maria, RS 97030-110</p>
              </div>

              <div>
                <i class="ri-mail-send-line"></i>
                <p><a href="mailto:ouvidoria@hardsoftsfa.com.br">ouvidoria@hardsoftsfa.com.br</a></p>
              </div>

              <div>
                <i class="ri-phone-line"></i>
                <p><a href="tel:5530322111">(55) 3032-2111</a></p>
              </div>

            </div>
          </div>

          <div class="col-lg-5 col-md-12" data-aos="fade-up" data-aos-delay="300">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="form-group">
                <input type="text" name="name" class="form-control" id="name" placeholder="Seu Nome"
                  data-rule="minlen:4" data-msg="Por favor, digite ao menos 4 caracteres." />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <input type="email" class="form-control" name="email" id="email" placeholder="Seu Email"
                  data-rule="email" data-msg="Por favor, informe um email válido." />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Assunto"
                  data-rule="minlen:4" data-msg="Por favor, informe ao menos 4 caracteres." />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="message" rows="5" data-rule="required"
                  data-msg="Preenchimento obrigatório" placeholder="Mensagem"></textarea>
                <div class="validate"></div>
              </div> --}}
        {{-- <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div> --}}
        {{-- <div class="text-center"><button type="submit">Enviar Mensagem</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section --> --}}


    </main><!-- End #main -->

    <!-- ======= Footer ======= -->

    <footer id="footer">
        <div class="container">
            <div class="row d-flex align-items-center">
                <div class="col-lg-6 text-lg-left text-center">
                    <div id="copy" style="font-size: 11px; text-align:center; color: gray; text-align: right; " class="copyright">
                        <p style="padding-right: 35%; margin-top: 3%;">{{isset($_SESSION['cliente']) ? $_SESSION['cliente'] : ''}} -
                            {{date("d/m/Y")}} &nbsp;</p>
                        <p style="padding-right: 30%;">Desenvolvido por HardSoft Informática &copy; - Todos os direitos reservados
                        </p> <br>
                        {{-- &copy; <strong>HardSoft Informática</strong> - Todos os direitos reservados. --}}
                    </div>
                    <div class="credits">
                        <!-- All the links in the footer should remain intact. -->
                        <!-- You can delete the links only if you purchased the pro version. -->
                        <!-- Licensing information: https://bootstrapmade.com/license/ -->
                        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/vesperr-free-bootstrap-template/ -->
                        {{-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> --}}
                    </div>
                </div>
                <div class="col-lg-6">
                    <nav class="footer-links text-lg-right text-center pt-2 pt-lg-0">
                        <a href="#header" class="scrollto"><i class="fas fa-laptop-house"></i> Home</a>
                        <a href="#services" class="scrollto"><i class="fas fa-laptop-code"></i> Sistemas</a>
                        <a href="{{url('../../admin/')}}" target="_blank"><i class="fas fa-user-lock"></i> hsAdmin</a>
                        <a href="" class="scrollto" data-toggle="modal" data-target="#modalMeusDados"><i class="fa fa-user"></i>
                            Meus Dados</a>
                        <a href="{{route('logout')}}" class="scrollto"><i class="fa fa-sign-out"></i> Sair</a>
                        {{-- <a href="#">Privacy Policy</a>
            <a href="#">Terms of Use</a> --}}
                    </nav>
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="assets/vendor/counterup/counterup.min.js"></script>
    <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/venobox/venobox.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>

    <!-- JS CUSTOMIZADO -->
    <script src="{{asset('js/custom.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    @if ($errors->any())
    <script type="text/javascript">
        $('#modalMeusDados').modal('show');

    </script>
    @endif

    @if (session('success'))
    <script type="text/javascript">
        $('#modalSucesso').modal('show');

    </script>
    @endif

</body>

</html>
