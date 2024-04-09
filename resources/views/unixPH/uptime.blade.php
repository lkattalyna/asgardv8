@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de reporte uptime</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('unixPH-run')
    <div class="card card-default">
        <div class="card-header with-border" style="background: #dfe1e4;">
            <h3 class="card-title">Reporte Uptime</h3>
        </div>
        <div class="card-body">
            <div class="embed-responsive embed-responsive-21by9">
                <iframe class="embed-responsive-item"
                src="http://172.18.90.250:82/UNX_PH_012_Uptime/"></iframe>
              </div>
        </div>

    </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
