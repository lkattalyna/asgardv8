@extends('adminlte::page')
@section('content_header')
    <h1>Formulario Aumento de Recursos</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('implementation-user')
    @include('layouts.formError')
    @include('layouts.messages')
        <form action="{{ route('virtualization.resourcesUpgradeStore') }}" method="POST" id="formfield">
            {{ csrf_field() }}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos para el aumento de recursos </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="vHost">{{ __('Máquinas virtuales') }}</label>
                            </td>
                            <td colspan="3" >
                                <select id="vHost" name="vHost[]" size="10" multiple class="form-control input-md" style="width: 100%" required></select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="case">{{ __('OT ó RF del proyecto') }}</label>
                            </td>
                            <td td colspan="3">
                                <input type="text" name="case" id="case" class="form-control input-md" value="{{ old('case') }}" maxlength="20"
                                        pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" placeholder="Ej.  OT1000001 ó RF1000001"  required>
                            </td>
                        </tr>
                        {{-- Prueba carga información --}}
                        <tr>
                            <th>Memoria Actual</th>
                            <td id="valormem" style="color:red; font-weight: bold;"></td>
                            <td id="aummemory">
                               <input type="checkbox" class="chk-box1" name="checkMemory" id="checkMemory" value="1">
                              {{--   <label><input type="radio" class="chk-box1" name="check" value="1" id="checkMemory"></label><br> --}}
                            </td>
                            <td id="memory">
								<div class="input-group">
									<select name="mem" id="mem" class="form-control" style="width: 100%" >
										<option></option>
										<option value="2">2GB</option>
                                        <option value="4">4GB</option>
                                        <option value="6">6GB</option>
                                        <option value="8">8GB</option>
										<option value="10">10GB</option>
										<option value="12">12GB</option>
										<option value="14">14GB</option>
										<option value="16">16GB</option>
										<option value="18">18GB</option>
										<option value="20">20GB</option>
										<option value="22">22GB</option>
										<option value="24">24GB</option>
										<option value="32">32GB</option>
										<option value="48">48GB</option>
										<option value="64">64GB</option>
										<option value="128">128GB</option>
									</select>
								</div>
							</td>
                        </tr>
                        <tr>
                            <th>Vcpu Actual</th>
                            <td id="valorcpu" style="color:red; font-weight: bold;"></td>
                            <td id="aumvcpu">
                               <input type="checkbox" class="chk-box2" name="checkVcpu" id="checkVcpu" value="2">
                              {{--   <label><input type="radio" class="chk-box2" name="check" id="checkVcpu" value="2"></label><br> --}}
                            </td>
                            <td id="vcpu">
								<div class="input-group">
									<select name="cpu" id="cpu" class="form-control" style="width: 100%" >
										<option></option>
										<option value="2">2VCPU</option>
										<option value="4">4VCPU</option>
										<option value="6">6VCPU</option>
										<option value="8">8VCPU</option>
										<option value="10">10VCPU</option>
										<option value="12">12VCPU</option>
										<option value="14">14VCPU</option>
										<option value="15">15VCPU</option>
										<option value="16">16VCPU</option>
										<option value="18">18VCPU</option>
										<option value="20">20VCPU</option>
										<option value="22">22VCPU</option>
										<option value="24">24VCPU</option>
										<option value="26">26VCPU</option>
										<option value="28">28VCPU</option>
										<option value="30">30VCPU</option>
										<option value="32">32VCPU</option>
										<option value="34">34VCPU</option>
										<option value="36">36VCPU</option>
										<option value="38">38VCPU</option>
										<option value="40">40VCPU</option>
										<option value="42">42VCPU</option>
										<option value="44">44VCPU</option>
										<option value="46">46VCPU</option>
										<option value="48">48VCPU</option>
										<option value="64">64VCPU</option>
										<option value="128">128VCPU</option>
									</select>
								</div>
							</td>

                        </tr>
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
			$("#memory").hide();
			$("#vcpu").hide();
            $("#aummemory").hide();
            $("#aumvcpu").hide();
            $("#listmemory").hide();
            $("#listvcpu").hide();

            $("#checkMemory").click(function () {

                if( $('#checkMemory').prop('checked')){
                    document.querySelector("#mem").removeAttribute("required");
                    $("#memory").show();
                    /*  $("#vcpu").hide(); */
                    document.querySelector("#mem").setAttribute("required","");
                }else {
                    $("#memory").hide();

                }
                /*document.querySelector("#mem").removeAttribute("required");
                    $("#memory").show();
                /*  $("#vcpu").hide(); */
                /* document.querySelector("#mem").setAttribute("required",""); */
	        });

            $("#checkVcpu").click(function () {
                if( $('#checkVcpu').prop('checked')){
                    document.querySelector("#cpu").removeAttribute("required");
                    $("#vcpu").show();
                    /*   $("#memory").hide(); */
                    document.querySelector("#cpu").setAttribute("required","");
                }else{
                    $("#vcpu").hide();
                }
                /*document.querySelector("#cpu").removeAttribute("required");
                $("#vcpu").show();
                /*   $("#memory").hide(); */
                /*document.querySelector("#cpu").setAttribute("required",""); */
	        });

            $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });

            // Evento clic (EJECUTAR TAREA)
            $('#sendForm').on('click', function(){
                var maquina = $("#vHost").val();
                var valoresmaquina =  maquina.toString().split(',');
                var name_VM = valoresmaquina[2];
                var edo_maquina = valoresmaquina[5];

                if( $('#checkMemory').prop('checked') && $('#checkVcpu').prop('checked')){
                    var valormemoria   = $("#mem").val();
                    var memoria_actual = valoresmaquina[3];
                    var tipomem    = "Memoria";
                    var aumentomem = "GB";

                    var valorcpu = $("#cpu").val();
                    var cpu_actual = valoresmaquina[4];
                    var tipocpu = "Vcpu";
                    var aumentocpu = "VCPU";
                   //console.log(edo_maquina == 1 && parseInt(valorcpu) < parseInt(cpu_actual) && parseInt(valormemoria) < parseInt(memoria_actual));

                        if (edo_maquina == 1 && parseInt(valormemoria) < parseInt(memoria_actual) && parseInt(valorcpu) > parseInt(cpu_actual) ){
                            swal({
                                title: "Advertencia",
                                text: "Para reducir " + tipomem +" debe apagar la máquina virtual",
                                icon: "info",

                            });

                        }else if (edo_maquina == 1 && parseInt(valorcpu) < parseInt(cpu_actual) && parseInt(valormemoria) > parseInt(memoria_actual) ){
                            swal({
                                title: "Advertencia",
                                text: "Para reducir " + tipocpu +" debe apagar la máquina virtual",
                                icon: "info",
                            });
                        }
                        else if (edo_maquina == 1 && parseInt(valorcpu) < parseInt(cpu_actual) && parseInt(valormemoria) < parseInt(memoria_actual)){

                            swal({
                                title: "Advertencia",
                                text: "Para reducir Memoria y Vcpu debe apagar la máquina virtual",
                                icon: "info",
                            });
                        }
                        else{
                                swal({
                                title: "¿Está seguro?",
                                text: "Está seguro de ejecutar con los parámetros seleccionados:                     Máquina: "+  name_VM  +"                         "+          tipomem+": "+ valormemoria+""+aumentomem+ "   "  + tipocpu+": " +  "    "  +valorcpu+""+aumentocpu ,
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
                        }

                }else if ($('#checkMemory').prop('checked') && $('#checkVcpu').prop('checked') == false){

                    var valor   = $("#mem").val();
                    var memoria_actual = valoresmaquina[3];
                    var tipo    = "Memoria";
                    var aumento = "GB";

                        //Valido si está encendida la Vm y es una reducción de memoria o vcpu
                        if (edo_maquina == 1 && parseInt(valor) < parseInt(memoria_actual)){

                            swal({
                                        title: "Advertencia",
                                        text: "Para reducir " + tipo +" debe apagar la máquina virtual",
                                        icon: "info",

                                    });
                        }else{
                                swal({
                                    title: "¿Está seguro?",
                                    text: "Está seguro de ejecutar con los parámetros seleccionados:                     Máquina: "+  name_VM  +"                         "+          tipo+": "+ valor+""+aumento,
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
                            }

                }else{
                    var valor = $("#cpu").val();
                    var memoria_actual = valoresmaquina[4];
                    var tipo = "Vcpu";
                    var aumento = "VCPU";

                     //Valido si está encendida la Vm y es una reducción de memoria o vcpu
                     if (edo_maquina == 1 && parseInt(valor) < parseInt(memoria_actual)){
                            swal({
                                        title: "Advertencia",
                                        text: "Para reducir " + tipo +" debe apagar la máquina virtual",
                                        icon: "info",

                                    });
                            }else{
                                swal({
                                    title: "¿Está seguro?",
                                    text: "Está seguro de ejecutar con los parámetros seleccionados:                     Máquina: "+  name_VM  +"                         "+          tipo+": "+ valor+""+aumento,
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
                            }
                }
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
                    url: '{{ route('virtualization.resourcessnap') }}',
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
                $("#aummemory").show();
                $("#aumvcpu").show();
                $("#listmemory").show();
                $("#listvcpu").show();

                selectedItem='<option value="'+$(this).data('id')+','+$(this).data('vcenter')+','+$(this).data('name')+','+$(this).data('memory')+','+$(this).data('cpu')+','+$(this).data('power_state')+' " selected>'+$(this).data('name')+'</option>';
                if($('#vHost :selected').length <= 9){
                    var an = $(this).data('id')+','+$(this).data('vcenter');
                    var memoriaanterior = $(this).data('memory');
                    var cpuanterior     = $(this).data('cpu');
                    var estadomaquina   = $(this).data('power_state');

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
                            $("#valormem").empty();
                            $("#valorcpu").empty();
                            $("#valormem").append(memoriaanterior);
                            $("#valorcpu").append(cpuanterior);
                        }
                    }else{
                        $("#vHost").empty();
                        $("#vHost").append(selectedItem);
                        $("#valormem").empty();
                        $("#valorcpu").empty();
                        $("#valormem").append(memoriaanterior);
                        $("#valorcpu").append(cpuanterior);

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
