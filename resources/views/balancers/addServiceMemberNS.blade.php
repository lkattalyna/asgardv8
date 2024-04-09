@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de vinculación nuevo member en grupo de servicio NS</h1><hr>
@stop
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
        <form action="{{ route('balancers.addServiceMemberNSStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de vinculación nuevo member en grupo de servicio NS</h3>
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
                                        <option></option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group }}">{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="sgroup">{{ __('Grupo de servicio') }}</label>
                            </td>
                            <td>
                                <input type="text" name="sgroup" id="sgroup" class="form-control input-md" value="{{ old('sgroup') }}" maxlength="50"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" placeholder="Grupo de servicio" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="nserver">{{ __('Nombre del servidor') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="nserver" id="nserver" class="form-control input-md" value="{{ old('nserver') }}" maxlength="50"
                                            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" placeholder="Servidor" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                                title="Ayuda" data-content="El servidor debe existir o ser creado en el siguiente <a href='{{ route('balancers.addServerNS') }}'>enlace</a>">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="port">{{ __('Número de puerto de servicio') }}</label>
                            </td>
                            <td>
                                <input type="number" name="port" id="port" class="form-control input-md" value="{{ old('port') }}" placeholder="Puerto"  required>
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
            $('[data-toggle="popover"]').popover();
            $('#group').select2({
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
