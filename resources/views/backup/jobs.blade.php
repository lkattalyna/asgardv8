@extends('adminlte::page')
@section('content_header')
    <!--<h1> Formulario de relanzamiento Jobs</h1><hr>-->
    <div class="card">
        <div class="card-header">
            <div>
                <h1 class="card-title">Formulario de relanzamiento Jobs</h1>
            </div>
        </div>
    </div>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('backup-run')
        <div class="card card-danger">
            <div class="card-header">

                <h3 class="card-title">Relanzamiento Jobs Backup</h3>

                <div class="card-tools">
                  <!-- This will cause the card to maximize when clicked -->
                  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                  <!-- This will cause the card to collapse when clicked -->
                  <!--<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>-->
                  <!-- This will cause the card to be removed when clicked -->
                  <!--<button type="button" class="btn btn-tool" href="{{ route('home')}}" data-card-widget="remove"><i class="fas fa-times"></i></button>-->
                </div>
                <!-- /.card-tools -->
        </div>
        @include('layouts.formError')

        <form action="{{ Route('backup.jobStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="buscar" class="col-sm-4 control-label">Acciones para ejecutar:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="buscar" id="buscar" required>
                                <option disabled selected>--Seleccione--</option>
                                <option value="1">Consultar Estado del Relanzamiento de Jobs</option>
                                <option value="2">Iniciar Proceso de Relanzamiento de Jobs</option>
                                <option value="3">Detener Proceso de Relanzamiento de Jobs</option>
                                <option value="4">Exportar Jobs</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10" id="divMeses" style="display: none">
                            <label for="meses" class="col-sm-4 control-label">Meses:</label>
                            <select class="form-control" name="meses" id="meses" required>
                                <option disabled selected>--Seleccione--</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-terminal"></i>&nbsp Ejecutar
                    </button>
                </div>

        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#host').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });
            $('#buscar').on('change', function(){
                var selectValue = $(this).val();
                switch (selectValue) {
                    case "1":
                        $("#divMeses").hide();
                    break;
                    case "2":
                        $("#divMeses").hide();
                    break;
                    case "3":
                        $("#divMeses").hide();
                    break;
                    case "4":
                        $("#divMeses").show();
                    break;
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
