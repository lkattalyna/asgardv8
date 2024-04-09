@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta de estados de puerto</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        @include('layouts.messages')
        <form action="{{ route('san.portStateStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de consulta de estados de puerto</h3>
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
                                <label for="sw">{{ __('SW SAN') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="sw" id="sw" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        @foreach ($sws as $sw)
                                            <option value="{{ $sw->ip }}">{{ $sw->sw }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="getSlot">{{ __('Consultar pór Slot') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="getSlot" id="getSlot" class="form-control" required>
                                        <option value="0" selected>No</option>
                                        <option value="1">Si</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id="trSlot" style="display: none">
                            <td>
                                <label for="slot">{{ __('Número de slot') }}</label>
                            </td>
                            <td>
                                <input type="number" name="slot" id="slot" class="form-control input-md" value="{{ old('slot') }}" placeholder="Slot" disabled>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="port">{{ __('Número de puerto') }}</label>
                            </td>
                            <td>
                                <input type="number" name="port" id="port" class="form-control input-md" value="{{ old('port') }}" placeholder="Para consultar todos ingrese 00 (cerocero)"  required>
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
            $('#sw').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#getSlot').on('change', function(){
                var slot = $(this).val();
                if(slot == 1){
                    $('#trSlot').show();
                    $('#slot').prop('required',true);
                    $('#slot').prop('disabled',false);
                }
                if(slot == 0){
                    $('#trSlot').hide();
                    $('#slot').prop('required',false);
                    $('#slot').prop('disabled',true);
                }
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

