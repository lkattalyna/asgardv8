@extends('adminlte::page')

@section('title', 'Consultar automatizaciones')

@section('content_header')
    <h1>Consultar Solicitud de Iniciativas de Automatizacion</h1>
    <hr>
@stop

@section('plugins.Datatables', true)

@section('content')
    @can('regImprovement-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regImprovement-create')
                    <div class="btn-group" role="group" aria-label="Actions">
                        <a href="{{ route('initiative.create') }}" class="btn btn-sm btn-danger">
                            <span class="fa fa-plus fa-1x"></span>&nbsp Nueva Iniciativa
                        </a>
                    </div>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
            <!-- Nueva solicitud
            <div class="card-body">
                @can('...')
                    <div class="btn-group" role="group" aria-label="Actions">
                        <a href="{{ route('') }}" class="btn btn-sm btn-danger">
                            <span class="fa fa-plus fa-1x"></span>&nbsp Nueva solicitud Automatización
                        </a>
                    </div>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>

        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Iniciativas Registradas en el Sistema</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Segmento de servicio</th>
                            <th>Torre</th>
                            <th>Nombre de Iniciativa</th>
                            <th>Fecha de Registro</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí va tu código de iteración -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
    <script>
        $(document).ready(function () {
            // Tu código JavaScript aquí
        });
    </script>
@stop
 -->


