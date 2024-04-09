@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de modificación de rutas estáticas</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Input-Mask', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('unixEN-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('unix.rutasEstaticasStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de modificación de rutas estáticas</h3>
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
                                <label for="group">{{ __('Grupo de inventario') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="group" id="group" class="form-control" style="width: 100%" required>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group }}">{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="host">{{ __('Hosts') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="host[]" id="host" class="form-control" multiple="multiple" style="width: 100%" required></select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="action">{{ __('Acción') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="action" id="action" class="form-control" required>
                                        <option value="" disabled selected>--Seleccione--</option>
                                        <option value="add">Add</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="interface">{{ __('Interfase') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="interface" id="interface" class="form-control" required>
                                        <option value="" disabled selected>--Seleccione--</option>
                                        <option value="Gestion">Gestion</option>
                                        <option value="Servicio">Servicio</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ip">{{ __('Ip') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="ip" id="ip" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="mask">{{ __('Mascara') }}</label>
                            </td>
                            <td>
                                <input type="number" name="mask" id="mask" class="form-control" required>
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
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $("#group").change(function(){
                var grupo = $(this).val()
                $.get('getHosts/'+{{ $inventario }}+'/'+grupo+'/local', function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = '<option value="'+grupo+'">Todos</option>'
                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            select+='<option value="'+data[i]+'">'+data[i]+'</option>';
                        }
                    }
                    $("#host").html(select);
                });
            });
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
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
        });
    </script>
@stop
