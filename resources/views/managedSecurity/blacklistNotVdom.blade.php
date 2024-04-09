@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de blacklist firewall sin vdom</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Input-Mask', true)
@section('content')
    @can('ManagedSecurity-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form enctype="multipart/form-data" action="{{ route('managedSecurity.blacklistNotVdomStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de blacklist firewall sin vdom</h3>
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
                                    <select name="group" id="group" class="form-control" style="width: 100%">
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
                                <label for="op">Tipo Direccionamiento</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="op" id="op" class="form-control" required>
                                        <option selected disabled>-- Seleccione --</option>
                                        <option value="1">Unico</option>
                                        <option value="2">Multiple</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id="ipUnico">
                            <td>
                                <label for="ip">{{ __('Ip del host') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="ip" id="ip" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true">
                                </div>
                            </td>
                        </tr>
                        <tr id="ipMultiple">
                            <td>
                                <label for="file">{{ __('Seleccione el archivo') }}</label>
                            </td>
                            <td>
                                <input accept="file_extension|.txt" type="file" name="file" id="file" >
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
            $("#ipUnico").hide();
            $("#ipMultiple").hide();
            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#op').change(function(){
                var selectValue = $(this).val();
                switch (selectValue) {
                    case "1":
                        $("#ipUnico").show();
                        $("#ipMultiple").hide();
                    break;
                    case "2":
                        $("#ipMultiple").show();
                        $("#ipUnico").hide();
                    break;
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

