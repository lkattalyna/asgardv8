@extends('adminlte::page')
@section('content_header')
    <h1> Configuración LVM</h1><hr>
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
        <form action="{{ route('unix.configLvmStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de configuración LVM</h3>
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
                                <label for="option">{{ __('Opción') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="option" id="option" class="form-control" style="width: 100%" required>
                                        <option></option>
                                        <option value="list_disk">Listar discos</option>
                                        <option value="conf_lvm">Configurar</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <div id="divDisk">
                                <td>
                                    <label for="disk">{{ __('Disk') }}</label>
                                </td>
                                <td>
                                    <div class="input-group" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                        </div>
                                        <input type="text" name="disk" id="disk" class="form-control input-md" value="{{ old('disk') }}" maxlength="150"
                                            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{3,}" placeholder="Disk" required>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div id="divFs">
                                <td>
                                    <label for="fs">{{ __('File System') }}</label>
                                </td>
                                <td>
                                    <div class="input-group" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                        </div>
                                        <input type="text" name="fs" id="fs" class="form-control input-md" value="{{ old('fs') }}" maxlength="20"
                                            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="File System" required>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div id="divLv">
                                <td>
                                    <label for="lv">{{ __('Logical Volume') }}</label>
                                </td>
                                <td>
                                    <div class="input-group" >
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                        </div>
                                        <input type="text" name="lv" id="lv" class="form-control input-md" value="{{ old('lv') }}" maxlength="20"
                                            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Logical Volume" required>
                                    </div>
                                </td>
                            </div>
                        </tr>
                        <tr>
                            <div id="divSize">
                                <td>
                                    <label for="size">{{ __('Size') }}</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                        </div>
                                        <input type="text" name="size" id="size" class="form-control input-md" value="{{ old('size') }}" maxlength="20"
                                            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Size" required>
                                    </div>
                                </td>
                            </div>
                        </tr>

                        <tr>
                            <div id="divVg">
                                <td>
                                    <label for="vg">{{ __('Volume Group') }}</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-hdd"></i></span>
                                        </div>
                                        <input type="text" name="vg" id="vg" class="form-control input-md" value="{{ old('vg') }}" maxlength="20"
                                            pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Volume Group" required>
                                    </div>
                                </td>
                            </div>
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
            $('#option').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });

            //Script para ocultar cajas de texto
            $('#option').on('change', function(){
                var selectValue = $(this).val();
                switch (selectValue) {
                    case "list_disk":
                        $("#divDisk").hide();
                        $("#disk" ).prop( "disabled", true );
                        $("#divFs").hide();
                        $("#fs" ).prop( "disabled", true );
                        $("#divLv").hide();
                        $("#lv" ).prop( "disabled", true );
                        $("#divSize").hide();
                        $("#size" ).prop( "disabled", true );
                        $("#divVg").hide();
                        $("#vg" ).prop( "disabled", true );
                    break;
                    case "conf_lvm":
                        $("#divDisk").show();
                        $("#disk" ).prop( "disabled", false );
                        $("#divFs").show();
                        $("#fs" ).prop( "disabled", false );
                        $("#divLv").show();
                        $("#lv" ).prop( "disabled", false );
                        $("#divSize").show();
                        $("#size" ).prop( "disabled", false );
                        $("#divVg").show();
                        $("#vg" ).prop( "disabled", false );
                    break;
                }
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
