@extends('adminlte::page')
@section('content_header')
    <h1> Reporte de automatizaciones</h1><hr>
@stop
@section('content')
    @can('report-user')
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Reporte de automatizaciones</h3>
            </div>
            <div class="card-body">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item"
                    src=" https://app.powerbi.com/view?r=eyJrIjoiOTIzM2YxZjUtZTZjZC00NDc2LWFhZTctYWI4NjBiNDRkZDI2IiwidCI6IjQ2YmIyMmI4LTRjMmMtNDBmZi04MzYwLTdiNjMzNDgyMTI3OSIsImMiOjR9&pageName=ReportSection"></iframe>
                  </div>
            </div>

        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
