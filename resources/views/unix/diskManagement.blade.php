@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de gestión de discos</h1><hr>
@stop
@section('plugins.Select2', true)
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
        @include('layouts.messages')
        <form action="{{ route('unix.diskManagementStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de gestión de discos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td colspan="2">
                                <h3 class="card-title">Datos Virtual Server</h3>
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
                                <label for="accion">{{ __('Acción') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="accion" id="accion" class="form-control" style="width: 100%" required>
                                        <option value="Etiquetar">Etiquetar</option>
                                        <option value="Listar" selected>Listar</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr id="distroTr" style="display: none">
                            <td>
                                <label for="distro">{{ __('Distribución') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="distro" id="distro" class="form-control" style="width: 100%" required>
                                        <option value="ASM" selected>ASM</option>
                                        <option value="UDEV">UDEV</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <table class="table table-bordered table-hover" id="asm"  style="display: none">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center">Información de los discos a configurar ASM</th>
                            </tr>
                            <tr>
                                <th>ID del disco</th>
                                <th>Etiqueta del disco</th>
                                <th>Etiqueta Oracle ASM</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="dataAsm">
                        </tbody>
                    </table>
                    <table class="table table-bordered table-hover" id="udev" style="display: none" >
                        <thead>
                            <tr>
                                <th colspan="5" class="text-center">Información de los discos a configurar UDEV</th>
                            </tr>
                            <tr>
                                <th>ID del disco</th>
                                <th>Etiqueta del disco</th>
                                <th>Usuario</th>
                                <th>Grupo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="dataUdev">
                        </tbody>
                    </table>
                    <hr>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i> Ejecutar
                    </button>
                </div>
            </div>
        </form>
        <div class="card" id="asmCard" style="display: none">
            <div class="card-body">
                <table class="table table-bordered table-hover" >
                    <tr>
                        <td colspan="2">
                            <h3 class="card-title">Información de los discos a configurar ASM</h3>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="diskIdAsm">{{ __('Id del disco') }}</label>
                        </td>
                        <td>
                            <input type="text" id="diskIdAsm" class="form-control input-md" value="{{ old('diskIdAsm') }}" maxlength="35"
                                placeholder="Id del disco" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="diskEtAsm">{{ __('Etiqueta del disco') }}</label>
                        </td>
                        <td>
                            <input type="text" id="diskEtAsm" class="form-control input-md" value="{{ old('diskEtAsm') }}" maxlength="10"
                                placeholder="Etiqueta del disco" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="diskOracleAsm">{{ __('Etiqueta de Oracle ASM') }}</label>
                        </td>
                        <td>
                            <input type="text" id="diskOracleAsm" class="form-control input-md" value="{{ old('diskOracleAsm') }}" maxlength="10"
                                placeholder="Etiqueta de Oracle ASM" >
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-danger" id="btnAddAsm">Agregar información</button>
            </div>
        </div>
        <div class="card" id="udevCard" style="display: none">
            <div class="card-body">
                <table class="table table-bordered table-hover" >
                    <tr>
                        <td colspan="2">
                            <h3 class="card-title">Información de los discos a configurar UDEV</h3>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="diskIdUdev">{{ __('Id del disco') }}</label>
                        </td>
                        <td>
                            <input type="text" id="diskIdUdev" class="form-control input-md" value="{{ old('diskIdUdev') }}" maxlength="35"
                                placeholder="Id del disco" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="diskEtUdev">{{ __('Etiqueta del disco') }}</label>
                        </td>
                        <td>
                            <input type="text" id="diskEtUdev" class="form-control input-md" value="{{ old('diskEtUdev') }}" maxlength="10"
                                placeholder="Etiqueta del disco" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="userUdev">{{ __('Usuario') }}</label>
                        </td>
                        <td>
                            <input type="text" id="userUdev" class="form-control input-md" value="{{ old('userUdev') }}" maxlength="20"
                                placeholder="Usuario" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="groupUdev">{{ __('Grupo') }}</label>
                        </td>
                        <td>
                            <input type="text" id="groupUdev" class="form-control input-md" value="{{ old('groupUdev') }}" maxlength="20"
                                placeholder="Grupo" >
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button class="btn btn-danger" id="btnAddUdev">Agregar información</button>
            </div>
        </div>
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
            $("#accion").change(function(){
                var accion = $(this).val()
                if(accion == 'Listar'){
                    $("#distroTr").hide();
                    $("#asm").hide();
                    $("#udev").hide();
                    $("#asmCard").hide();
                    $("#udevCard").hide();
                }
                if(accion == 'Etiquetar'){
                    $("#distroTr").show();
                    $("#asm").show();
                    $("#asmCard").show();
                }

            });
            $("#distro").change(function(){
                var distro = $(this).val()
                if(distro == 'ASM'){
                    $("#asm").show();
                    $("#udev").hide();
                    $("#asmCard").show();
                    $("#udevCard").hide();
                }
                if(distro == 'UDEV'){
                    $("#asm").hide();
                    $("#udev").show();
                    $("#asmCard").hide();
                    $("#udevCard").show();
                }

            });
            var i = 1; //contador para asignar id al boton que borrara la fila
            $('#btnAddAsm').click(function() {
                var diskIdAsm = document.getElementById("diskIdAsm").value;
                var diskEtAsm = document.getElementById("diskEtAsm").value;
                var diskOracleAsm = document.getElementById("diskOracleAsm").value;
                if( diskIdAsm != '' && diskEtAsm != '' && diskOracleAsm != ''){
                    var fila = '<tr id="row' + i + '">';
                    fila += '<td>' + diskIdAsm + '</td>';
                    fila += '<td>' + diskEtAsm + '</td>';
                    fila += '<td>' + diskOracleAsm + '</td>';
                    fila += '<td><button type="button" name="removeAsm" id="' + i + '" class="btn btn-danger btn_removeAsm"><i class="fa fa-trash"></i></button></td>';
                    fila += '<input type="hidden" name="asmDisk[]" value="'+diskIdAsm+','+diskEtAsm+','+diskOracleAsm+'"></tr>';
                    i++;
                    $('#asm tr:last').after(fila);
                    $("#dataAsm").append();
                    document.getElementById("diskIdAsm").value ="";
                    document.getElementById("diskEtAsm").value = "";
                    document.getElementById("diskOracleAsm").value = "";
                }
            });
            $('#btnAddUdev').click(function() {
                var diskIdUdev = document.getElementById("diskIdUdev").value;
                var diskEtUdev = document.getElementById("diskEtUdev").value;
                var userUdev = document.getElementById("userUdev").value;
                var groupUdev = document.getElementById("groupUdev").value;
                if( diskIdUdev != '' && diskEtUdev != '' && userUdev != '' && groupUdev != ''){
                    var fila = '<tr id="row' + i + '">';
                    fila += '<td>' + diskIdUdev + '</td>';
                    fila += '<td>' + diskEtUdev + '</td>';
                    fila += '<td>' + userUdev + '</td>';
                    fila += '<td>' + groupUdev + '</td>';
                    fila += '<td><button type="button" name="removeUdev" id="' + i + '" class="btn btn-danger btn_removeUdev"><i class="fa fa-trash"></i></button></td>';
                    fila += '<input type="hidden" name="udevDisk[]" value="'+diskIdUdev+','+diskEtUdev+','+userUdev+','+groupUdev+'"></tr>';
                    i++;
                    $('#udev tr:last').after(fila);
                    $("#dataUdev").append();
                    document.getElementById("diskIdUdev").value ="";
                    document.getElementById("diskEtUdev").value = "";
                    document.getElementById("userUdev").value = "";
                    document.getElementById("groupUdev").value = "";
                }
            });
            $(document).on('click', '.btn_removeAsm', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
            $(document).on('click', '.btn_removeUdev', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
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
