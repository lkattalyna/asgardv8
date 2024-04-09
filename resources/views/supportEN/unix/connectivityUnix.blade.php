@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Conectividad unix</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('supportEN-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        {{-- {{ route('unix.connectivityStore') }} --}}
        <form action="" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario conectividad de unix</h3>
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
                                <label for="group">{{ __('Tipo de Conexión') }}</label>
                            </td>
                            <td>
                                 {{-- <div class="input-group">
                                    <select onchange="cambiarTipo(this)" name="tipo" id="tipo" class="form-control" style="width: 100%" required>
                                        <option selected value="Ping">Ping</option>
                                        <option value="Telnet">Telnet</option>
                                        <option value="Tracer">Tracer</option>
                                    </select>
                                </div> --}}
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pingCheck" name="tipoAccion[]" value="ping" onclick="showContent()"/>
                                    <label class="form-check-label" for="pingCheck"> Ping</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="telnetCheck" name="tipoAccion[]" value="telnet" onclick="showContent()"/>
                                    <label class="form-check-label" for="telnetCheck"> Telnet</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="tracerCheck" name="tipoAccion[]" value="tracer" onclick="showContent()"/>
                                    <label class="form-check-label" for="tracerCheck"> Tracer</label>
                                </div>
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
                                <label for="host">{{ __('Servidor Origen') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="host[]" id="host" class="form-control" style="width: 100%" required></select> {{--multiple="multiple"--}}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="host">{{ __('IPs Destino') }}</label>
                            </td>
                            <td>
                                <div class="input-content-ip" id="input-content-ip">
                                    <div class="input-group">
                                        <input type="text" name="ipDestino[]" id="destino" class="form-control"  style="width: 70%" placeholder="IP Destino" required>
                                        <a class="btn btn-info" id="btn-add-input-ip" style="float: right; color: white">+</a>
                                        <a class="btn btn-light ocultar btn-delete-input-ip" id="btn-delete-input-ip">-</a>
                                    </div>
                                </div>
                                <div id="divElementsIp"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="host">{{ __('Puertos') }}</label>
                            </td>
                            <td id ="content-port" style="display: none">
                                <div class="input-content-port">
                                    <div class="input-group">
                                        <input type="text" name="ipTelnet[]" id="ipTelnet" class="form-control puerto_check"  style="width: 60%;" placeholder="IP Destino">
                                        <input type="text" name="puertoTelnet[]" id="puerto" class="form-control puerto_check"  style="width: 30%;" placeholder="Puerto">
                                        <a class="btn btn-info" id="btn-add-input-port" style="float: right; color: white">+</a>
                                        <a class="btn btn-light ocultar btn-delete-input-port" id="btn-delete-input-port">-</a>
                                    </div>
                                </div>
                                <div id="divElementsPort"></div>
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
@section('css')
    <style>
        .ocultar{
        display:none;
    }
    </style>
@stop
@section('js')
  <script>

      function cambiarTipo(comboBox){
        let value = comboBox.value;
        const puertoNAME = document.querySelector("#puertoNAME");
        const puertoTR = document.querySelector("#puertoTR");
            $("#puertoNAME").val('');
            puertoNAME.toggleAttribute('disabled');
            puertoNAME.toggleAttribute('required');
            puertoTR.classList.toggle('d-none');
      }
        $(document).ready(function() {


            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
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
            showContent();
            let $addInputIp = document.getElementById('btn-add-input-ip');
            let $divElementsIp = document.getElementById('divElementsIp');

            let $addInputPort = document.getElementById('btn-add-input-port');
            let $divElementsPort = document.getElementById('divElementsPort');

            $addInputIp.addEventListener('click',event=>{
                event.preventDefault();
                let $clonado = document.querySelector('.input-content-ip');
                let $clon = $clonado.cloneNode(true);
                $divElementsIp.appendChild($clon).classList.remove('input-content-ip');
                let $remover = $divElementsIp.lastChild.childNodes[1].querySelectorAll('a');
                let $clearInput = $divElementsIp.lastChild.childNodes[1].querySelectorAll('input');
                $remover[0].classList.add('ocultar');
                $remover[1].classList.remove('ocultar');
                $clearInput[0].value="";
            });

            $addInputPort.addEventListener('click',event=>{
                event.preventDefault();
                let $clonado = document.querySelector('.input-content-port');
                let clon = $clonado.cloneNode(true);
                $divElementsPort.appendChild(clon).classList.remove('input-content-port');
                let $remover = $divElementsPort.lastChild.childNodes[1].querySelectorAll('a');
                let $clearInput = $divElementsPort.lastChild.childNodes[1].querySelectorAll('input');
                $remover[0].classList.add('ocultar');
                $remover[1].classList.remove('ocultar');
                $clearInput[0].value="";
                $clearInput[1].value="";
            });

            $divElementsIp.addEventListener('click',event=>{
                event.preventDefault();

                if(event.target.classList.contains('btn-delete-input-ip')){
                    let $contenedor= event.target.parentNode;
                    $contenedor.parentNode.removeChild($contenedor);
                }
            });

            $divElementsPort.addEventListener('click',event=>{
                event.preventDefault();

                if(event.target.classList.contains('btn-delete-input-port')){
                    let $contenedor= event.target.parentNode;
                    $contenedor.parentNode.removeChild($contenedor);
                }
            });

            // validación checks
            let btnEjecutar= document.getElementById('sendForm');
            btnEjecutar.addEventListener('click',function(event){
                let ping_check = document.getElementById('pingCheck').checked;
                let telnet_check = document.getElementById('telnetCheck').checked;
                let tracer_check = document.getElementById('tracerCheck').checked;
                if(!ping_check && !telnet_check && !tracer_check){
                    $('#pingCheck').prop('required',true);
                }else{
                    $('#pingCheck').removeAttr('required');
                }
            });
        });

        function showContent(){
            const pingCheck = document.getElementById('pingCheck').checked;
            const telnetCheck = document.getElementById('telnetCheck').checked;
            const tracerCheck = document.getElementById('tracerCheck').checked;
            const contentPorts= document.getElementById('content-port');
            const contentIpsDestino= document.getElementById('input-content-ip');

            if((pingCheck || tracerCheck) && telnetCheck){
                contentIpsDestino.style.display = "block";
                contentPorts.style.display ="block";
                $("#destino").prop('required',true);
                $("#ipTelnet").prop('required',true);
                $("#puerto").prop('required',true);
            }else if((!pingCheck && !tracerCheck) && telnetCheck){
                contentPorts.style.display ="block";
                contentIpsDestino.style.display = "none";
                $("#destino").removeAttr('required');
                $("#ipTelnet").prop('required',true);
                $("#puerto").prop('required',true);
            }else{
                contentPorts.style.display ="none";
                contentIpsDestino.style.display = "block";
                $("#destino").prop('required',true);
                $("#ipTelnet").removeAttr('required');
                $("#puerto").removeAttr('required');
            }
        }
    </script>
@stop
