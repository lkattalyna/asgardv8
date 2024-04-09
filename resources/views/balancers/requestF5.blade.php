@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de generación de Request F5</h1><hr>
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
        <form action="{{ route('balancers.requestF5Store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de generación de Request F5</h3>
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
                                <label for="name">{{ __('Nombre del request') }}</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="name" class="form-control input-md" value="{{ old('name') }}" maxlength="50"
                                        pattern="^[a-zA-Z0-9-_]{2,50}$" placeholder="Nombre del request" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="cn">{{ __('Common name') }}</label>
                            </td>
                            <td>
                                <input type="text" name="cn" id="cn" class="form-control input-md" value="{{ old('cn') }}" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" placeholder="Common name" required>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="mail" class="text-md-right">Mail</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <input type="email" name="mail" id="mail" class="form-control" value="{{ old('mail') }}" placeholder="Ej: example@example.com (opcional)" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="org">{{ __('Organización o empresa') }}</label>
                            </td>
                            <td>
                                <input type="text" name="org" id="org" class="form-control input-md" value="{{ old('org') }}" maxlength="50"
                                        pattern="^[a-zA-Z0-9-_]{2,50}$" placeholder="Organización o empresa" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ou">{{ __('Área') }}</label>
                            </td>
                            <td>
                                <input type="text" name="ou" id="ou" class="form-control input-md" value="{{ old('ou') }}" maxlength="50"
                                        pattern="^[a-zA-Z0-9-_]{2,50}$" placeholder="Área" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="subject">{{ __('Subject Alternative Name (Opcional)') }}</label>
                            </td>
                            <td>
                                <input type="text" name="subject" id="subject" class="form-control input-md" value="{{ old('subject') }}" maxlength="50"
                                    pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" placeholder="(Opcional)">
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
                                }
                            }).fail(function() {
                                $('#host').val('Host inaccesible');
                            });
                        }
                    }
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
