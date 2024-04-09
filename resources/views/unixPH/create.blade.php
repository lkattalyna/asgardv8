@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de Usuario Linux P&H</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('unixPH-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('unixPH.store') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de usuarios</h3>
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
                                    <option value="">Seleccione</option>
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
                                <label for="username">{{ __('Username') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" id="username" class="form-control input-md" value="{{ old('username') }}" maxlength="30"
                                           pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,}" placeholder="Username" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">{{ __('Password') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div  class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control input-md" value="{{ old('password') }}" maxlength="25" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="grupo">{{ __('Grupo') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="grupo" id="grupo" class="form-control">
                                        <option disabled>Selecione</option>
                                        <option value="Remote Users">Remote Users</option>
                                        <option value="Administrators">Administrators</option>
                                        <option value="Users">Users</option>
                                        <option value="admtmx">admtmx</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-plus" id="btn_add_grupo" name="btn_add_grupo" title="Agregar grupo"></i></span>
                                    </div>
                                </div>
                                <div class="input-group" id="div_nuevo_grupo" style="display: none;">
                                    <label for="txt_group">{{ __('Agregar Grupo ') }}</label>
                                    <input type="text" id="txt_grupo" class="form-control input-md" />
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-save" id="btn_new_grupo" name="btn_new_grupo" title="Agregar grupo"></i></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                        <table  class="table table-bordered table-hover" id="tbl_gen_comment" style="display: none;">
                        <tr>
                        <td colspan="6"> <label for="txt_group">{{ __('GENERAR COMENTARIO ') }}</label>
                        </td>
                        </tr>
                        <tr>
                        <td>Numero de Caso
                        </td>
                        <td><input type="text" id="caso" name="caso"/>
                        </td>
                        <td>Nombre Completo
                        </td>
                        <td><input type="text" id="nombre"/>
                        </td>
                        <td>Telefono
                        </td>
                        <td><input type="text" id="telefono"/>
                        </td>
                        </tr>
                        <tr>
                        <td colspan="6">
                        <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-check" id="btn_gen_comment" name="btn_new_grupo" title="Agregar grupo"></i></span>
                                    </div>
                        </td>
                        </tr>
                        </table>
                            <td>
                                <label for="coment">{{ __('Comentarios') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <textarea id="comment" name="comment" class="form-control" rows="3" placeholder="NUMERO CASO - NOMBRE PERSONA"></textarea>
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

            //$('#grupo').select2();
            $("#btn_add_grupo").click(function(){
               // alert('');
               // $('#grupo').append('<option value="foo" selected="selected">Foo</option>');
               $("#div_nuevo_grupo").show();
            })

            $("#btn_new_grupo").click(function(){
                //alert('');
                nuevo_groupo= $("#txt_grupo").val();
                $('#grupo').append('<option value="'+nuevo_groupo+'" selected="selected">'+nuevo_groupo+'</option>');
            })

            $("#group").change(function(){
                var grupo = $(this).val()
                $.get('getHosts/'+{{ $inventario }}+'/'+grupo+'/api', function(data){
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

            $("#comment").click(function(){
                //alert($("#comment").val().length);
                if ($("#comment").val().length == 0){
                    $("#tbl_gen_comment").show();
                }
                if ($("#caso").val().length > 0 &&  $("#nombre").val().length > 0){
                    llena()
                }

                })
                function llena(){
                //alert('llena');
                caso = $("#caso").val();
                nombre = $("#nombre").val();
                telefono = $("#telefono").val();
                $("#comment").val(caso+" - "+nombre+" - "+telefono);
                }

            $("#btn_gen_comment").click(function(){
                llena() ;
            })
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
