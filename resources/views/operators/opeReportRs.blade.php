@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de descarga de informes mensuales</h1><hr>
@stop
@section('content')
    @can('operator-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>


        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de descarga de informes mensuales</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td colspan="2">
                            <legend>Datos básicos</legend>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="{{ route("operators.opeReportFile","Informe.docx") }}"><button class="btn btn-large btn-danger"><i class="fa fa-download"></i> Descargar archivo DOCX de resultado</button></a>
                        </td>
                        <td>
                            <a href="{{ route("operators.opeReportFile","Archivo_Sin_Resultados.xlsx") }}"><button class="btn btn-large btn-danger"><i class="fa fa-download"></i> Descargar archivo XLSX de resultado</button></a>
                        </td>
                    </tr>

                </table>
            </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
