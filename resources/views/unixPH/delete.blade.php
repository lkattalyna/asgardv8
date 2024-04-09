@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Eliminar usuario P&H</h1><hr>
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
        <form action="{{ route('unixPH.deleteStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Eliminar Usuarios Unix P&H</h3>
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
            $('#sub_grupo').select2();

            //$('#grupo').select2();
            $("#btn_add_subgrupo").click(function(){
               $("#div_nuevo_subgrupo").show();
            })

            $("#sub_grupo").change(function(){
                var selectedText = $("#sub_grupo option:selected").html();
                //alert( selectedText );
                if ( selectedText == 'No Cambiar Sub Grupo'){
                    //alert('Default_Gruop');
                    $("#val_subgrupos").val('Default_Gruop');
                    $("#sub_grupo option").remove();
                    xx();
                }else{
                    $("#val_subgrupos").val('OK');
                }


            })
            function xx(){
                $('#sub_grupo').append('<option value="No Cambiar Sub Grupo" selected="selected">No Cambiar Sub Grupo</option>');
                $('#sub_grupo').append('<option value="Administrators" >Administrators</option>');
                $('#sub_grupo').append('<option value="Users" >Users</option>');
                $('#sub_grupo').append('<option value="admtmx">admtmx</option>');


            }

            $("#btn_save_subgrupo").click(function(){
                nuevo_subgroupo= $("#txt_subgrupo").val();
                $('#sub_grupo').append('<option value="'+nuevo_subgroupo+'" selected="selected">'+nuevo_subgroupo+'</option>');
            })

            $("#btn_add_grupo").click(function(){
               // alert('');
               // $('#grupo').append('<option value="foo" selected="selected">Foo</option>');
               $("#div_nuevo_grupo").show();
            })
            $("#btn_new_subgrupo").click(function(){
              alert('sub');

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
