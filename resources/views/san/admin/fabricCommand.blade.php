@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de ejecucion de commandos por fabric</h1><hr>
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
        <form action="{{ route('san.fabricCommandStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card collapsed-card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Ayuda</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped table-responsive">
                        <tr>
                            <th>SUPPORT SHOW</th>
                            <td>Entrega un archivo TXT con la ejecución del comando.</td>
                        </tr>
                        <tr>
                            <th>VALIDACIÓN NTP</th>
                            <td>Entrega un archivo TXT con la configuración activa de NTP..</td>
                        </tr>
                        <tr>
                            <th>VALIDACIÓN CONFIGURACIÓN IP</th>
                            <td>Entrega un archivo TXT con la configuración IP de los SW.</td>
                        </tr>
                        <tr>
                            <th>VALIDACIÓN DE USUARIOS</th>
                            <td>Entrega un archivo TXT con la información de cuentas de usuario.</td>
                        </tr>
                        <tr>
                            <th>LIMPIAR ESTADISTICAS</th>
                            <td>Limpia las estadisticas de los puertos y slots de los SW.</td>
                        </tr>
                        <tr>
                            <th>ESTADISTICAS DE ERRORES</th>
                            <td>Entrega un archivo TXT con las estadisticas de errores de puertos en los SW.</td>
                        </tr>
                        <tr>
                            <th>LINK Y MAC ADDRESS</th>
                            <td>Entrega un archivo TXT con el estado del LINK y la MAC ADDRESS de la interfaz ethernet en los SW.</td>
                        </tr>
                        <tr>
                            <th>UPTIME SWITCH</th>
                            <td>Entrega un archivo TXT on la información del tiempo activo del SW desde el ultimo reinicio.</td>
                        </tr>
                        <tr>
                            <th>VALIDACION NOMBRE DE PUERTOS</th>
                            <td>Entrega un archivo TXT con la información de los nombres de los puertos y cuales se encuentran libres.</td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de ejecucion de commandos por fabric</h3>
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
                                <label for="fabric">{{ __('Seleccione el fabric') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="fabric" id="fabric" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        @foreach ($fabrics as $fabric)
                                            <option value="{{ $fabric->fabric }}">{{ $fabric->fabric }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="switch">{{ __('Seleccione el switch') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="switch" id="switch" class="form-control" style="width: 100%" required>
                                        <option value="0" selected>Todos</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="command">{{ __('Seleccione el comando') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="command" id="command" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="1">ESTADISTICAS DE ERRORES</option>
                                        <option value="2">LIMPIAR ESTADISTICAS</option>
                                        <option value="3">LINK Y MAC ADDRESS</option>
                                        <option value="4">SUPPORT SHOW</option>
                                        <option value="5">UPTIME SWITCH</option>
                                        <option value="6">VALIDACIÓN NTP</option>
                                        <option value="7">VALIDACIÓN CONFIGURACIÓN IP</option>
                                        <option value="8">VALIDACIÓN DE USUARIOS</option>
                                        <option value="9">VALIDACION NOMBRE DE PUERTOS</option>
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
        @include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#fabric').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#switch').select2();
            $('#command').select2({
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
                            $('#cargando').modal('show');
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
            $("#fabric").change(function(){
                var fabric = $('#fabric').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('san.fabricCommand') }}',
                    dataType: 'json',
                    data: {
                        'fabric': fabric,
                    },
                    success: function (data) {
                        $('#switch').empty();
                        var select = '<option value="0">Todos</option>'
                        for (var i=0; i<data.length;i++){
                            if(data[i] !== null){
                                select+='<option value="'+data[i].sw+'">'+data[i].sw+'</option>';
                            }
                        }
                        $("#switch").html(select);
                    },
                    error: function (data) {
                        //console.log('error');
                        var errors = data.responseJSON;
                        if (errors) {
                            $.each(errors, function (i) {
                                console.log(errors[i]);
                            });
                        }
                    }
                });
            });
        });
    </script>
@stop

