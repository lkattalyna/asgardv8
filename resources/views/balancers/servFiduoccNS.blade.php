@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Deshabilitación/rehabilitación Servidor FIDUOCCIDENTE Citrix NS ADC</h1><hr>
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
        <form action="{{ Route('balancers.servFiduoccNsStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario Deshabilitación/rehabilitación Servidor FIDUOCCIDENTE Citrix NS ADC</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="server">Servidor</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="server" id="server" class="form-control" required>
                                        <option selected disabled>-- Seleccione --</option>
                                        <option value="TD_101_10.61.48.36_IRONHIDE">TD_101_10.61.48.36_IRONHIDE</option>
                                        <option value="TD_101_10.61.48.37_JAZZ">TD_101_10.61.48.37_JAZZ</option>
										<option value="TD_101_10.61.48.43_ElitaOne_FDO0293">TD_101_10.61.48.43_ElitaOne_FDO0293</option>
                                        <option value="TD_101_10.61.48.44_WarPath_FDO0300">TD_101_10.61.48.44_WarPath_FDO0300</option>
										<option value="TD_101_10.61.48.38_Ravage_FDO0291">TD_101_10.61.48.38_Ravage_FDO0291</option>
                                        <option value="TD_101_10.61.48.39_CrankCase_FDO0298">TD_101_10.61.48.39_CrankCase_FDO0298</option>
										<option value="TD_101_10.61.48.40_WheelJack_FDO0292">TD_101_10.61.48.40_WheelJack_FDO0292</option>
                                        <option value="TD_101_10.61.48.41_LaserBreak_FDO0299">TD_101_10.61.48.41_LaserBreak_FDO0299</option>
										<option value="TD_101_192.168.33.16_Jolt">TD_101_192.168.33.16_Jolt</option>
                                        <option value="TD_101_192.168.33.10_P01Risco">TD_101_192.168.33.10_P01Risco</option>
										<option value="TD_101_192.168.38.6_Fallen">TD_101_192.168.38.6_Fallen</option>
                                        <option value="TD_101_192.168.38.7_Snarler">TD_101_192.168.38.7_Snarler</option>
										<option value="TD_101_10.61.48.20_Aquablast">TD_101_10.61.48.20_Aquablast</option>
                                        <option value="TD_101_10.61.48.21_Birdbrain">TD_101_10.61.48.21_Birdbrain</option>
                                    </select>
                                </div>
                            </td>
                            <tr>
                                <td>
                                    <label for="state">Estado</label>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <select name="state" id="state" class="form-control" required>
                                            <option selected disabled>-- Seleccione --</option>
                                            <option value="Disable">Disable</option>
                                            <option value="Enable">Enable</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
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
            /*
            $('#server').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#state').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            /*
            $('#group').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });*/
            /*
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
            });*/
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
