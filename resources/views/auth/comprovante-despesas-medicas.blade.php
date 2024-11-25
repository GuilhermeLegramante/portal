@extends('adminlte::page')

@section('title', 'hsPortal - CRP')

@section('content_header')

@endsection

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-hand-holding-usd"></i> Comprovante Despesas Médicas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-laptop-house"></i>
                            Início</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-hand-holding-usd"></i> Comprovante de
                        Rendimentos Pagos</li>
                </ol>
            </div>
        </div>
    </div>
</div>

@livewire('comprovante-despesas-medicas-component')

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
