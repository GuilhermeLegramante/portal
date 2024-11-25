@extends('adminlte::master')

@include('includes.favicon')

@section('title', 'hsCidadão - Cadastrar Cidadão')

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

@section('classes_body', 'login-page')

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url',
'password/reset') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
@php( $login_url = $login_url ? route($login_url) : '' )
@php( $register_url = $register_url ? route($register_url) : '' )
@php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
@php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
@php( $login_url = $login_url ? url($login_url) : '' )
@php( $register_url = $register_url ? url($register_url) : '' )
@php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
@php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
<div class="login-page" style="background-image: url('../vendor/adminlte/dist/img/fundo.jpg');
    background-size: auto; width:100%;">
    <div class="container"
        style="width: 80%; border-radius: 12px; background: ghostwhite; position: relative; z-index: 99;">
        <!-- div cabeçalho -->
        <div style="padding: 3%;" class="container esconder">
            <div style="max-height: 90px;" class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <a href="{{route('login')}}"><img style="width:95px;"
                                    src="../vendor/adminlte/dist/img/logo.jpg" alt=""></a>
                        </div>
                        <div style="margin-top: 2%;" class="col-sm-9">
                            <h2 style="font-size: 28px; color: gray; margin-left: 15%;">Cadastro de Cidadão</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- fim div cabeçalho -->

        <div class="container formulario" style="padding-left: 3%; padding-right:3%; margin-top: -30px;">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div style="max-height: 30px; padding: -1%; margin-top: -10px;" class="alert alert-danger">
                <p style="margin-top: -1%;">{{ $error }}</p>
            </div>
            @endforeach
            @endif
            <div class="card formulario">
                <div class="card-body">
                    <form id="" action="{{ route('salvarCidadao') }}" class="form" method="post">
                        @csrf
                        <!-- primeira linha -->
                        <div style="" class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nome Completo</label>
                                    <input type="text" name="name" id="name" size="40" class="form-control"
                                        value="{{old('name')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>CPF</label>
                                    <input type="text" name="cpf" id="cpfcnpj"
                                        onfocus="javascript: retirarFormatacao(this);"
                                        onblur="javascript: formatarCampo(this);" size="40" class="form-control"
                                        value="{{old('cpf')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" name="email" id="email" size="40" class="form-control"
                                        value="{{old('email')}}">
                                </div>
                            </div>
                        </div>
                        <!-- fim primeira linha -->

                        <!-- segunda linha -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Senha</label>
                                    <input type="password" name="password" id="password" size="40" class="form-control"
                                        value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Confirmação da senha</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        size="40" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Telefone</label>
                                    <input type="telefone" name="telefone" id="telefone" size="40" class="form-control"
                                        value="{{old('telefone')}}">
                                </div>
                            </div>
                        </div>
                        <!-- fim segunda linha -->

                        <!-- terceira linha -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>CEP &nbsp; <a href="http://www.buscacep.correios.com.br/sistemas/buscacep/"
                                        target="_blank">Não sei o meu CEP</a></label>
                                    <input type="text" name="cep" id="cep" class="form-control" size="10" maxlength="9"
                                        onblur="pesquisacep(this.value);" value="{{old('cep')}}">
                                    
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div class="form-group">
                                    <input type="hidden" name="logradouro" id="logradouro">
                                    <input type="hidden" name="complemento" id="complemento">
                                    <label>Rua</label>
                                    <input type="text" name="rua" id="rua" size="60" class="form-control"
                                        value="{{old('logradouro')}}" required>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label>Número</label>
                                    <input type="text" name="numero" id="numero" class="form-control"
                                        value="{{old('numero')}}" maxlength="10">
                                </div>
                            </div>
                        </div>
                        <!-- fim terceira linha -->
                        <!-- quarta linha -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Bairro</label>
                                    <input type="text" name="bairro" id="bairro" size="40" class="form-control"
                                        value="{{old('bairro')}}">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Cidade</label>
                                    <input type="text" name="cidade" id="cidade" size="40" class="form-control"
                                        value="{{old('cidade')}}">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Estado</label>
                                    <select id="uf" name="uf" class="form-control" required>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- fim quarta linha -->
                </div>

                <input type="hidden" name="ibge" id="ibge">
            </div>
        </div>

        <!-- card botão cadastrar -->
        <div style=" padding:1%; margin-left:3%; margin-right: 3%;" class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12" style="text-align: center;">
                        <button type="submit" class="btn btn-info" style="width: 50%; margin-top: 1%;">
                            Cadastrar
                            <i class="fas fa-save esconder"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fim card botão cadastrar -->
        <br>
    </div>
    </form>



</div>
</div>
@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">

@endsection

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@endsection

@section('adminlte_js')
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stack('js')
@yield('js')
@stop