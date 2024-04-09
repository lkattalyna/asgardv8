@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de registro de automatizaciones</h1><hr>
@stop
@section('content')
    @can('regImprovement-list')
        <div class="card card-default">
            <div class="card-body">
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Bienvenido al modulo de registro de automatizaciones</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <p>Por favor seleccione la opción que se ajusta a lo que desea hacer</p>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a href="#" title="Eliminar" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete">
                    <span class="fa fa-clock fa-1x"></span>&nbsp La automatización ya se encuentra registrada
                </a>
                <a href="{{ route('improvements.create') }}" class="btn btn-sm btn-danger">
                    <span class="fa fa-plus fa-1x"></span>&nbsp Nueva automatización sin registro
                </a>
            </div>
        </div>
        <!-- /.card -->
        <!-- Modal-->
        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Mensaje Importante</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Actualmente las automatizaciones ya registradas en Asgard o en el portal de automatizaciones estan pasando por un proceso de migración
                        a la plataforma Asgard, una vez sean migrados se habilitaran los modulos para documentar los procesos, agradecemos su comprensión</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN modal-->
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
