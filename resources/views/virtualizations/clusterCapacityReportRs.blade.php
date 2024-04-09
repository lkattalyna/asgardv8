@extends('adminlte::page')
@section('content_header')
    <h1> Reporte de capacidad de cluster</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('virtualization-run')
    <div class="card card-default">
        <div class="card-body">
            <a class="btn btn-sm btn-danger" href="{{ route('virtualization.clusterCapacityReport') }}">
                <i class="fa fa-reply"></i> Volver
            </a>
            <div class="float-sm-right" id="btn_table"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Reporte de capacidad de cluster</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-striped table-bordered" >
                <thead>
                    <tr>
                        <th>Segmento</th>
                        <th>VCenter</th>
                        <th>Nombre Clúster</th>
                        <th>Tipo Clúster</th>
                        <th>Host</th>
                        <th># MVs</th>
                        <th># MVs / ON</th>
                        <th>TOTAL_CPU (Ghz)</th>
                        <th>HA_CPU (GHz)</th>
                        <th>CPU_Efectiva (10%)</th>
                        <th>CPU_Disponible (GHz)</th>
                        <th>CPU_Disponible (%)</th>
                        <th>Crecimiento-Pasivo CPU /GHz</th>
                        <th>HA_CPU (S/N)</th>
                        <th>ConsumoMax_CPU (GHz)</th>
                        <th>ConsumoMax_CPU (%)</th>
                        <th>Estado_CPU</th>
                        <th>TOTAL_Mem (GB)</th>
                        <th>HA_Mem (GB)</th>
                        <th>Mem_Efectiva (10%)</th>
                        <th>Mem_Disponible (GB)</th>
                        <th>Mem_Disponible (%)</th>
                        <th>Crecimiento-Pasivo Mem / GB</th>
                        <th>HA_Mem (S/N)</th>
                        <th>ConsumoMax_Mem (GB)</th>
                        <th>ConsumoMax_Mem (%)</th>
                        <th>Estado_Mem</th>
                        <th>Disponibilidad</th>
                        <th>Operación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item->segment }}</td>
                            <td>{{ $item->vcenter }}</td>
                            <td>{{ $item->cluster_name }}</td>
                            <td>{{ $item->type_cluster }}</td>
                            <td>{{ $item->host_count }}</td>
                            <td>{{ $item->vm_count }}</td>
                            <td>{{ $item->vm_count_on }}</td>
                            <td>{{ $item->cpu_total_ghz }}</td>
                            <td>{{ $item->cpu_total_ha }}</td>
                            <td>{{ $item->cpu_success }}</td>
                            <td>{{ $item->cpu_free }}</td>
                            <td>{{ $item->cpu_free_percent }}</td>
                            <td>{{ number_format((0.1+($item->cpu_free_percent/100))*$item->cpu_success,2,".","") }}</td>
                            @if($item->cpu_ha_sn == 'Si')
                                <td style="text-align:center; color: green"><i class="fas fa-dot-circle"></i> {{ $item->cpu_ha_sn }}</td>
                            @elseif($item->cpu_ha_sn == 'No')
                                <td style="text-align:center; color: red"><i class="fas fa-dot-circle"></i> {{ $item->cpu_ha_sn }}</td>
                            @else
                                <td style="text-align:center;">{{ $item->cpu_ha_sn }}</td>
                            @endif
                            <td>{{ $item->cpu_used }}</td>
                            <td>{{ $item->cpu_used_percent }}</td>
                            <td @if($item->cpu_status == 'Alto') class="bg-danger" @elseif($item->cpu_status == 'Moderado') class="bg-success"
                                @elseif($item->cpu_status == 'Normal') class="bg-info" @elseif($item->cpu_status == 'Medio') class="bg-warning" @endif>{{ $item->cpu_status }}</td>
                            <td>{{ $item->memory_total_gb }}</td>
                            <td>{{ $item->memory_total_ha }}</td>
                            <td>{{ $item->memory_success }}</td>
                            <td>{{ $item->memory_free }}</td>
                            <td>{{ $item->memory_free_percent }}</td>
                            <td>{{ number_format((0.1+($item->memory_free_percent/100))*$item->memory_success,2,".","") }}</td>
                            @if($item->memory_ha_sn == 'Si')
                                <td style="text-align:center; color: green"><i class="fas fa-dot-circle"></i> {{ $item->memory_ha_sn }}</td>
                            @elseif($item->memory_ha_sn == 'No')
                                <td style="text-align:center; color: red"><i class="fas fa-dot-circle"></i> {{ $item->memory_ha_sn }}</td>
                            @else
                                <td style="text-align:center;">{{ $item->memory_ha_sn }}</td>
                            @endif
                            <td>{{ $item->memory_used }}</td>
                            <td>{{ $item->memory_used_percent }}</td>
                            <td @if($item->memory_status == 'Alto') class="bg-danger" @elseif($item->memory_status == 'Moderado') class="bg-success"
                                @elseif($item->memory_status == 'Normal') class="bg-info" @elseif($item->memory_status == 'Medio') class="bg-warning" @endif>{{ $item->memory_status }}</td>
                            <td>{{ $item->cluster_availability }}</td>
                            <td>{{ $item->cluster_status }}</td>
                        </tr>
                    @endforeach
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
                "order": [[ 0, "desc" ]],
                "scrollX": true,
            });
            $( '#btn_table' ).empty();
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
                    },{
                        extend: 'colvis',
                        text: 'Visualización',
                        className: 'btn btn-sm btn-default',
                    }
                ],
            }).container().appendTo( '#btn_table' );
        });
    </script>
@endsection
