@extends('adminlte::page')
@section('content_header')
    <h1> Declaratoria de incidente</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @include('layouts.formError')
    <form action="{{ route('incidentes.declararStore') }}" method="post" id="formfield">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Formulario para declarar incidente</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>
                            <label for="segment" class="text-center">Nombre completo</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="Nombre" id="Nombre" class="form-control" value=""
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}" placeholder="Nombre y apellidos"  maxlength="80" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                        title="Ayuda" data-content="Nombre">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="segment" class="text-center">Numero de Documento</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="Documento" id="Documento" class="form-control" value=""
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}" placeholder="Numero de Documento"  maxlength="80" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                        title="Ayuda" data-content="Nombre">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="segment" class="text-center">Correo</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="Correo" id="Correo" class="form-control" value=""
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}" placeholder="ejemplo@claro.com.co"  maxlength="80" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                        title="Ayuda" data-content="Correo a donde se enviara el resultado de la solicitud">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="dependence" class="text-center">¿Cuáles son los síntomas globales?</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <select class="form-control" name="sintomas" id="sintomas" required>
                                    <option value="Indisponibilidad total de servicios" selected>Indisponibilidad total de servicios</option>
                                    <option value="Indisponibilidad de uno o más CI’s" selected>Indisponibilidad de uno o más CI’s</option>
                                    <option value="Indisponibilidad de una aplicación del cliente" selected>Indisponibilidad de una aplicación del cliente</option>
                                    <option value="Falla en funcionalidad CI" selected>Falla en funcionalidad CI</option>
                                    <option value="Degradación de funcionalidad CON disponibilidad" selected>Degradación de funcionalidad CON disponibilidad</option>
                                    <option value="Lentitud" selected>Lentitud</option>
                                    <option value="Masivo" selected>Masivo</option>
                                    <option value="vacio" selected></option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="description" class="text-md-right">¿Cuál es el impacto de la afectación?</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <textarea name="description" id="description" class="form-control" placeholder="Descripción"
                                        maxlength="200" rows="2" required></textarea>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="dependence" class="text-center">¿Cómo se ha detectado la afectación  del servicio?</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <select class="form-control" name="detectado" id="detectado" required>
                                    <option value="Evento en las herramientas" selected>Evento en las herramientas</option>
                                    <option value="Llamada o correo del cliente" selected>Llamada o correo del cliente</option>
                                    <option value="Indisponibilidad de una aplicación del cliente" selected>Indisponibilidad de una aplicación del cliente</option>
                                    <option value="Descubrimiento interno o llamada de un área" selected>Descubrimiento interno o llamada de un área</option>
                                    <option value="Interacción SD en Service Manager" selected>Interacción SD en Service Manager</option>
                                    <option value="0" selected></option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="segment" >¿Tiene algún caso (IM o SD) creado en Service Manager relacionado a la afectación? </label>
                        </th>
                        <td>
                            <div class="mg-toolbar">
                                <div class="mg-option checkbox-custom checkbox-inline">
                                <input class="product-list" id="si_caso" type="radio" name="si_caso" value="si" onclick="show_whencode()">
                                <label for="si_caso">Si, ya tengo un caso (IM o SD) creado en Service Manager </label>
                                </div>
                                <div class="mg-option checkbox-custom checkbox-inline">
                                <input class="product-list" id="no_caso" type="radio" name="no_caso" value="no" onclick="show_whenNOcode()">
                                <label for="no_caso">No, aun no tengo un caso (IM o SD) creado en Service Manager</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr id="dinamico_caso" style="display:none;">
                        <th>
                            <label for="segment" class="text-center">Ingrese el id del caso (IM o SD)</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="id_caso" id="id_caso" class="form-control" value=""
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}" placeholder="IM o SD"  maxlength="80" >
                            </div>
                        </td>
                    </tr>
                    <tr id="dinamico_cliente" style="display:none;">
                        <th>
                            <label for="segment" class="text-center">Ingrese el nombre del cliente afectado</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <select name="nombre_cliente" id="nombre_cliente" class="form-control" style="width: 100%" required>
                                    @foreach ($clientes_datacenter as $cliente)
                                        <option value="{{ $cliente->EMPRESA }}">{{ $cliente->EMPRESA }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr id="dinamico_codServ" style="display:none;">
                        <th>
                            <label for="segment" class="text-center">Ingrese el codigo de servicio afectado</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="cod_serv" id="cod_serv" class="form-control" value=""
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}" placeholder="COD SERV"  maxlength="80" >
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="segment" class="text-center">Seleccione los grupos a los que desea notificar la afectación</label>
                        </th>
                        <td>
                            <div>
                                <input type="checkbox" id="1" name="1">
                                <label for="scales">1. AMT</label>
                            </div>
                            <div>
                                <input type="checkbox" id="2" name="2">
                                <label for="horns">2. BALANCEADORES</label>
                            </div>
                            <div>
                                <input type="checkbox" id="3" name="3">
                                <label for="scales">3. BACKUP</label>
                            </div>
                            <div>
                                <input type="checkbox" id="4" name="4">
                                <label for="scales">4. CIBERSEGURIDAD</label>
                            </div>
                            <div>
                                <input type="checkbox" id="5" name="5">
                                <label for="scales">5. INFRAESTRUCTURA</label>
                            </div>
                            <div>
                                <input type="checkbox" id="6" name="6">
                                <label for="scales">6. ORACLE</label>
                            </div>
                            <div>
                                <input type="checkbox" id="7" name="7">
                                <label for="scales">7. PCCAAS</label>
                            </div>
                            <div>
                                <input type="checkbox" id="8" name="8">
                                <label for="scales">8. RECURSOS TECNOLÓGICOS</label>
                            </div>
                            <div>
                                <input type="checkbox" id="9" name="9">
                                <label for="scales">9. RED DATACENTER</label>
                            </div>
                            <div>
                                <input type="checkbox" id="10" name="10">
                                <label for="scales">10. SAN</label>
                            </div>
                            <div>
                                <input type="checkbox" id="11" name="11">
                                <label for="scales">11. SAP</label>
                            </div>
                            <div>
                                <input type="checkbox" id="12" name="12">
                                <label for="scales">12. SEGURIDAD ADMINISTRADA</label>
                            </div>
                            <div>
                                <input type="checkbox" id="13" name="13">
                                <label for="scales">13. SQL</label>
                            </div>
                            <div>
                                <input type="checkbox" id="14" name="14">
                                <label for="scales">14. GESTIÓN Y MONITOREO</label>
                            </div>
                            <div>
                                <input type="checkbox" id="15" name="15">
                                <label for="scales">15. UNIX</label>
                            </div>
                            <div>
                                <input type="checkbox" id="16" name="16">
                                <label for="scales">16. VIRTUALIZACIÓN</label>
                            </div>
                            <div>
                                <input type="checkbox" id="17" name="17">
                                <label for="scales">17. WINDOWS</label>
                            </div>
                            <div>
                                <input type="checkbox" id="20" name="20">
                                <label for="scales">20. Cloud</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="segment" >¿Ya tiene una sala  abierta  en Microsoft Teams para la afectación?</label>
                        </th>
                        <td>
                            <div class="mg-toolbar">
                                <div class="mg-option checkbox-custom checkbox-inline">
                                <input class="product-list" id="si_url" type="radio" name="si_url" value="si" onclick="show_whenNOteams()">
                                <label for="si_url">Si</label>
                                </div>
                                <div class="mg-option checkbox-custom checkbox-inline">
                                <input class="product-list" id="no_url" type="radio" name="no_url" value="no" onclick="show_whenTeams()">
                                <label for="no_url">No</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr id="dinamico_url" style="display:none;">
                        <th>
                            <label for="segment" class="text-center">Ingrese la url de la sala  abierta  en Microsoft Teams</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="url_teams" id="url_teams" class="form-control" value=""
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,80}" placeholder="https://teams.microsoft.com/l/meetup-join/..."  maxlength="80" >
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                    <i class="fa fa-terminal"></i> Enviar
                </button>
            </div>
        </div>
    </form>
@stop
@section('js')
    <script>
        function show_whencode() {
        //    document.getElementById('dinamico').style.display = "block";
            document.getElementById('dinamico_caso').removeAttribute("style");
            document.getElementById('dinamico_cliente').setAttribute("style", "display:none;");
            document.getElementById('dinamico_codServ').setAttribute("style", "display:none;");
            document.getElementById("no_caso").checked = false;

        }

        function show_whenNOcode() {
        //    document.getElementById('dinamico').style.display = "block";
            document.getElementById('dinamico_cliente').removeAttribute("style");
            document.getElementById('dinamico_codServ').removeAttribute("style");
            document.getElementById('dinamico_caso').setAttribute("style", "display:none;");
            document.getElementById("si_caso").checked = false;
        }

        function show_whenTeams() {
            document.getElementById("si_url").checked = false;
            document.getElementById('dinamico_url').setAttribute("style", "display:none;");

        }

        function show_whenNOteams() {
            document.getElementById("no_url").checked = false;
            document.getElementById('dinamico_url').removeAttribute("style");
        }

        $(document).ready(function() {
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
@endsection
