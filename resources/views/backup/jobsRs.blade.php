@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de verificación</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('backup-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn btn-sm btn-danger" href="{{ route('backup.jobs') }}">
                        <i class="fas fa-reply"></i>&nbsp Volver
                    </a>
                </div>
            </div>
        </div>


        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de resultados </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td colspan="2">
                            <legend>Detalles tecnicos de la maniobra</legend>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:green">Resultado</td>
                        <td>{{ $exec }}</td>

                    </tr>


                </table>
            </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
