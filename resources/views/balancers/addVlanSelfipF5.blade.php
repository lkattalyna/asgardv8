@extends('adminlte::page')
@section('content_header')
    <h1>Formulario Creación Vlan y Selfip F5</h1><hr>
@stop
@section('plugins.Input-Mask', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')
        {{-- <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div> --}}
        @include('layouts.formError')
        <form action="{{ route('balancers.addVlanSelfipF5Store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos Creación Vlan y Selfip F5</h3>
                </div>
{{--                 <div class="card-header with-border">
                    <h3 class="card-title">Datos Virtual Server</h3>
                </div> --}}
                <div class="card-body">
                    <table class="table table-bordered table-hover">
{{--                         <tr>
                            <td colspan="2">
                                <h3 class="card-title">Datos Virtual Server</h3>
                            </td>
                        </tr> --}}
                        <tr>
                            <td>
                                <label for="host">{{ __('Host') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="host" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="address">{{ __('Dirección selfip') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="address" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="mask">{{ __('Máscara') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-laptop"></i></span>
                                    </div>
                                    <input type="text" name="mask" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="name_vlan">{{ __('Nombre de la Vlan') }}</label>
                            </td>
                            <td>
                                <input type="text" name="name_vlan" id="name_vlan" class="form-control input-md" value="{{ old('name_vlan') }}" maxlength="40"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,40}" placeholder="Nombre Vlan" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="tag">{{ __('Tag Vlan') }}</label>
                            </td>
                            <td>
                                <input type="text" name="tag" id="tag" class="form-control input-md" value="{{ old('tag') }}" maxlength="40"
                                pattern="^[0-999999]*$" placeholder="Tag Vlan" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="interface">{{ __('Interface') }}</label>
                            </td>
                            <td>
                                <input type="text" name="interface" id="interface" class="form-control input-md" value="{{ old('interface') }}" maxlength="40"
                                pattern="^[0-999999,.]*$" placeholder="Interface" required>
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

            //Jquery para cargar el host mediante el grupo
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

/*             var i = 1; //contador para asignar id al boton que borrara la fila
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
            }); */
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
