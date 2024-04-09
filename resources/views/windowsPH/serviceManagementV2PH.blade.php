@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de gestión de servicios Windows<h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('windowsPH-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('windowsPH.serviceManagementV2') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de gestión de servicios Windows</h3>
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
                                    <select name="host[]" id="host" class="form-control" style="width: 100%" ></select>
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
                                    <label for="service">{{ __('Nombre del servicio') }}</label>
                                </td>
                                <td>
                                    <input readonly type="text" name="service" id="service" class="form-control input-md" value="{{ old('service') }}" maxlength="50"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Nombre del servicio" required>
                                </td>
                            </tr>

                            <tr id="trServices-opt" class="d-none">
                                <td>
                                    <label for="option">{{ __('Acción') }}</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <select readonly name="option" id="option" class="form-control" style="width: 100%" required>
                                            <option></option>
                                            <option value="stop">Detener</option>
                                            <option value="start">Iniciar</option>
                                            <option value="restart">Reiniciar</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                        </table>
                </div>
                <div class="card-footer">
                    <button type="button" disabled class="btn btn-sm btn-danger" id="sendForm">
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
                            <th>DisplayName</th>
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
    <script>

    function consultarServicios() {

        if( $("#host").val() == $("#group").val() ){
            return;
        }

        $("#tituloServicio").empty().text($("#host").val())
        let parametros = {
            _token : $('meta[name="csrf-token"]').attr('content'),
            'host': $("#host").val()
        };

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{route('windowsPH.getServicesByHost')}}",
            type: 'post',
            data: parametros,
            success: function({data}) {
                const { url } = data;
                $("#consultandoServicios").toggleClass("d-none");
                setTimeout( async () => {
                    await leerJsonServices(url);
                }, 45000);
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


        function createTable(name) {
            $(name).dataTable({

                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "scrollX": true,
            });
        }

        function mostrarServicios({ metrics:servicios }){
            const tableServicios = document.querySelector("#tableServicios");
                let html= '';
                tableServicios.innerHTML= html;
            for( let servicio of servicios ){
                html+=`
                    <tr>
                        <td>${servicio.Name}</td>
                        <td>${servicio.DisplayName}</td>
                        <td>${servicio.Status}</td>
                        <td><button onclick='cambiarEstado("${servicio.Name}","start")'>Iniciar</button></td>
                        <td><button onclick='cambiarEstado("${servicio.Name}","stop")'>Detener</button></td>
                        <td><button onclick='cambiarEstado("${servicio.Name}","restart")'>Reiniciar</button></td>
                    </tr>
                `;
            }
            tableServicios.innerHTML= html;
            createTable("#tableFatherServices");
        }


        function cambiarEstado (nombre,estado){
            $("#service").val(nombre);
            $("#option").val(estado).trigger('change');
        }

        //mostrarServicios(x);


        $(document).ready(function() {
            $('#group').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#option').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $("#option").change(function(){
                var opt = $(this).val()
                if(opt == 'listar'){
                    $( "#service" ).prop( "disabled", true );
                }else{
                    $( "#service" ).prop( "disabled", false );
                }
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

