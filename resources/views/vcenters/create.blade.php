@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de vcenter</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Input-Mask', true)
@section('content')
    @can('devState-create')
        <div class="card card-default">
            <div class="card-header">
                <div class="card-tools pull-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('vcenters.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('vcenters.store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de vcenter</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="segment" class="text-md-right">Segmentos</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <select name="segment" id="segment" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="1">Empresas Y Negocios</option>
                                        <option value="2">Personas Y Hogares</option>
                                        <option value="3">Convergencia</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="login" class="text-md-right">Cuenta Login</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <select name="login" id="login" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="1">datacenterdhs\asgard.cli</option>
                                        <option value="2">claroco\dfgftcla1</option>
                                        <option value="3">co-attla\ctxadmin</option>                                    
                                        <option value="4">root</option>
                                        <option value="6">asgard.cli@vsphere.local</option>
                                        <option value="8">cloudclaro\asgard.cli</option>
                                        <option value="9">COLCLOUD\vmwarepowercli</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ip">{{ __('Ip del vcenter') }}</label>
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
                            <th>
                                <label for="alias" class="text-md-right">Digite alias del vcenter</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="alias" id="alias" class="form-control" value="{{ old('alias') }}"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Ingrese manualmente el ALIAS" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="status" class="text-md-right">Estado Vcenter</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <select name="status" id="status" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="1">Encendido</option>
                                        <option value="0">Apagado</option>
                                    </select>
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-save"></i> Guardar
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
            $('#segment').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#login').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#status').select2({
                placeholder: "--Seleccione--",
                allowClear: true
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

