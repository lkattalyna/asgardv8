@extends('adminlte::page')
@section('content_header')
    <h1> Inventario de plataformas de virtualización</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('virtualization-run')
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Inventario de plataformas de virtualización</h3>
            </div>
            <div class="card-body">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item"
                    src="https://app.powerbi.com/view?r=eyJrIjoiNGZmNDk4NGEtMTdlMy00ZGExLTlmZjAtOTk1Zjc1ZDg4ZTBhIiwidCI6IjQ2YmIyMmI4LTRjMmMtNDBmZi04MzYwLTdiNjMzNDgyMTI3OSIsImMiOjR9"></iframe>
                  </div>
            </div>

        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
