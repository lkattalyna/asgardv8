@extends('adminlte::page')
@section('content_header')
<h1>Formulario Cambio Vlan</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('implementation-user')
    @include('layouts.formError')
    @include('layouts.messages')
        <form action="{{ route('virtualization.vlanUpdateStore') }}" method="POST" id="formfield">
            {{ csrf_field() }}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos para el cambio de Vlan</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="vHost">{{ __('Máquinas virtuales') }}</label>
                            </td>
                            <td colspan="3">
                                <select id="vHost" name="vHost[]" size="10" multiple class="form-control input-md" style="width: 100%" required></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="case">{{ __('OT ó RF del proyecto') }}</label>
                            </td>
                            <td td colspan="3">
                                <input type="text" name="case" id="case" class="form-control input-md" value="{{ old('case') }}" maxlength="20"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" placeholder="Ej. OT1000001 ó RF1000001"  required>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr id="tableCluster"></tr>
                    </table>

                </div>
                <div class="card-footer" id="progressbar">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i> Ejecutar
                    </button>
                </div>
            </div>
        </form>
        @include('layouts.wait_modal')
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

		@include('layouts.wait_modal')
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

            //Evento clic (EJECUTAR TAREA)
            $('#sendForm').on('click', function(){
                var maquina = $("#vHost").val();
                var valoresmaquina =  maquina.toString().split(',');
                var name_VM = valoresmaquina[2];
                var edo_maquina = valoresmaquina[5];

                    swal({
                        title: "¿Está seguro?",
                        text: "Está seguro de ejecutar con los parámetros seleccionados",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        buttons: ["Cancelar", "Sí, estoy seguro"],
                    }).then((seguro) => {
                        if (seguro) {
                            if($('#formfield')[0].checkValidity()){
                                $('#formfield').submit();
                            }else{
                                //console.log($('#formfield'));
                                $('#formfield')[0].reportValidity();
                            }
                        }
                    });
            });


            $('#vHost').select2({
                maximumSelectionLength: 10
            });

            //Evento click en el botón (ejecutar) lupa
            var send = document.getElementById('ejecutar');
            send.addEventListener("click", function(){
                var codigo = $('#service').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('virtualization.resourcesVlan') }}',
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

            //Evento click en el botón (Add)
            $(document).on("click",".Vlink",function(e){
                selectedItem='<option value="'+$(this).data('id')+','+$(this).data('vcenter')+','+$(this).data('name')+','+$(this).data('cluster')+'" selected>'+$(this).data('name')+'</option>';
                if($('#vHost :selected').length <= 9){
                    var an = $(this).data('id')+','+$(this).data('vcenter');
                    var vcenter = $(this).data('vcenter');
                    var cluster = $(this).data('cluster');
                    var idVM = $(this).data('id');
                    if($("#vHost option:selected").length >= 1){
                        var found = false;
                        $("#vHost option:selected").each(function() {
                            if($(this).val() == an){
                                found = true
                            }
                        });
                        if(!found){
                            $("#vHost").empty();
                            $("#vHost").append(selectedItem);
                            $('#table_vlans').removeClass('d-none');
                        }
                    }else{
                        $("#vHost").empty();
                        $("#vHost").append(selectedItem);
                        $('#table_vlans').removeClass('d-none');
                    }
                }

                let parametros = {
                _token : $('meta[name="csrf-token"]').attr('content'),
                'cod': 1,
                vcenter,
                idVM


                };
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let parametros2 = {
                    _token : $('meta[name="csrf-token"]').attr('content'),
                    'cod': 2,
                    vcenter,
                    cluster
                }

                $.ajax({
                    type: 'GET',
                    url: '{{ route('virtualization.vlanUpdate') }}',
                    data: parametros2,
                    success: function(respo) {
                    $('#tableCluster').empty().append($(respo));
                    $.ajax({
                    url: "{{route('virtualization.vlanTablePost')}}",
                    type: 'post',
                    data: parametros,
                    success: function({data}) {
                        const {networkadapter,vlanName,type} = data;
                        let i = 0;
                        for( let networkadapterAux of networkadapter ){
                            networkadapterAux = networkadapterAux.replaceAll(' ','_');
                            let ref = document.querySelector(`#${networkadapterAux}`).checked = true;
                            document.querySelector(`#V_${networkadapterAux}`).value = vlanName[i];
                            $(`#N_${networkadapterAux}`).append(document.querySelector(`#N_${networkadapterAux}`).value = vlanName[i]);
                            $(`#NI_${networkadapterAux}`).val(vlanName[i]);
                            $(`#T_${networkadapterAux}`).append(document.querySelector(`#T_${networkadapterAux}`).value = type[i]);
                            i++;
                        }
                    }
                    });
                    }
                })

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
