@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de descarga de de validación schedule de la movil</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('backup-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>


        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de descarga de validación schedule de la movil</h3>
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
                            <a href="{{ route("backup.backupTaskFile","schedule_final.xlsx") }}"><button class="btn btn-large btn-danger"><i class="fa fa-download"></i> Descargar archivo de resultado</button></a>
                        </td>
                    </tr>

                </table>
            </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
