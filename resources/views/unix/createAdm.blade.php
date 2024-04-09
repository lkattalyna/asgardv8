@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de usuarios administradores</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Password-Verify', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('unixEN-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('unix.createAdmStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de usuarios administradores</h3>
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
                                    <select name="host[]" id="host" class="form-control" multiple="multiple" style="width: 100%" required ></select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="name">{{ __('Nombre completo') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="name" id="name" class="form-control input-md" value="{{ old('name') }}" maxlength="150"
                                           pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,}" placeholder="Nombre Completo" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ident">{{ __('Número de identificación') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="ident" id="ident" class="form-control input-md" value="{{ old('ident') }}" maxlength="20"
                                           pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Identificación" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="email">{{ __('Correo Electrónico') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-at"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="example@example.com" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="username">{{ __('Username') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" id="username" class="form-control input-md" value="{{ old('username') }}" maxlength="30"
                                           pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,30}$" placeholder="Username" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">{{ __('Password') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                    </div>
                                    <input type="password" name="password" id="mypassword" class="form-control input-md" value="{{ old('password') }}" maxlength="25"
                                    title="Una contraseña válida es una cadena con una longitud entre 8 y 25 caracteres, la cual debe contener una letra mayúscula, una letra minúscula y un número."
                                    pattern="(?=^.{8,25}$)(?=.*\d)(?=.*[A-Z])(?=.*[a-z]).*$" required>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="grupo">{{ __('Grupo') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="grupo[]" id="grupo" class="form-control" multiple="multiple" style="width: 100%" required>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->name }}">{{ $grupo->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="case">{{ __('Número de caso') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-hashtag"></i></span>
                                    </div>
                                    <input type="text" name="case" id="case" class="form-control input-md" value="{{ old('case') }}" maxlength="20"
                                           pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Número de caso" required>
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
            $("#mypassword").bootstrapStrength({
                slimBar: true,
                specialchars: 0,
                meterClasses: {
                    weak: "bg-danger",
                    medium: "bg-warning",
                    good: "bg-success"
                }
            });
            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#grupo').select2({
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
