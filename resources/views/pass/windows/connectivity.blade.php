@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Conectividad Windows</h1><hr>
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
        <form action="{{ route('windows.connectivityStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario conectividad de windows</h3>
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
                                    <select name="host[]" id="host" class="form-control" multiple="multiple" style="width: 100%" required></select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="host">{{ __('IP Destino') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="Destino" id="Destino" class="form-control"  style="width: 100%" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="group">{{ __('Tipo de Conexión') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select onchange="cambiarTipo(this)" name="tipo" id="tipo" class="form-control" style="width: 100%" required>
                                        <option selected value="Ping">Ping</option>
                                        <option value="Validacion">Validación Puerto</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        {{-- <tr id="puertoTR" class="d-none">
                            <td>
                                <label for="group">{{ __('Puerto') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="number" class="form-control"  style="width: 100%" disabled id="puertoNAME" name="puerto" min="1">
                                </div>
                            </td>
                        </tr> --}}
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
        });
    </script>
@stop



