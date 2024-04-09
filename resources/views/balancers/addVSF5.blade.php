@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de virtual server F5</h1><hr>
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
        <form action="{{ route('balancers.addVSF5Store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de virtual server F5</h3>
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
                                <label for="host">{{ __('Hosts') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="host" id="host" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="name">{{ __('Nombre del servicio') }}</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="name" class="form-control input-md" value="{{ old('name') }}" maxlength="40"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,40}" placeholder="Nombre del servicio (Sin espacios)" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="description">{{ __('Descripción') }}</label>
                            </td>
                            <td>
                                <input type="text" name="description" id="description" class="form-control input-md" value="{{ old('description') }}" maxlength="40"
                                        placeholder="Descripción">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ipVS">{{ __('IP virtual server') }}</label>
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
                                <label for="portVS">{{ __('Puerto virtual server') }}</label>
                            </td>
                            <td>
                                <input type="number" name="portVS" id="portVS" class="form-control input-md" value="{{ old('portVS') }}" placeholder="Puerto"  required>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover" id="mytable" >
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Nodos</th>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <th>IP</th>
                                <th>Puerto</th>
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
                            <label for="nameN">{{ __('Nombre del nodo') }}</label>
                        </td>
                        <td>
                            <input type="text" id="nameN" class="form-control input-md" value="{{ old('nameN') }}" maxlength="40"
                                placeholder="Nombre del nodo" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="ipN" >{{ __('IP del nodo') }}</label>
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
                    <tr>
                        <td>
                            <label for="portN">{{ __('Puerto del nodo') }}</label>
                        </td>
                        <td>
                            <input type="number" id="portN" class="form-control input-md" placeholder="Puerto de nodo">
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-danger" id="btnAdd">Agregar nodo</button>
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
            var servidor ='';
            $("#group").change(function(){
                var grupo = $(this).val()
                $.get('getHosts/'+{{ $inventario }}+'/'+grupo+'/local', function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = '<option value="'+grupo+'">Todos</option>'
                    var estado = '';

                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            $.get('getBalancerState/'+ data[i], function(status){
                                if(status == 'active'){
                                    servidor = data[i-1];
                                }
                                if(servidor != ''){
                                    $('#host').val(servidor);
                                }
                            }).fail(function() {
                                $('#host').val('Host inaccesible');
                            });
                        }
                    }
                });
            });
            var i = 1; //contador para asignar id al boton que borrara la fila
            $('#btnAdd').click(function() {
                var nombre = document.getElementById("nameN").value;
                var ip = document.getElementById("ipN").value;
                var puerto = document.getElementById("portN").value;
                if( nombre != '' && ip != '' && puerto != ''){
                    var fila = '<tr id="row' + i + '">';
                    fila += '<td>' + nombre + '</td>';
                    fila += '<td>' + ip + '</td>';
                    fila += '<td>' + puerto + '</td>';
                    fila += '<td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-trash"></i></button></td>';
                    fila += '<input type="hidden" name="nodos[]" value="'+nombre+'*'+ip+'*'+puerto+'"></tr>';
                    i++;
                    $('#mytable tr:last').after(fila);
                    $("#data").append();
                    document.getElementById("nameN").value ="";
                    document.getElementById("ipN").value = "";
                    document.getElementById("portN").value = "";
                }
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
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
