@extends('adminlte::page')
@section('content_header')
    <h1>Formulario Deshabilitación/rehabilitación Servidor FIDUBOGOTA Citrix NS ADC</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')        
        @include('layouts.formError')
        <form action="{{ Route('balancers.servFiduBogotaStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario Deshabilitación/rehabilitación Servidor FIDUBOGOTA Citrix NS ADC</h3>
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
                                        <option value="Brasil3_fidubogota">Brasil3_fidubogota</option>
                                        <option value="Brasil4_fidubogota">Brasil4_fidubogota</option>
										<option value="CHILE_fidubogota">CHILE_fidubogota</option>
                                        <option value="Chile2_fidubogota">Chile2_fidubogota</option>
										<option value="Chile3_fidubogota">Chile3_fidubogota</option>
                                        <option value="Chile4_fidubogota">Chile4_fidubogota</option>
										<option value="NICARAGUAII_fidubogota">NICARAGUAII_fidubogota</option>
                                        <option value="NICARAGUAIII_fidubogota">NICARAGUAIII_fidubogota</option>
										<option value=" TD_9_10.40.2.132"> TD_9_10.40.2.132</option>
                                        <option value="TD_9_10.40.2.133">TD_9_10.40.2.133</option>
										<option value="TD_9_10.40.2.134">TD_9_10.40.2.134</option>
                                        <option value="TD_9_10.40.2.139_Bogota1">TD_9_10.40.2.139_Bogota1</option>
										<option value="TD_9_10.40.2.140_Bogota2">TD_9_10.40.2.140_Bogota2</option>
                                        <option value="TD_9_10.40.2.171_Fidubogota_Asuncion1">TD_9_10.40.2.171_Fidubogota_Asuncion1</option>                                       
                                        <option value="TD_9_10.40.2.172_Fidubogota_Asuncion2">TD_9_10.40.2.172_Fidubogota_Asuncion2</option>
                                        <option value="TD_9_10.40.4.145_Fidubogota_ManaguaQA">TD_9_10.40.4.145_Fidubogota_ManaguaQA</option>
										<option value="TD_9_10.40.4.149">TD_9_10.40.4.149</option>
                                        <option value="TD_9_10.40.4.150">TD_9_10.40.4.150</option>
										<option value="TD_9_10.40.4.150_Fidubogota_Honduras3">TD_9_10.40.4.150_Fidubogota_Honduras3</option>
                                        <option value="TD_9_192.168.184.100"> TD_9_192.168.184.100</option>
										<option value="TD_9_Honduras_fidubogota">TD_9_Honduras_fidubogota</option>
                                        <option value="TD_9_Honduras2_fidubogota">TD_9_Honduras2_fidubogota</option>
										<option value="URUGUAY_fidubogota">URUGUAY_fidubogota</option>
                                        <option value="VZLA10_fdb0396_fidubogota">VZLA10_fdb0396_fidubogota</option>
										<option value="VZLA11_fdb0411_fidubogota">VZLA11_fdb0411_fidubogota</option>
                                        <option value="VZLA12_fdb0414_fidubogota">VZLA12_fdb0414_fidubogota</option>										
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
