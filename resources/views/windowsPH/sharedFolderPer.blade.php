@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de asignación de permisos a carpetas compartidas</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('windowsPH-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.messages')
        @include('layouts.formError')
        <form action="{{ route('windowsPH.sharedFolderPerStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de asignación de permisos a carpetas compartidas</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td colspan="2">
                                <legend>Datos básicos</legend>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="username" class="text-md-right">Usuario o Usuarios</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}"
                                        placeholder="ECM1234J,ECM4321K,ECM4568W" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="domain">{{ __('Carpeta compartida en') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="domain" id="domain" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="COLBTADC01.co.attla.corp">CO-ATTLA</option>
                                        <option value="WDCBOG01.comcel.com.co">COMCEL</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="folder">{{ __('Carpeta') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="folder" id="folder" class="form-control" style="width: 100%" required>
                                        <option></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="permission">{{ __('Tipo de permiso') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="permission" id="permission" class="form-control" required>
                                        <option value="1">Colaborador</option>
                                        <option value="2" selected>Lectura</option>
                                    </select>
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
                                        <option value="present" selected>Agregar permiso</option>
                                        <option value="absent">Retirar permiso</option>
                                    </select>
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
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#domain').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#folder').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $("#domain").change(function(){
                var domain = $(this).val()
                $.get('getSharedFolders/'+domain, function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = ''
                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            select+='<option value="'+data[i].folder_name+'">'+data[i].show+'</option>';
                        }
                    }
                    $("#folder").html(select);
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

