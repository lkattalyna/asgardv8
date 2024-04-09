@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de LB-virtual server NS</h1><hr>
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
        <form action="{{ route('balancers.addVSNSStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de LB-virtual server NS</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td colspan="2">
                                <h3 class="card-title">Datos Virtual Server</h3>
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
                                <label for="name">{{ __('Nombre LB-VirtualServer:') }}</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="name" class="form-control input-md" value="{{ old('name') }}" maxlength="40"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,40}" placeholder="Nombre del servicio (Sin espacios)" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ipVS">{{ __('Dirección IP LB-VS') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="ipVS" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="portVS">{{ __('Número de Puerto') }}</label>
                            </td>
                            <td>
                                <input type="number" name="portVS" id="portVS" class="form-control input-md" value="80" placeholder="Puerto"  required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="group">{{ __('Tipo de servicio') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="vsProtocol" id="vsProtocol" class="form-control" required>
                                        <option value="ANY">ANY</option>
                                        <option value="FTP">FTP</option>
                                        <option value="HTTP" selected>HTTP</option>
                                        <option value="SSL">SSL</option>
                                        <option value="SSL_BRIDGE">SSL_BRIDGE</option>
                                        <option value="SSL_TCP">SSL_TCP</option>
                                        <option value="TCP">TCP</option>
                                        <option value="UDP">UDP</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vsDomain">{{ __('Traffic domain ID') }}</label>
                            </td>
                            <td>
                                <input type="number" name="vsDomain" id="vsDomain" class="form-control input-md" value="0" min="0" max="99" placeholder="0" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cServer">{{ __('Cantidad de servidores') }}</label>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="cServer" id="cServer1" value="1">
                                      <label class="form-check-label">1</label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="radio" name="cServer" id="cServer2" value="2">
                                      <label class="form-check-label">2</label>
                                    </div>
                                  </div>
                            </td>
                            <tr>
                                <td>
                                    <label for="portN">{{ __('Número de puerto de servicio') }}</label>
                                </td>
                                <td>
                                    <input type="number" name="portN" id="portN" class="form-control input-md" value="{{ old('portN') }}" placeholder="Puerto servicio"  required>
                                </td>
                            </tr>
                        </tr>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover" id="mytable" >
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Servidores</th>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <th>IP</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="data">
                        </tbody>
                    </table>
                    <hr>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i> Ejecutar
                    </button>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover" >
                    <tr>
                        <td colspan="2">
                            <h3 class="card-title">Datos de los nodos</h3>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="nameN">{{ __('Nombre del servidor') }}</label>
                        </td>
                        <td>
                            <input type="text" id="nameN" class="form-control input-md" value="{{ old('nameN') }}" maxlength="40"
                                placeholder="Nombre del nodo" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="ipN" >{{ __('Dirección IP') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                </div>
                                <input type="text" id="ipN" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-danger" id="btnAdd">Agregar servidor</button>
            </div>
        </div>
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
            var i = 1; //contador para asignar id al boton que borrara la fila
            var cRows = 1;
            $('#btnAdd').click(function() {
                var cServer = $('input:radio[name=cServer]:checked').val();
                if(cRows >= 0 && cRows <= cServer){
                    var nombre = document.getElementById("nameN").value;
                    var ip = document.getElementById("ipN").value;
                    if( nombre != '' && ip != ''){
                        var fila = '<tr id="row' + i + '">';
                        fila += '<td>' + nombre + '</td>';
                        fila += '<td>' + ip + '</td>';
                        fila += '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td>';
                        fila += '<input type="hidden" name="nodos[]" value="'+nombre+'*'+ip+'"></tr>';
                        i++;
                        $('#mytable tr:last').after(fila);
                        $("#data").append();
                        document.getElementById("nameN").value ="";
                        document.getElementById("ipN").value = "";
                        cRows++;
                    }
                }
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
                cRows--;
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
