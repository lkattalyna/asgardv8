@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Diagnostico Inicial de Dominios EAP</h1><hr>
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
        <form action="{{ route('amtPH.errorEAPStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de Diagnostico Inicial de Dominios EAP</h3>
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
                                <label for="dominio">{{ __('Dominio') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="dominio" id="dominio" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="CO_Claro_AssurInsp_EAP_Domain_PR">CO_Claro_AssurInsp_EAP_Domain_PR</option>
                                        <option value="CO_Claro_AssurOper_EAP_Domain_PR">CO_Claro_AssurOper_EAP_Domain_PR</option>
                                        <option value="CO_Claro_BillInsp_EAP_Domain_PR">CO_Claro_BillInsp_EAP_Domain_PR</option>
                                        <option value="CO_Claro_BillOper_EAP_Domain_PR">CO_Claro_BillOper_EAP_Domain_PR</option>
                                        <option value="CO_Claro_EnterInsp_EAP_Domain_PR">CO_Claro_EnterInsp_EAP_Domain_PR</option>
                                        <option value="CO_Claro_EnterOper_EAP_Domain_PR">CO_Claro_EnterOper_EAP_Domain_PR</option>
                                        <option value="CO_Claro_FulFillInsp_EAP_Domain_PR">CO_Claro_FulFillInsp_EAP_Domain_PR</option>
                                        <option value="CO_Claro_FulFillOper_EAP_Domain_PR">CO_Claro_FulFillOper_EAP_Domain_PR</option>
                                        <option value="CO_Claro_InfraInsp_EAP_Domain_PR">CO_Claro_InfraInsp_EAP_Domain_PR</option>
                                        <option value="CO_Claro_InfraOper_EAP_Domain_PR">CO_Claro_InfraOper_EAP_Domain_PR</option>
                                        <option value="CO_Claro_OperInsp_EAP_Domain_PR">CO_Claro_OperInsp_EAP_Domain_PR</option>
                                        <option value="CO_Claro_OperOperADV_EAP_Domain_PR">CO_Claro_OperOperADV_EAP_Domain_PR</option>
                                        <option value="CO_Claro_OperOper_EAP_Domain_PR">CO_Claro_OperOper_EAP_Domain_PR</option>
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
            $('#dominio').select2({
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

