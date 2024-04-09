@extends('adminlte::page')
@section('content_header')
<h1> Consultar puertos registrados</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('content')
    @can('sanPort-list')
        <div class="card card-default">
            <div class="card-body">
                <a class="btn btn-sm btn-danger" href="{{ route('sanPorts.report')}}">
                    <i class="fa fa-text"></i> Reporte general de puertos
                </a>
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Puertos registrados en el sistema</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>
                            <label for="sw">{{ __('Switch') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                                </div>
                                <select name="sw" id="sw" class="form-control">
                                    <option></option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->sw }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-sm btn-danger" id="searchTable">
                                    <i class="fa fa-search"></i> Buscar
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Resultados de la búsqueda</h3>
            </div>
            <div class="card-body" id="contenido">

            </div>
        </div>
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#sw').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            var send = document.getElementById('searchTable');
            send.addEventListener("click", function(){
                var sw = $('#sw').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('sanPorts.getPorts') }}',
                    dataType: 'json',
                    data: {
                        'sw': sw,
                        'tp': 'table',
                    },
                    success: function (data) {
                        $('#contenido').empty().append($(data));
                        createTable();
                    },
                    error: function (data) {
                        //console.log('error');
                        var errors = data.responseJSON;
                        if (errors) {
                            $.each(errors, function (i) {
                                console.log(errors[i]);
                            });
                        }
                    }
                });
            });
            function createTable() {
                $('#example1').dataTable({
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla",
                        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                });
            }
        });
    </script>
@endsection
