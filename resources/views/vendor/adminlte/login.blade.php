@extends('adminlte::master')

@section('adminlte_css_pre')
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

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
<div class="login-page" style="background-image: url('vendor/adminlte/dist/img/analytics-solutions.jpg');
    background-size: cover; width:100%;">
    <div class="login-box" style="border-radius: 12px; background: #ffffff; opacity: 100%; position: absolute; z-index: 99;">
        @include('partials.login-logo-and-text')


        <div class="card">
            <div class="card-body login-card-body" style="opacity: 200%;">
                <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="cpf" class="form-control" value="{{ old('cpf') }}"
                            placeholder="Seu CPF" onblur="javascript: formatarCampo(this);" maxlength="14" autofocus required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="senha" class="form-control" placeholder="Sua senha" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('resgateSenha') }}">
                                Esqueci Minha Senha / Primeiro Acesso
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                {{ __('adminlte::adminlte.sign_in') }}
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                @include('includes.copyright')
            </div>
        </div>
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