@extends('adminlte::page')
@section('content_header')
<h1> Reporte de monitoreo de estado de puertos</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Reporte de monitoreo de estado de puertos</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>Switch</th>
                            <th>Puerto</th>
                            <th>Frames_tx</th>
                            <th>Frames_rx</th>
                            <th>Enc_in</th>
                            <th>Crc_err</th>
                            <th>Crc_g_eof</th>
                            <th>Too_shrt</th>
                            <th>Too_long</th>
                            <th>Bad_eof</th>
                            <th>Enc_out</th>
                            <th>Disc_c3</th>
                            <th>Link_fail</th>
                            <th>Loss_sync</th>
                            <th>Loss_sig</th>
                            <th>Frjt</th>
                            <th>Fbsy</th>
                            <th>C3_timeout_tx</th>
                            <th>C3_timeout_rx</th>
                            <th>Pcs_err</th>
                            <th>Uncor_err</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
    <script>
        $(document).ready(function () {
            var table = $('#example1').DataTable( {
                serverSide: true,
                ajax: {
                    url: '{{ route('sanLun.index')}}',
                },
                "language": {
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                "order": [[ pos, order ]],
                columns: [
                    {data: "switch"},
                    {data: "puerto"},
                    {data: "frames_tx"},
                    {data: "frames_rx"},
                    {data: "enc_in"},
                    {data: "crc_err"},
                    {data: "crc_g_eof"},
                    {data: "too_shrt"},
                    {data: "too_long"},
                    {data: "bad_eof"},
                    {data: "enc_out"},
                    {data: "disc_c3"},
                    {data: "link_fail"},
                    {data: "loss_sync"},
                    {data: "loss_sig"},
                    {data: "frjt"},
                    {data: "fbsy"},
                    {data: "c3_timeout_tx"},
                    {data: "c3_timeout_rx"},
                    {data: "pcs_err"},
                    {data: "uncor_err"}
                ]
            });
            // Cargar botones para acciones de exportar de datatables

            var buttons = new $.fn.dataTable.Buttons(table, {
                buttons: [
                    {
                        extend: 'copy',
                        text:'Copiar',
                        className: 'btn btn-sm btn-default',
                    },{
                        extend: 'print',
                        text:'Imprimir',
                        //className: 'btn btn-sm btn-danger',
                        className: 'btn btn-sm btn-default',
                    },{
                        extend: 'collection',
                        className: 'btn btn-sm btn-default',
                        text: 'Exportar',
                        buttons: [
                            'csv',
                            'excel',
                            'pdf',
                        ]
                    }
                ],
            }).container().appendTo( '#btn_table' );
        });
    </script>
@endsection
