@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de gestion de zonas GTM F5</h1><hr>
@stop
@section('plugins.Input-Mask', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('balancers.nodosGTMF5Store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de gestion de zonas GTM F5</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="host">{{ __('Hosts') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="host" id="host" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        @foreach ($hosts as $host)
                                            <option value="{{ $host->name_host }}">{{ $host->name_host }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ipGTM">{{ __('IP Virtual Server') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="ipGTM" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="server">{{ __('Nombre del servidor') }}</label>
                            </td>
                            <td>
                                <input type="text" name="server" id="server" class="form-control input-md" value="{{ old('server') }}" maxlength="50"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" placeholder="Nombre del servidor" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="status">{{ __('Estado') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="status" id="status" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="disabled">Disabled</option>
                                        <option value="enabled">Enabled</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vs">{{ __('Nombre del virtual server') }}</label>
                            </td>
                            <td>
                                <input type="text" name="vs" id="vs" class="form-control input-md" value="{{ old('vs') }}" maxlength="50"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" placeholder="Nombre del virtual server" required>
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
            $('#status').select2({
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
