@extends('adminlte::page')
@section('content_header')
    <h1> Declaratoria de incidente</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @include('layouts.formError')
    <div class="content-header">
        <div class="container-fluid">
                <h1>Importante</h1><hr>
        </div>
    </div>
@stop
@section('js')
    <script>

    </script>
@endsection
