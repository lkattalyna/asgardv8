@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de activación / envío de logs</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('windowsEN-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
		 @include('layouts.formError')
		 @include('layouts.messages')
        <form action="{{ route('windows.activacionEnvioLogsStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de activación / envío de logs         </h3>
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
                                    <select onchange="getLogName()" name="host[]" id="host" class="form-control" style="width: 100%" required>                                                                                                                            
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="logName">{{__('LogName')}}</label>
                            </td>
                            <td>
                                <div id="consultandoServicios" class="d-none">
                                    <div class="alert alert-info alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <p><i class="icon fa fa-info"></i> La tarea se esta ejecutando</p>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <select name="logName" id="logName" class="form-control" style="width:100%" required disabled></select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="email">{{__('Correo Electrónico')}}</label>
                            </td>
                            <td>
                                <div class="input_group">
                                    <input name="email_destinatario" type="email" id="email_destinatario" class="form-control" required disabled>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm" disabled>
                        <i class="fa fa-terminal"></i> Ejecutar
                    </button>
                </div>
            </div>
        </form>
		@include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        //consultar LogNames
        function getLogName(){
            if( $("#host").val() == $("#group").val() ){
                return;
            }

            //$("#tituloServicio").empty().text($("#host").val())
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
                url: "{{route('windows.getListLogNameByHost')}}",
                type: 'post',
                data: parametros,
                success: function({data}) {
                    const { url } = data;
                    $("#consultandoServicios").toggleClass("d-none");
					$('#cargando').modal('show');
                    setTimeout( async () => {
                        await leerJsonLogName(url);
                    }, 20000);
                }
            });
        }
        async function leerJsonLogName(url){
            let ruta = "{{url('')}}/"+url;
            try {
                const resp = await fetch(ruta);
                const final = await resp.json();
                $("#consultandoServicios").toggleClass("d-none");
                document.querySelector("#logName").removeAttribute("disabled");
				document.querySelector("#email_destinatario").removeAttribute("disabled");	
				$('#cargando').modal('hide');
                cargarSelectLogsName(final);
            } catch (error) {
                setTimeout( async () => {
                    await leerJsonLogName(url);
                }, 4000);
            }
        }
        function cargarSelectLogsName(logs){
            const $select= document.querySelector("#logName");
            const option = document.createElement('option'); 
               option.value = '';
               option.text = '--Seleccione--';
               $select.appendChild(option);
            for( let log of logs ){
               const option = document.createElement('option'); 
               option.value = `${log.Log}`;
               option.text = `${log.Log}`;
               $select.appendChild(option);
            }
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
            $('#logName').select2({
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
                   //limpia y deshabilita el select logName
                   const $select = document.querySelector("#logName");
                   const $mail = document.querySelector("#email_destinatario");
                    for (let i = $select.options.length; i >= 0; i--) {
                        $select.remove(i);
                    }
                    $select.setAttribute("disabled", "true");
                    $mail.setAttribute("disabled", "true");
                    $mail.value="";
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
							$('#cargando').modal('show');
							document.querySelector("#sendForm").setAttribute("disabled", "true");
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
			$('#email_destinatario').on('keyup',function(){
				$estadoCampo =document.getElementById('email_destinatario').value.trim();
				if($estadoCampo.length!=0){
					document.querySelector("#sendForm").removeAttribute("disabled");
				}else{
					document.querySelector("#sendForm").setAttribute("disabled", "true");
				}
				
			});
        });
    </script>
@stop
