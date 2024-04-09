@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de ejecución de comandos remotos</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Input-Mask', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('virtualization-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        @include('layouts.messages')
        <form action="{{ route('virtualization.commandExeStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de ejecución de comandos remotos</h3>
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
                                <label for="type">{{ __('Tipo de comando') }}</label>
                            </td>
                            <td>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="ESXi">ESXi</option>
                                    <option value="PowerCLi" selected>PowerCLi</option>
                                </select>
                            </td>
                        </tr>
                        <tr id="vcenterTr">
                            <td>
                                <label for="cluster">{{ __('VCenter') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="vCenter" id="vCenter" style="width: 100%" required>
                                        <option></option>
                                        @foreach($vCenters as $vCenter)
                                            <option value="{{ $vCenter['ProductIP'] }}">{{ $vCenter['ProductAlias'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id="hostTr" style="display: none">
                            <td>
                                <label for="host">{{ __('Host') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="host" id="host" style="width: 100%">
                                        <option></option>
                                        @foreach($hosts as $host)
                                            <option value="{{ $host->vcenter }},{{ $host->host_id }}">{{ $host->vcenter }} / {{ $host->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="command" class="text-md-right">Digite el comando</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="command" id="command" class="form-control" value="{{ old('command') }}"
                                        placeholder="Solo se permiten comandos Get" required>
                                </div>
                            </td>
                        </tr>

                        @can('virtualization-admin')

                        @endcan
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
            $('#vCenter').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#type').on('change', function(){
                var val = $(this).val();
                if(val === "ESXi"){
                    $("#hostTr").show();
                    $("#vcenterTr").hide();
                    $("#host").prop('required', true);
                    $("#vCenter").prop('required', false);
                }else{
                    $("#hostTr").hide();
                    $("#vcenterTr").show();
                    $("#host").prop('required', false);
                    $("#vCenter").prop('required', true);
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
