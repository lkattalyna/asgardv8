@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de asignación de permisos</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('supportEN-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('supportEN.unix.folderPermissionStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de asignación de permisos</h3>
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
                                <label for="option">{{ __('Acción') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select class="form-control" name="option" id="option" style="width: 100%" required>
                                        <option></option>
                                        <option value="NO_recursivo_owner">Cambio Propietario No Recursivo</option>
                                        <option value="RECURSIVO_owner">Cambio Propietario Recursivo</option>
                                        <option value="NO_recursivo_permisos">Cambio Permisos No Recursivo</option>
                                        <option value="RECURSIVO_permisos">Cambio Permisos Recursivo</option>
                                        <option value="NO_RECURSIVO_permisos_propietario">Cambio Permisos y Propietario No Recursivo</option>
                                        <option value="RECURSIVO_permisos_propietario">Cambio Permisos y Propietario Recursivo</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id="trOwner" style="display: none">
                            <td>
                                <label for="owner">{{ __('Propietario') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="owner" id="owner" class="form-control input-md" value="{{ old('owner') }}" maxlength="30"
                                        pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,30}$" placeholder="Propietario" disabled>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="trUgo" style="display: none">
                            <td>
                                <label for="ugo">{{ __('Permisos') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="ugo" id="ugo" class="form-control input-md" value="{{ old('ugo') }}"
                                    pattern="^[0-7]{3}$" placeholder="775" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left"
                                              title="Ayuda" data-content="En caso de desconocer los permisos puede ayudarse del
                                              siguiente <a href='https://chmod-calculator.com/' target='_blank'>link</a>">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="path">{{ __('Ruta') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text" name="path" id="path" class="form-control input-md" value="{{ old('username') }}" maxlength="200"
                                     minlength="2"  placeholder="Ruta" required>
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
            $('[data-toggle="popover"]').popover();
            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#option').select2({
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
            $("#option").change(function(){
                var option = $(this).val()
                if(option == 'NO_recursivo_owner' || option == 'RECURSIVO_owner'){
                    $("#trOwner").show();
                    $("#owner").prop('disabled',false);
                    $("#owner").prop('required',true);
                    $("#trUgo").hide();
                    $("#ugo").prop('disabled',true);
                    $("#ugo").prop('required',false);
                }
                if(option == 'NO_recursivo_permisos' || option == 'RECURSIVO_permisos'){
                    $("#trUgo").show();
                    $("#ugo").prop('disabled',false);
                    $("#ugo").prop('required',true);
                    $("#trOwner").hide();
                    $("#owner").prop('disabled',true);
                    $("#owner").prop('required',false);
                }
                if(option == 'NO_RECURSIVO_permisos_propietario' || option == 'RECURSIVO_permisos_propietario'){
                    $("#trOwner").show();
                    $("#owner").prop('disabled',false);
                    $("#owner").prop('required',true);
                    $("#trUgo").show();
                    $("#ugo").prop('disabled',false);
                    $("#ugo").prop('required',true);
                }

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
