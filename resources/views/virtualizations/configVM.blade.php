@extends('adminlte::page')
@section('content_header')
    <h1>Formulario de configuración CPU y Memoria MV</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.ionRangeSlider', true)
@section('content')
    @can('virtualization-run')
        <form action="{{ route('virtualization.snapshotStore') }}" method="POST" id="formfield">
            {{ csrf_field() }}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos para la ejecución del script</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="vHost">{{ __('Maquina virtual') }}</label>
                            </td>
                            <td>
                                <input type="text" id="vHost" name="vHost" class="form-control input-md" readonly required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vCenter">{{ __('Vcenter') }}</label>
                            </td>
                            <td>
                                <input type="text" id="vCenter" name="vCenter" class="form-control input-md" readonly required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vState">{{ __('Estado de la maquina virtual') }}</label>
                            </td>
                            <td>
                                <input type="text" id="vState" name="vState" class="form-control input-md" readonly required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vCpu">{{ __('CPU MV') }}</label>
                            </td>
                            <td>
                                <input type="text" id="vCpu" name="vCpu" class="form-control input-md" readonly required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vMemory">{{ __('Memoria MV') }}</label>
                            </td>
                            <td>
                                <input type="text" id="vMemory" name="vMemory" class="form-control input-md" readonly required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="case">{{ __('Caso relacionado') }}</label>
                            </td>
                            <td>
                                <input type="text" name="case" id="case" class="form-control input-md" value="{{ old('service') }}" maxlength="30"
                                       pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Código de servicio"  required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="type">{{ __('Tipo de solicitud') }}</label>
                            </td>
                            <td>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="Demo" selected>Demo</option>
                                    <option value="Legalizado">Legalizado</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="newMemory">{{ __('Agregar memoria a MV') }}</label>
                            </td>
                            <td>
                                <input type="text" class="js-range-slider" name="newMemory" id="newMemory" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="newCPU">{{ __('Agregar CPU a MV') }}</label>
                            </td>
                            <td>
                                <input type="text" class="js-range-slider" name="newCPU" id="newCPU" value="" />
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
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Datos de la búsqueda</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>
                            <label for="service">{{ __('Código de servicio') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                                </div>
                                <input type="text" name="service" id="service" class="form-control input-md" value="{{ old('service') }}" maxlength="30"
                                       pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Código de servicio"  required
                                       title="Proporcione el nombre exacto de la máquina virtual o código de servicio requerido como se visualiza en la consola de VCenter">

                                <button type="button" class="btn btn-sm btn-danger" id="ejecutar">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Resultado de la búsqueda</h3>
            </div>
            <div class="card-body" id="contenido">

            </div>
        </div>



    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function () {
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
            var $newMemory = $("#newMemory");
            $newMemory.ionRangeSlider({
                min: 2,
                max: 32,
                from: 2,
                step: 2,
                skin: "round"
            });
            var memory_instance = $newMemory.data("ionRangeSlider");
            var $newCPU = $("#newCPU");
            $newCPU.ionRangeSlider({
                min: 1,
                max: 10,
                from: 1,
                step: 1,
                skin: "round"
            });
            var cpu_instance = $newCPU.data("ionRangeSlider");
            var send = document.getElementById('ejecutar');
            send.addEventListener("click", function(){
                var codigo = $('#service').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('virtualization.configVM') }}',
                    dataType: 'json',
                    data: {
                        'cod': codigo,
                    },
                    success: function (data) {
                        $('#contenido').empty().append($(data));
                        createTable();
                    },
                    error: function (data) {
                        //console.log('error');
                        var errors = data.responseJSON;
                        if (errors) {
                            $.each(errors, function (i) {
                                console.log(errors[i]);
                            });
                        }
                    }
                });
            });
            $(document).on("click",".Vlink",function(e){

                if($(this).data('hotc') == 1 && $(this).data('hotm') == 1){
                    if($(this).data('vmemory') >= 32 || $(this).data('vcpu') >= 8){
                        swal({
                            title: "¡Error!",
                            text: "los valores de CPU o memoria exceden la capacidad del script actual",
                            icon: "warning",
                            dangerMode: true,
                        });
                        $('#vHost').val('');
                        $('#vCenter').val('');
                        $('#vState').val('');
                        $('#vMemory').val('');
                        $('#vCpu').val('');cpu_instance.update({
                            min: 1,
                            from: 1
                        });
                        memory_instance.update({
                            min: 2,
                            from: 2
                        });
                    }else{
                        if($(this).data('power') == 1){
                            estado = 'Encendido'
                        }else{
                            estado = 'Apagado'
                        }
                        $('#vHost').val($(this).data('name'));
                        $('#vCenter').val($(this).data('vcenter'));
                        $('#vState').val(estado);
                        $('#vMemory').val($(this).data('vmemory'));
                        $('#vCpu').val($(this).data('vcpu'));
                        cpu_instance.update({
                            min: $(this).data('vcpu'),
                            from: $(this).data('vcpu')
                        });
                        memory_instance.update({
                            min: $(this).data('vmemory'),
                            from: $(this).data('vmemory')
                        });
                    }
                }else{
                    swal({
                        title: "¡Error!",
                        text: "Esta máquina no se puede seleccionar ya que no cuenta con los parámetros de hot add CPU y memoria",
                        icon: "warning",
                        dangerMode: true,
                    });
                    $('#vHost').val('');
                    $('#vCenter').val('');
                    $('#vState').val('');
                    $('#vMemory').val('');
                    $('#vCpu').val('');cpu_instance.update({
                        min: 1,
                        from: 1
                    });
                    memory_instance.update({
                        min: 2,
                        from: 2
                    });
                }

            });
            function createTable() {
                $('#example1').dataTable({
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
        });
    </script>
@endsection
