@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de actualización</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('windowsEN-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('windows.updateSOStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de actualización</h3>
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
                                    <select name="host[]" id="host" class="form-control" multiple="multiple" style="width: 100%" required ></select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="item">{{ __('Fuente del archivo de actualización') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="item" id="item" class="form-control" required>
                                        <option value="archivo">Archivo</option>
                                        <option value="ftp">FTP</option>
                                        <option value="url">URL</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ruta">{{ __('Ruta') }}</label>
                            </td>
                            <td>
                                <input type="text" name="ruta" id="ruta" class="form-control input-md" value="{{ old('ruta') }}" maxlength="250"
                                           pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,}" placeholder="C:\temp\Nombre_del_KB.msu" required>
                            </td>
                        </tr>
                        <tr id="uri" style="display: none">
                            <td>
                                <label for="url">{{ __('URL') }}</label>
                            </td>
                            <td>
                                <input type="text" name="url" id="url" class="form-control input-md" value="{{ old('url') }}" maxlength="250"
                                           pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,}" placeholder="ftp://172.22.88.34/Nombre_del_KB.msu">
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
            $("#item").change(function(){
                var sel = $(this).val()
                if(sel == 'archivo'){
                    $('#uri').hide();
                    $('#url').prop('disabled', true);
                }else{
                    $('#uri').show();
                    $('#url').prop('disabled', false);
                    $('#url').prop('required', true);
                }
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
