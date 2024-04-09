@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de ejecución de reinicio de servicios</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can($permiso)
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ $rutaStore }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de ejecución de reinicio de servicios</h3>
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
                                <label for="host">{{ __('Servidor Origen') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="host[]" id="host" class="form-control" style="width: 100%" required>
                                        @foreach ($hosts as $host)
                                            <option value="{{ $host }}">{{ $host }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label }>{{ __('Ver servicios') }}</label>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" onclick="consultarServicios()">Consultar Servicios</button>
                            </td>
                        </tr>



                            <tr id="trServices-name" class="d-none">
                                <td>
                                    <label for="op">{{ __('Seleccione la operación') }}</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <select name="op" id="op" class="form-control" style="width: 100%" required>
                                            <option></option>
                                            <option value="stopped">Detener</option>
                                            <option value="started">Iniciar</option>
                                            <option value="restarted">Reiniciar</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr id="trServices-opt" class="d-none">
                                <td>
                                    <label for="service">{{ __('Nombre del servicio') }}</label>
                                </td>
                                <td>
                                    <input type="text" readonly name="service" id="service" class="form-control input-md" value="{{ old('service') }}" maxlength="50"
                                        minlength="2" placeholder="Servicio">
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
        <div id="consultandoServicios" class="d-none">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><i class="icon fa fa-info"></i> La tarea se esta ejecutando</p>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Servicios seleccionados(HOST): <span id="tituloServicio"></span></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover" id="tableFatherServices">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Status</th>
                            <th>Acción</th>
                            <th>Acción</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tableServicios">

                    </tbody>
                </table>

            </div>
        </div>

    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
@include('vistasReutilizables.partials.scripts.configBasicForm')
    <script>

        // function prueba (){
        //     let x = "file/-UNIX-UNIX_018_GETSERVICE/servicesUNX18.json"
        //     leerJsonServices(x);
        //     //http://172.22.16.179:443/105610/index.json
        // }


        function cambiarEstado (nombre,estado){
            $("#service").val(nombre);
            $("#op").val(estado).trigger('change');
        }


        $(document).ready(function() {



            $('#op').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
        });

        function consultarServicios() {

        if( $("#host").val() == $("#group").val() ){
            return;
        }

        $("#tituloServicio").empty().text($("#host").val())
        let parametros = {
            _token : $('meta[name="csrf-token"]').attr('content'),
            'host': $("#host").val(),
            urlMenu: "{{$rutaStore}}",
            id_template: "{{$dataAdicional['idTemplateServicios']}}"

        };

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ $dataAdicional['rutaServicios']}} ",
            type: 'post',
            data: parametros,
            success: function({data}) {
                const { url } = data;
                $("#consultandoServicios").toggleClass("d-none");
                setTimeout( async () => {
                    await leerJsonServices(url);
                }, 25000);
            }
        });
        }

        async function leerJsonServices(url){
        let ruta = "{{url('')}}/"+url;
        try {
            const resp = await fetch(ruta);
            const final = await resp.json();
            $("#consultandoServicios").toggleClass("d-none");
            $("#trServices-name").toggleClass("d-none");
            $("#trServices-opt").toggleClass("d-none");
            document.querySelector("#sendForm").removeAttribute("disabled");
            mostrarServicios(final);
        } catch (error) {
            setTimeout( async () => {
                await leerJsonServices(url);
            }, 5000);
        }
    }






        function mostrarServicios(servicios){


            const tableServicios = document.querySelector("#tableServicios");
                let html= '';
                tableServicios.innerHTML= html;
            for( let servicio of servicios ){
                html+=`
                    <tr>
                        <td>${servicio.Name}</td>
                        <td>${servicio.Status}</td>
                        <td><button onclick='cambiarEstado("${servicio.Name}","started")'>Iniciar</button></td>
                        <td><button onclick='cambiarEstado("${servicio.Name}","stopped")'>Detener</button></td>
                        <td><button onclick='cambiarEstado("${servicio.Name}","restarted")'>Reiniciar</button></td>
                    </tr>
                `;
            }
            tableServicios.innerHTML= html;
            createTable("#tableFatherServices");
        }


    </script>
@stop

