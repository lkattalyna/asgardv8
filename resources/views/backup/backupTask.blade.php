@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de validación de ventana de backup</h1><hr>
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
        @include('layouts.formError')
        @include('layouts.messages')
        <form enctype="multipart/form-data" action="{{ route('backup.backupTaskStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de validación de ventana de backup</h3>
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
                                <label for="report">{{ __('Archivo de reporte revisión ventana') }}</label>
                            </td>
                            <td>
                                <input accept="file_extension|.xls, .xlsx" type="file" name="report" id="report" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="master">{{ __('Archivo de maestro de fallas') }}</label>
                            </td>
                            <td>
                                <input accept="file_extension|.xls, .xlsx" type="file" name="master" id="master" required>
                            </td>
                        </tr>
                                <td>
                                    <label for="SMIREIASS">{{ __('Archivo de SMIREIASS') }}</label>
                                </td>
                                <td>
                                    <input accept="file_extension|.xls, .xlsx" type="file" name="SMIREIASS" id="SMIREIASS" required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="SMBACKUP">{{ __('Archivo de SMBACKUP') }}</label>
                                </td>
                                <td>
                                    <input accept="file_extension|.xls, .xlsx" type="file" name="SMBACKUP" id="SMBACKUP" required>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="SMBACKUP">{{ __('Archivo de exception') }}</label>
                                </td>
                                <td>
                                    <input accept="file_extension|.xls, .xlsx" type="file" name="exception" id="exception" required>
                                </td>
                            </tr>


                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i> Ejecutar
                    </button>
                </div>
            </div>
        </form>
        @include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });
            $('#sendForm').on('click', function(){
                swal({
                    title: "¿Esta seguro?",
                    text: "Esta completamente seguro de ejecutar la tarea con los parametros seleccionados",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "Si, estoy seguro"],
                }).then((seguro) => {
                    if (seguro) {
                        if($('#formfield')[0].checkValidity()){
                            $('#formfield').submit();
                            $('#cargando').modal('show');
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
        });
    </script>
@stop
