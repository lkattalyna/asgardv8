@extends('adminlte::page')
@section('content_header')
    <h1>Formulario Deshabilitación/rehabilitación controlada Servidor CONSORCIO Citrix NS ADC</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')
        @include('layouts.formError')
        <form action="{{ Route('balancers.ServConsorcioStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Deshabilitación/rehabilitación controlada Servidor CONSORCIO Citrix NS ADC</h3>
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
                                    <option value = "TD_13_10.237.146.3">TD_13_10.237.146.3</option> 
                                    <option value = "TD_13_10.237.146.4">TD_13_10.237.146.4</option> 
                                    <option value = "TD_13_10.237.146.7">TD_13_10.237.146.7</option> 
                                    <option value = "TD_13_10.237.146.8">TD_13_10.237.146.8</option> 
                                    <option value = "TD_13_172.18.167.123_VMDBOYLE">TD_13_172.18.167.123_VMDBOYLE</option> 
                                    <option value = "TD_13_172.18.167.69_VMPRZETA">TD_13_172.18.167.69_VMPRZETA</option> 
                                    <option value = "TD_13_172.18.167.93_VMPRGAMMA">TD_13_172.18.167.93_VMPRGAMMA</option> 
                                    <option value = "TD_13_172.18.222.2_VMPCACTUS">TD_13_172.18.222.2_VMPCACTUS</option> 
                                    <option value = "TD_13_172.18.222.3_VMPACEBUCHE">TD_13_172.18.222.3_VMPACEBUCHE</option> 
                                    <option value = "TD_13_172.18.222.66_VMPRCACTUS">TD_13_172.18.222.66_VMPRCACTUS</option> 
                                    <option value = "TD_13_172.18.222.67_VMPRACEBUCHE">TD_13_172.18.222.67_VMPRACEBUCHE</option> 
                                    <option value = "TD_13_172.18.23.38">TD_13_172.18.23.38</option> 
                                    <option value = "TD_13_172.18.23.39">TD_13_172.18.23.39</option> 
                                    <option value = "TD_13_172.18.23.40">TD_13_172.18.23.40</option> 
                                    <option value = "TD_13_172.18.23.41">TD_13_172.18.23.41</option> 
                                    <option value = "TD_13_172.18.23.42">TD_13_172.18.23.42</option> 
                                    <option value = "TD_13_172.18.23.43">TD_13_172.18.23.43</option> 
                                    <option value = "TD_13_172.18.23.44">TD_13_172.18.23.44</option> 
                                    <option value = "TD_13_172.18.23.45">TD_13_172.18.23.45</option> 
                                    <option value = "TD_13_172.18.23.46">TD_13_172.18.23.46</option> 
                                    <option value = "TD_13_172.18.23.47">TD_13_172.18.23.47</option> 
                                    <option value = "TD_13_172.18.23.48">TD_13_172.18.23.48</option> 
                                    <option value = "TD_13_172.18.23.49">TD_13_172.18.23.49</option> 
                                    <option value = "TD_13_172.18.23.50_WAF_Mantis_TestlinkV2">TD_13_172.18.23.50_WAF_Mantis_TestlinkV2</option> 
                                    <option value = "TD_13_172.18.23.51_prueba_julio07">TD_13_172.18.23.51_prueba_julio07</option> 
                                    <option value = "TD_13_172.18.42.11_VMPANUBIS">TD_13_172.18.42.11_VMPANUBIS</option> 
                                    <option value = "TD_13_172.18.42.12_VMPATON">TD_13_172.18.42.12_VMPATON</option> 
                                    <option value = "TD_13_172.18.42.13_VMPMAAT">TD_13_172.8.42.13_VMPMAAT</option> 
                                    <option value = "TD_13_172.18.42.14_VMPSAUCO">TD_13_172.18.42.14_VMPSAUCO</option> 
                                    <option value = "TD_13_172.18.42.16_VMPSETH">TD_13_172.18.42.16_VMPSETH</option> 
                                    <option value = "TD_13_172.18.42.20_VMPSERKET">TD_13_172.18.42.20_VMPSERKET</option> 
                                    <option value = "TD_13_172.18.42.21_VMPSESHAT">TD_13_172.18.42.21_VMPSESHAT</option> 
                                    <option value = "TD_13_172.18.42.23_VMPNEFERTUM">TD_13_172.18.42.23_VMPNEFERTUM</option> 
                                    <option value = "TD_13_172.18.42.27_VMPACEROLO">TD_13_172.18.42.27_VMPACEROLO</option> 
                                    <option value = "TD_13_172.18.42.28_VMPACHIOTE">TD_13_172.18.42.28_VMPACHIOTE</option> 
                                    <option value = "TD_13_172.18.42.34_VMPGUAYABERO">TD_13_172.18.42.34_VMPGUAYABERO</option> 
                                    <option value = "TD_13_172.18.42.50_VMPCOMINO">TD_13_172.18.42.50_VMPCOMINO</option> 
                                    <option value = "TD_13_172.18.42.6_RA">TD_13_172.18.42.6_RA</option> 
                                    <option value = "TD_13_172.18.42.7_HORUS">TD_13_172.18.42.7_HORUS</option> 
                                    <option value = "TD_13_172.22.145.8_VMDNOBEL">TD_13_172.22.145.8_VMDNOBEL</option> 
                                    <option value = "TD_13_172.22.146.195">TD_13_172.22.146.195</option> 
                                    <option value = "TD_13_172.22.146.199">TD_13_172.22.146.199</option> 
                                    <option value = "TD_13_172.22.146.200">TD_13_172.22.146.200</option> 
                                    <option value = "TD_13_172.22.146.207_VMPARGAN">TD_13_172.22.146.207_VMPARGAN</option> 
                                    <option value = "TD_13_172.22.146.213">TD_13_172.22.146.213</option> 
                                    <option value = "TD_13_172.22.146.226">TD_13_172.22.146.226</option> 
                                    <option value = "TD_13_172.22.147.136">TD_13_172.22.147.136</option> 
                                    <option value = "TD_13_172.22.147.138">TD_13_172.22.147.138</option> 
                                    <option value = "TD_13_172.22.147.141_VMPALCORNOQUE">TD_13_172.22.147.141_VMPALCORNOQUE</option> 
                                    <option value = "TD_13_172.22.147.144_VMPALMEZ">TD_13_172.22.147.144_VMPALMEZ</option> 
                                    <option value = "TD_13_172.22.147.145">TD_13_172.22.147.145</option> 
                                    <option value = "TD_13_172.22.147.146">TD_13_172.22.147.146</option> 
                                    <option value = "TD_13_172.22.147.147">TD_13_172.22.147.147</option> 
                                    <option value = "TD_13_172.22.147.163">TD_13_172.22.147.163</option> 
                                    <option value = "TD_13_172.22.147.166">TD_13_172.22.147.166</option> 
                                    <option value = "TD_13_172.22.147.170_VPMATON">TD_13_172.22.147.170_VPMATON</option> 
                                    <option value = "TD_13_172.22.147.181">TD_13_172.22.147.181</option> 
                                    <option value = "TD_13_172.22.147.182">TD_13_172.22.147.182</option> 
                                    <option value = "TD_13_172.22.147.186">TD_13_172.22.147.186</option> 
                                    <option value = "TD_13_172.22.147.198_SECUOYA">TD_13_172.22.147.198_SECUOYA</option> 
                                    <option value = "TD_13_172.22.147.200">TD_13_172.22.147.200</option> 
                                    <option value = "TD_13_172.22.147.201">TD_13_172.22.147.201</option> 
                                    <option value = "TD_13_172.22.147.202">TD_13_172.22.147.202</option> 
                                    <option value = "TD_13_172.22.147.213">TD_13_172.22.147.213</option> 
                                    <option value = "TD_13_172.22.147.214">TD_13_172.22.147.214</option> 
                                    <option value = "TD_13_172.22.147.216_VMPACEITUNO">TD_13_172.22.147.216_VMPACEITUNO</option> 
                                    <option value = "TD_13_172.22.147.227">TD_13_172.22.147.227</option> 
                                    <option value = "TD_13_172.22.147.231">TD_13_172.22.147.231</option> 
                                    <option value = "TD_13_172.22.147.232">TD_13_172.22.147.232</option> 
                                    <option value = "TD_13_172.22.147.233_VMPMAGNOLIO">TD_13_172.22.147.233_VMPMAGNOLIO</option> 
                                    <option value = "TD_13_172.22.147.234">TD_13_172.22.147.234</option> 
                                    <option value = "TD_13_172.22.147.237">TD_13_172.22.147.237</option> 
                                    <option value = "TD_13_172.22.147.238_VMPYARUMO">TD_13_172.22.147.238_VMPYARUMO</option> 
                                    <option value = "TD_13_172.22.147.239">TD_13_172.22.147.239</option> 
                                    <option value = "TD_13_172.22.147.243_VMPMANZANO">TD_13_172.22.147.243_VMPMANZANO</option> 
                                    <option value = "TD_13_172.22.147.244_VMPLIMON">TD_13_172.22.147.244_VMPLIMON</option> 
                                    <option value = "TD_13_172.22.147.247_VMPSAUCO">TD_13_172.22.147.247_VMPSAUCO</option> 
                                    <option value = "TD_13_172.27.233.20">TD_13_172.27.233.20</option> 
                                    <option value = "TD_13_172.27.233.26_laplace_Azure">TD_13_172.27.233.26_laplace_Azure</option> 
                                    <option value = "TD_13_172.27.233.31_francio_Azure">TD_13_172.27.233.31_francio_Azure</option> 
                                    <option value = "TD_13_172.27.233.33_VMAZPRUGAMMA"> TD_13_172.27.233.33_VMAZPRUGAMMA</option> 
                                    <option value = "TD_13_172.27.233.34_VMAZPRUCOBALTO">TD_13_172.27.233.34_VMAZPRUCOBALTO</option> 
                                    <option value = "TD_13_172.27.233.40">TD_13_172.27.233.40</option> 
                                    <option value = "TD_13_172.27.233.41">TD_13_172.27.233.41</option> 
                                    <option value = "TD_13_172.27.233.49">TD_13_172.27.233.49</option> 
                                    <option value = "TD_13_172.27.233.51_VMAZPRUESCANDIO">TD_13_172.27.233.51_VMAZPRUESCANDIO</option> 
                                    <option value = "TD_13_172.27.233.52_VMAZPRUZETA">TD_13_172.27.233.52_VMAZPRUZETA</option> 
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
