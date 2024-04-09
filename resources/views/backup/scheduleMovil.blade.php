@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de validación de schedule de la movil<hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('backup-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form enctype="multipart/form-data" action="{{ route('backup.scheduleMovilStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de schedule de la movil</h3>
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
                                <label for="schedule">{{ __('Archivo de schedule sin rellenar') }}</label>
                            </td>
                            <td>
                                <input accept="file_extension|.html" type="file" name="schedule" id="schedule" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="report">{{ __('Archivo de validación') }}</label>
                            </td>
                            <td>
                                <input accept="file_extension|.html" type="file" name="report" id="report" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dateRep">{{ __('Fecha de validación') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="text" name="dateRep" id="dateRep" class="form-control input-md" value="{{ old('dateRep') }}"
                                        pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly>
                                </div>
                            </td>
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
            $('#dateRep').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2020-11-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            })
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
