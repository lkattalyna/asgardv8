@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de modificación de rutas estáticas</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Input-Mask', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can($permiso)
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ $rutaStore }}" method="post" id="formfield">
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
                                <label for="host">{{ __('Hosts') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="host[]" multiple id="host" class="form-control" style="width: 100%" required>
                                        @foreach ($hosts as $host)
                                            <option value="{{ $host }}">{{ $host }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="item">{{ __('Acción') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="item" id="item" class="form-control" required>
                                        <option value="" disabled selected>--Seleccione--</option>
                                        <option value="adds">Agregar</option>
                                        <option value="deletes">Remover</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="destination">{{ __('Destino') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="destination" id="destination" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr id="gate">
                            <td>
                                <label for="gateway">{{ __('Gateway') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="gateway" id="gateway" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr id="mas">
                            <td>
                                <label for="mask">{{ __('Mascara') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="mask" id="mask" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr id="met">
                            <td>
                                <label for="metric">{{ __('Metrica') }}</label>
                            </td>
                            <td>
                                <input type="number" name="metric" id="metric" class="form-control">
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
@include('vistasReutilizables.partials.scripts.configBasicForm')
    <script>
        $(document).ready(function() {
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
            $("#item").change(function(){
                var item = $(this).val()
                if(item == 'adds'){
                    $("#gate").show();
                    $("#met").show();
                    $("#mas").show();
                    $("#gateway").prop('disabled',false);
                    $("#mask").prop('disabled',false);
                    $("#metric").prop('disabled',false);
                    $("#gateway").prop('required',true);
                    $("#mask").prop('required',true);
                    // $("#metric").prop('required',true);
                }else{
                    $("#gate").hide();
                    $("#met").hide();
                    $("#mas").hide();
                    $("#gateway").prop('disabled',true);
                    $("#mask").prop('disabled',true);
                    $("#metric").prop('disabled',true);
                    $("#gateway").prop('required',false);
                    $("#mask").prop('required',false);
                    $("#metric").prop('required',false);
                }
            });
        });
    </script>
@stop
