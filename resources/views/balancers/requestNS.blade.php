@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación y envío CSR en NetScaler ADC</h1><hr>
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
        <form action="{{ route('balancers.requestNSStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación y envío CSR en NetScaler ADC</h3>
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
                                <label for="ou">{{ __('(OU) Unidad Organizacional') }}</label>
                            </td>
                            <td>
                                <input type="text" name="ou" id="ou" class="form-control input-md" value="{{ old('ou') }}" maxlength="100"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Sistemas" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ciudad">{{ __('Ciudad') }}</label>
                            </td>
                            <td>
                                <input type="text" name="ciudad" id="ciudad" class="form-control input-md" value="{{ old('ciudad') }}" maxlength="100"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Bogotá" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="correo">{{ __('Correo') }}</label>
                            </td>
                            <td>
                                <input type="email" name="correo" id="correo" class="form-control input-md" value="{{ old('correo') }}" placeholder="example@example.com">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dpto">{{ __('Departamento') }}</label>
                            </td>
                            <td>
                                <input type="text" name="dpto" id="dpto" class="form-control input-md" value="{{ old('dpto') }}" maxlength="100"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="D.C." required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="nomcomun">{{ __('Nombre de Dominio (CN)') }}</label>
                            </td>
                            <td>
                                <input type="text" name="nomcomun" id="nomcomun" class="form-control input-md" value="{{ old('nomcomun') }}" maxlength="100"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="organizacion">{{ __('Nombre de la Organización') }}</label>
                            </td>
                            <td>
                                <input type="text" name="organizacion" id="organizacion" class="form-control input-md" value="{{ old('organizacion') }}" maxlength="100"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Comunicacion Celular SA Comcel SA" required>
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
