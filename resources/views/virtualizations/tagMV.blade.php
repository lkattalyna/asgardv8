@extends('adminlte::page')
@section('content_header')
    <h1>Formulario tag maquina virtual </h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('virtualization-run')
        <form action="{{ route('virtualization.tagMVStore') }}" method="POST" id="formfield">
            {{ csrf_field() }}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos para realizar el proceso</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="vHost">{{ __('Maquinas virtuales') }}</label>
                            </td>
                            <td>
                                <select id="vHost" name="vHost[]" size="10" multiple class="form-control input-md" style="width: 100%" required></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="tag">{{ __('Nombre del TAG') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="tag" id="tag" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="VM_Implementacion">VM Implementación</option>
                                        <option value="VM_Operacion">VM Operación</option>
                                        <option value="Primera_Directriz_de_Mario_Cifuentes">Primera Directriz de Mario Cifuentes</option>
                                        <option value="Segunda_Directriz_de_Mario_Cifuentes">Segunda Directriz de Mario Cifuentes</option>
                                        <option value="Tercera_Directriz_de_Mario_Cifuentes">Tercera Directriz de Mario Cifuentes</option>
                                        <option value="Cuarta_Directriz_de_Mario_Cifuentes">Cuarta Directriz de Mario Cifuentes</option>
                                        <option value="Quinta_Directriz_de_Mario_Cifuentes">Quinta Directriz de Mario Cifuentes</option>
                                        <option value="Sexta_Directriz_de_Mario_Cifuentes">Sexta Directriz de Mario Cifuentes</option>
                                    </select>
                                </div>
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

            $('#vHost').select2({
                placeholder: "--Seleccione--",
                allowClear: true,
                maximumSelectionLength: 10,
            });
            $('#tag').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });

            var send = document.getElementById('ejecutar');
            send.addEventListener("click", function(){
                var codigo = $('#service').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('virtualization.operationStep') }}',
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
                selectedItem='<option value="'+$(this).data('id')+','+$(this).data('vcenter')+'" selected>'+$(this).data('name')+'</option>';
                if($('#vHost :selected').length <= 9){
                    var an = $(this).data('id')+','+$(this).data('vcenter');
                    if($("#vHost option:selected").length >= 1){
                        var found = false;
                        $("#vHost option:selected").each(function() {
                            if($(this).val() == an){
                                found = true
                            }
                        });
                        if(!found){
                            $("#vHost").append(selectedItem);
                        }
                    }else{
                        $("#vHost").append(selectedItem);
                    }
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
