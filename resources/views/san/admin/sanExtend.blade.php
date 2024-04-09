@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de estado de SAN extendida</h1><hr>
@stop
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Estado de la SAN  extendida</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Ruta</th>
                        <th>SW Ortezal</th>
                        <th>Puerto</th>
                        <th>Estado</th>
                        <th>Estado</th>
                        <th>Puerto</th>
                        <th>SW Triara</th>
                    </tr>
                    <tr>
                        <td>RUTA LARGA FABRIC 1</td>
                        <td>OAL13_25_6520</td>
                        <td>0</td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td>112</td>
                        <td>EE31_CB1_DCX85</td>
                    </tr>
                    <tr>
                        <td>RUTA CORTA FABRIC 1</td>
                        <td>OAL13_25_6520</td>
                        <td>95</td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td>0</td>
                        <td>EE31_CB1_DCX85</td>
                    </tr>
                    <tr>
                        <td>RUTA LARGA FABRIC 2</td>
                        <td>OAL13_34_6520</td>
                        <td>0</td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td>0</td>
                        <td>EF31_CB1_DCX85</td>
                    </tr>
                    <tr>
                        <td>RUTA CORTA FABRIC 2</td>
                        <td>OAL13_34_6520</td>
                        <td>95</td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td><i class="fa fa-circle" style="color: green"></i></td>
                        <td>112</td>
                        <td>EF31_CB1_DCX85</td>
                    </tr>
                </table>
            </div>
            <div class="card-footer text-center">
                <img src={{ asset('vendor/adminlte/dist/img/sanext.png') }} class="img-fluid rounded">
            </div>
        </div>
        @include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            //$('#cargando').modal('show');
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

