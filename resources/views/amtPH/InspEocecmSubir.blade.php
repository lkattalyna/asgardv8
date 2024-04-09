@extends('adminlte::page')
@section('content_header')
    <h1>Formulario Subir CO_EOCECM_WLS_PR</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('amtPH-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('amtPH.InspEocecmSubirStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario Subir CO_EOCECM_WLS_PR</h3>
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
                                    <select name="host[]" id="host" class="form-control" multiple="multiple" style="width: 100%" required></select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="manejado">{{ __('Seleccione el manejado') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="manejado" id="manejado" class="form-control" style="width: 100%" required>
                                        <option value="0">Seleccione...</option>
                                        <option value="WLS_ECM01">WLS_ECM01</option>
                                        <option value="WLS_ECM02">WLS_ECM02</option>
                                        <option value="WLS_ECM03">WLS_ECM03</option>
                                        <option value="WLS_ECM04">WLS_ECM04</option>
                                        <option value="WLS_ECM04">WLS_ECM04</option>
                                        <option value="WLS_ECM05">WLS_ECM05</option>
                                        <option value="WLS_ECM06">WLS_ECM06</option>
                                        <option value="WLS_EOC01">WLS_EOC01</option>
                                        <option value="WLS_EOC02">WLS_EOC02</option>
                                        <option value="WLS_EOC03">WLS_EOC03</option>
                                        <option value="WLS_EOC04">WLS_EOC04</option>
                                        <option value="WLS_EOC05">WLS_EOC05</option>
                                        <option value="WLS_EOC06">WLS_EOC06</option>
                                        <option value="WLS_EOC07">WLS_EOC07</option>
                                        <option value="WLS_EOC08">WLS_EOC08</option>
                                        <option value="WLS_EOC09">WLS_EOC09</option>
                                        <option value="WLS_EOC10">WLS_EOC10</option>
                                        <option value="WLS_EOC11">WLS_EOC11</option>
                                        <option value="WLS_EOC12">WLS_EOC12</option>
                                        <option value="WLS_EOC13">WLS_EOC13</option>
                                        <option value="WLS_EOC14">WLS_EOC14</option>
                                        <option value="WLS_EOC15">WLS_EOC15</option>
                                        <option value="WLS_EOC16">WLS_EOC16</option>
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
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
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

