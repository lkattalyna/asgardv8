@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Deshabilitación/rehabilitación controlada Servidor CRYSTAL Citrix NS ADC</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')
        @include('layouts.formError')
        <form action="{{ Route('balancers.SerCristalNsStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Deshabilitación/rehabilitación controlada Servidor CRYSTAL Citrix NS ADC</h3>
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
                                    <option value="TD_30_172.18.171.130" >TD_30_172.18.171.130</option>
                                    <option value="TD_30_172.18.171.132" >TD_30_172.18.171.132</option>
                                    <option value="TD_30_172.18.171.141" >TD_30_172.18.171.141</option>
                                    <option value="TD_30_172.18.171.151" >TD_30_172.18.171.151</option>
                                    <option value="TD_30_172.18.171.153" >TD_30_172.18.171.153</option>
                                    <option value="TD_30_172.18.171.155" >TD_30_172.18.171.155</option>
                                    <option value="TD_30_172.18.171.171" >TD_30_172.18.171.171</option>
                                    <option value="TD_30_172.18.171.172" >TD_30_172.18.171.172</option>
                                    <option value="TD_30_172.18.171.173" >TD_30_172.18.171.173</option>
                                    <option value="TD_30_172.18.171.174" >TD_30_172.18.171.174</option>
                                    <option value="TD_30_172.18.171.175" >TD_30_172.18.171.175</option>
                                    <option value="TD_30_172.18.171.176" >TD_30_172.18.171.176</option>
                                    <option value="TD_30_172.18.171.177" >TD_30_172.18.171.177</option>
                                    <option value="TD_30_172.18.171.178" >TD_30_172.18.171.178</option>
                                    <option value="TD_30_172.18.171.179" >TD_30_172.18.171.179</option>
                                    <option value="TD_30_172.18.171.180" >TD_30_172.18.171.180</option>
                                    <option value="TD_30_172.18.171.183" >TD_30_172.18.171.183</option>
                                    <option value="TD_30_172.18.171.184" >TD_30_172.18.171.184</option>
                                    <option value="TD_30_172.18.171.185" >TD_30_172.18.171.185</option>
                                    <option value="TD_37_10.132.0.132" >TD_37_10.132.0.132</option>
                                    <option value="TD_37_10.132.0.133" >TD_37_10.132.0.133</option>
                                    <option value="TD_37_10.132.0.134" >TD_37_10.132.0.134</option>
                                    <option value="TD_37_10.132.0.135" >TD_37_10.132.0.135</option>
                                    <option value="TD_37_10.132.0.136" >TD_37_10.132.0.136</option>
                                    <option value="TD_37_10.132.0.139" >TD_37_10.132.0.139</option>
                                    <option value="TD_37_10.132.0.140" >TD_37_10.132.0.140</option>
                                    <option value="TD_37_10.132.0.143" >TD_37_10.132.0.143</option>
                                    <option value="TD_37_10.132.0.150" >TD_37_10.132.0.150</option>
                                    <option value="TD_37_10.132.0.151" >TD_37_10.132.0.151</option>
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
