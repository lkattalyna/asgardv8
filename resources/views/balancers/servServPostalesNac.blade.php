@extends('adminlte::page')
@section('content_header')
    <h1>Formulario Deshabilitación/rehabilitación Servidor 4-72 SERVICIOS POSTALES NACIONALES Citrix NS ADC</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')       
        @include('layouts.formError')
        <form action="{{ Route('balancers.servServPostalesNacStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario Deshabilitación/rehabilitación Servidor 4-72 SERVICIOS POSTALES NACIONALES Citrix NS ADC</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="server">Servidor</label>
                            </td>
                            <td>
                                <div class="input-group">                                    
                                    <select name="server" id="server" class="form-control" required>
                                    <option selected disabled>-- Seleccione --</option>
                                    <option value="TD_1_10.10.105.102">TD_1_10.10.105.102</option>
                                    <option value="TD_1_10.10.105.103">TD_1_10.10.105.103</option>
                                    <option value="TD_1_10.10.105.110">TD_1_10.10.105.110</option>
                                    <option value="TD_1_10.10.105.111">TD_1_10.10.105.111</option>
                                    <option value="TD_1_172.18.173.26">TD_1_172.18.173.26</option>
                                    <option value="TD_1_172.18.173.27">TD_1_172.18.173.27</option>
                                    <option value="TD_1_172.18.173.4">TD_1_172.18.173.4</option>
                                    <option value="TD_1_172.18.173.5">TD_1_172.18.173.5</option>
                                    <option value="TD_1_172.18.173.6">TD_1_172.18.173.6</option>
                                    <option value="TD_1_172.18.173.7">TD_1_172.18.173.7</option>
                                    <option value="TD_1_172.18.174.10">TD_1_172.18.174.10</option>
                                    <option value="TD_1_172.18.174.14">TD_1_172.18.174.14</option>
                                    <option value="TD_1_172.18.174.2">TD_1_172.18.174.2</option>
                                    <option value="TD_1_172.18.174.27_app1">TD_1_172.18.174.27_app1</option>
                                    <option value="TD_1_172.18.174.28_app2">TD_1_172.18.174.28_app2</option>
                                    <option value="TD_1_172.18.174.29_app3">TD_1_172.18.174.29_app3</option>
                                    <option value="TD_1_172.18.174.3">TD_1_172.18.174.3</option>
                                    <option value="TD_1_172.18.174.30_app4">TD_1_172.18.174.30_app4</option>
                                    <option value="TD_1_172.18.174.31_app5">TD_1_172.18.174.31_app5</option>
                                    <option value="TD_1_172.18.174.4">TD_1_172.18.174.4</option>
                                    <option value="TD_1_172.18.174.5">TD_1_172.18.174.5</option>
                                    <option value="TD_1_172.18.174.6">TD_1_172.18.174.6</option>
                                    <option value="TD_1_172.18.174.66">TD_1_172.18.174.66</option>
                                    <option value="TD_1_172.18.174.67">TD_1_172.18.174.67</option>
                                    <option value="TD_1_172.18.174.7">TD_1_172.18.174.7</option>
                                    <option value="TD_1_172.18.174.9">TD_1_172.18.174.9</option>
                                    <option value="TD_14_172.18.174.66">TD_14_172.18.174.66</option>
                                    <option value="TD_14_172.18.174.67">TD_14_172.18.174.67</option>
                                    <option value="TD_14_172.18.174.85">TD_14_172.18.174.85</option>
                                    <option value="TD_14_172.18.174.89">TD_14_172.18.174.89</option>
                                    <option value="TD_18_10.10.105.102">TD_18_10.10.105.102</option>
                                    <option value="TD_18_10.10.105.103">TD_18_10.10.105.103</option>
                                    <option value="TD_18_10.10.105.110">TD_18_10.10.105.110</option>
                                    <option value="TD_18_10.10.105.111">TD_18_10.10.105.111</option>
                                    <option value="TD_18_10.10.105.112_WEBADAPTO1_SQH313">TD_18_10.10.105.112_WEBADAPTO1_SQH313</option>
                                    <option value="TD_18_10.10.105.115_WEBADAPTO2">TD_18_10.10.105.115_WEBADAPTO2</option>
                                    <option value="TD_18_10.10.105.132">TD_18_10.10.105.132</option>
                                    <option value="TD_18_10.10.105.133">TD_18_10.10.105.133</option>										
                                    </select>
                                </div>
                            </td>
                            <tr>
                                <td>
                                    <label for="state">Estado</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <select name="state" id="state" class="form-control" required>
                                            <option selected disabled>-- Seleccione --</option>
                                            <option value="Disable">Disable</option>
                                            <option value="Enable">Enable</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    <label for="email" class="text-md-right">Correo electrónico Destinatario</label>
                                </th>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        </div>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Ej: example@example.com" required>
                                    </div>
                                </td>
                            </tr>
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
            /*
            $('#server').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#state').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            /*
            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });*/
            /*
            $("#group").change(function(){
                var grupo = $(this).val()
                $.get('getHosts/'+{{ $inventario }}+'/'+grupo+'/local', function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = '<option value="'+grupo+'">Todos</option>'
                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            select+='<option value="'+data[i]+'">'+data[i]+'</option>';
                        }
                    }
                    $("#host").html(select);
                });
            });*/
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
