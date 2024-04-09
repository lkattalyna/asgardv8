@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Deshabilitación/rehabilitación Servidor CASA EDITORIAL EL TIEMPO -CEET- Citrix NS ADC
</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')
        @include('layouts.formError')
        <form action="{{ Route('balancers.ServEditorialTiempoStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Deshabilitación/rehabilitación Servidor CASA EDITORIAL EL TIEMPO -CEET- Citrix NS ADC

</h3>
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
                                    <option value="TD_100_10.100.0.32_Layo" > TD_100_10.100.0.32_Layo</option>
                                    <option value="TD_100_10.100.0.33_Atreo" > TD_100_10.100.0.33_Atreo</option>
                                    <option value="TD_100_10.100.1.28_Cefiro" > TD_100_10.100.1.28_Cefiro</option>
                                    <option value="TD_100_10.100.12.24" > TD_100_10.100.12.24</option>
                                    <option value="TD_100_10.100.13.12_minotauro" > TD_100_10.100.13.12_minotauro</option>
                                    <option value="TD_100_10.100.20.3_Niobe 10.100.20.3" > TD_100_10.100.20.3_Niobe 10.100.20.3</option>
                                    <option value="TD_100_10.100.23.13_Celeno" > TD_100_10.100.23.13_Celeno</option>
                                    <option value="TD_100_10.100.24.14" > TD_100_10.100.24.14</option>
                                    <option value="TD_100_10.100.3.1_AD" > TD_100_10.100.3.1_AD</option>
                                    <option value="TD_100_10.100.3.12_Niobe" > TD_100_10.100.3.12_Niobe</option>
                                    <option value="TD_100_10.60.0.77_Hermes" > TD_100_10.60.0.77_Hermes</option>
                                    <option value="TD_100_10.60.1.3_Pivote1" > TD_100_10.60.1.3_Pivote1</option>
                                    <option value="TD_100_10.60.1.4_Pivote2" > TD_100_10.60.1.4_Pivote2</option>
                                    <option value="TD_100_10.60.2.5_olivo1" > TD_100_10.60.2.5_olivo1</option>
                                    <option value="TD_100_10.60.2.8_Mega1" > TD_100_10.60.2.8_Mega1</option>
                                    <option value="TD_100_10.60.2.9_Mega2" > TD_100_10.60.2.9_Mega2</option>
                                    <option value="TD_100_10.61.0.11_Safi_Produccion" > TD_100_10.61.0.11_Safi_Produccion</option>
                                    <option value="TD_100_10.61.0.13_Safi01" > TD_100_10.61.0.13_Safi01</option>
                                    <option value="TD_100_10.61.0.14_Safi02" > TD_100_10.61.0.14_Safi02</option>
                                    <option value="TD_100_10.61.0.15_Safi03" > TD_100_10.61.0.15_Safi03</option>
                                    <option value="TD_100_10.61.0.16_Safi04" > TD_100_10.61.0.16_Safi04</option>
                                    <option value="TD_100_10.61.0.17_Safi05" > TD_100_10.61.0.17_Safi05</option>
                                    <option value="TD_100_10.61.0.18_Safi06" > TD_100_10.61.0.18_Safi06</option>
                                    <option value="TD_100_10.61.0.3" > TD_100_10.61.0.3</option>
                                    <option value="TD_100_10.61.0.8" > TD_100_10.61.0.8</option>
                                    <option value="TD_100_10.61.0.9" > TD_100_10.61.0.9</option>
                                    <option value="TD_100_10.61.1.15" > TD_100_10.61.1.15</option>
                                    <option value="TD_100_10.61.1.196" > TD_100_10.61.1.196</option>
                                    <option value="TD_100_10.61.1.197" > TD_100_10.61.1.197</option>
                                    <option value="TD_100_10.61.1.198" > TD_100_10.61.1.198</option>
                                    <option value="TD_100_10.61.1.200" > TD_100_10.61.1.200</option>
                                    <option value="TD_100_10.61.1.29_kinga1" > TD_100_10.61.1.29_kinga1</option>
                                    <option value="TD_100_10.61.1.3_Jaspe1" > TD_100_10.61.1.3_Jaspe1</option>
                                    <option value="TD_100_10.61.1.30_kinga2" > TD_100_10.61.1.30_kinga2</option>
                                    <option value="TD_100_10.61.1.37_Amapola" > TD_100_10.61.1.37_Amapola</option>
                                    <option value="TD_100_10.61.1.38_Ambar" > TD_100_10.61.1.38_Ambar</option>
                                    <option value="TD_100_10.61.1.39_Azahar" > TD_100_10.61.1.39_Azahar</option>
                                    <option value="TD_100_10.61.1.4_Jaspe2" > TD_100_10.61.1.4_Jaspe2</option>
                                    <option value="TD_100_10.61.1.5_Agata" > TD_100_10.61.1.5_Agata</option>
                                    <option value="TD_100_10.61.1.6" > TD_100_10.61.1.6</option>
                                    <option value="TD_100_10.61.1.7_berilo" > TD_100_10.61.1.7_berilo</option>
                                    <option value="TD_100_10.61.1.75_Voyager2" > TD_100_10.61.1.75_Voyager2</option>
                                    <option value="TD_100_10.61.2.11_ombu1" > TD_100_10.61.2.11_ombu1</option>
                                    <option value="TD_100_10.61.2.12_ombu2" > TD_100_10.61.2.12_ombu2</option>
                                    <option value="TD_100_10.61.2.13_Enebro1" > TD_100_10.61.2.13_Enebro1</option>
                                    <option value="TD_100_10.61.2.14_Enebro2" > TD_100_10.61.2.14_Enebro2</option>
                                    <option value="TD_100_10.61.2.15_Morion1" > TD_100_10.61.2.15_Morion1</option>
                                    <option value="TD_100_10.61.2.16_Morion2" > TD_100_10.61.2.16_Morion2</option>
                                    <option value="TD_100_10.61.2.17_SAP" > TD_100_10.61.2.17_SAP</option>
                                    <option value="TD_100_10.61.2.18" > TD_100_10.61.2.18</option>
                                    <option value="TD_100_10.61.2.19" > TD_100_10.61.2.19</option>
                                    <option value="TD_100_10.61.2.24_Marmol1 10.61.2.24" > TD_100_10.61.2.24_Marmol1 10.61.2.24</option>
                                    <option value="TD_100_10.61.2.25_Marmol2 10.61.2.25" > TD_100_10.61.2.25_Marmol2 10.61.2.25</option>
                                    <option value="TD_100_10.61.2.26_Madera1" > TD_100_10.61.2.26_Madera1</option>
                                    <option value="TD_100_10.61.2.27_Madera2" > TD_100_10.61.2.27_Madera2</option>
                                    <option value="TD_100_10.61.2.3_ficus" > TD_100_10.61.2.3_ficus</option>
                                    <option value="TD_100_10.61.2.31_Barita1" > TD_100_10.61.2.31_Barita1</option>
                                    <option value="TD_100_10.61.2.32_Barita2" > TD_100_10.61.2.32_Barita2</option>
                                    <option value="TD_100_10.61.2.33" > TD_100_10.61.2.33</option>
                                    <option value="TD_100_10.61.2.34" > TD_100_10.61.2.34</option>
                                    <option value="TD_100_10.61.2.37_Hadar1" > TD_100_10.61.2.37_Hadar1</option>
                                    <option value="TD_100_10.61.2.4_fresno" > TD_100_10.61.2.4_fresno</option>
                                    <option value="TD_100_10.61.2.40_Hadar2" > TD_100_10.61.2.40_Hadar2</option>
                                    <option value="TD_100_10.61.2.5_Lotto1" > TD_100_10.61.2.5_Lotto1</option>
                                    <option value="TD_100_10.61.2.6_Lotto2" > TD_100_10.61.2.6_Lotto2</option>
                                    <option value="TD_100_10.61.2.7_cactus1" > TD_100_10.61.2.7_cactus1</option>
                                    <option value="TD_100_10.61.2.8" > TD_100_10.61.2.8</option>
                                    <option value="TD_100_10.61.3.165" > TD_100_10.61.3.165</option>
                                    <option value="TD_100_10.61.3.166" > TD_100_10.61.3.166</option>
                                    <option value="TD_100_10.61.3.211_Limonero" > TD_100_10.61.3.211_Limonero</option>
                                    <option value="TD_100_10.61.3.251_Perla" > TD_100_10.61.3.251_Perla</option>
                                    <option value="TD_100_10.69.69.69" > TD_100_10.69.69.69</option>
                                    <option value="TD_100_10.8.50.11_AUTOGESTION_PWD" > TD_100_10.8.50.11_AUTOGESTION_PWD</option>
                                    <option value="TD_100_10.8.50.12_we_sharePoint" > TD_100_10.8.50.12_we_sharePoint</option>
                                    <option value="TD_100_10.8.50.14" > TD_100_10.8.50.14</option>
                                    <option value="TD_100_10.8.50.15_Apogge9" > TD_100_10.8.50.15_Apogge9</option>
                                    <option value="TD_100_10.8.50.2_Apogee11a" > TD_100_10.8.50.2_Apogee11a</option>
                                    <option value="TD_100_169.254.200.200" > TD_100_169.254.200.200</option>
                                    <option value="TD_100_Hera_10.61.1.73" > TD_100_Hera_10.61.1.73</option>
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
