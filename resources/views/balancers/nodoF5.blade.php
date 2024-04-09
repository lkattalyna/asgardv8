@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de ejecución nodo F5</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('balancer-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('balancers.nodoF5Store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de ejecución nodo F5</h3>
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
                                    <input type="text" name="host" id="host" class="form-control" readonly>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="name">{{ __('Nombre') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="name" id="name" class="form-control" style="width: 100%" required>
                                        <option></option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="state">{{ __('Estado') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="" disabled selected>--Seleccione--</option>
                                        <option value="disabled">Disabled</option>
                                        <option value="enabled">Enabled</option>
                                        <option value="offline">Offline</option>
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
            $('#name').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            var servidor ='';
            $("#group").change(function(){
                var grupo = $(this).val()
                $.get('getHosts/'+{{ $inventario }}+'/'+grupo+'/local', function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = '<option value="'+grupo+'">Todos</option>'
                    var estado = '';

                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            $.get('getBalancerState/'+ data[i], function(status){
                                if(status == 'active'){
                                    servidor = data[i-1];
                                }
                                if(servidor != ''){
                                    $('#host').val(servidor);
                                    getBalancers(servidor);
                                }
                            }).fail(function() {
                                $('#name').find('option').remove();
                                $('#host').val('Host inaccesible');
                            });
                        }
                    }
                });
            });
            function getBalancers(host){
                $.get('getBalancers/' + host, function(data){
                //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    var select = '';
                    for (var i=0; i<data.length;i++){
                        if(data[i] !== null){
                            select+='<option value="'+data[i]+'">'+data[i]+'</option>';
                        }
                    }
                    $("#name").html(select);
                });
            }
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
