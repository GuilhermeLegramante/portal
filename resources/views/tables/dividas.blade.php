@extends('adminlte::page')

@section('title', 'hsContracheque - Dívidas Segurado')

@section('content_header')

@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><i class="fas fa-notes-medical"></i> Dívidas do Segurado</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                class="fas fa-laptop-house"></i>
                            Meus Dados</a></li>
                    <li class="breadcrumb-item active"><i class="fas fa-notes-medical"></i> Dívidas do Segurado</li>
                </ol>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>

@livewire('table-dividas')

@include('includes.float-menu.dividas')



@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
<script src="{{asset('js/custom.js')}}"></script>
@stop
