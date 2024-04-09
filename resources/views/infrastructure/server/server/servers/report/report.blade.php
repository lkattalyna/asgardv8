@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Modulo Reportes Servidores</h1>
    <hr>
@stop
@section('content')
    @can('user-list')
    <div class="box box-default">
        <div class="box-body">
            <div class="pull-left" id="btn_table">Generar : </div>
        </div>
        
    </div>
    
  
    @include('layouts.messages')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Reporte Servidores</h3>
        </div>
        
        
        <!-- /.box-header -->
        <div class="box-body">
            <div>
            Columnas Dinamicas: <a class="toggle-vis" data-column="0">Codigo De Servicio</a> 
                            - <a class="toggle-vis" data-column="1">Serie</a> 
                                - <a class="toggle-vis" data-column="2">Marca</a> 
                                    - <a class="toggle-vis" data-column="3">Modelo</a> 
                                        - <a class="toggle-vis" data-column="4">Data Center</a> 
                                            - <a class="toggle-vis" data-column="5">Site</a>
                                                - <a class="toggle-vis" data-column="6">Rack</a>
                                                    - <a class="toggle-vis" data-column="7">Cliente</a>
            </div>
        
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Código de servicio</th>
                    <th>Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Data center</th>
                    <th>Site</th>
                    <th>Rack</th>
                    <th>Cliente</th>
                    <!--<th>Und inf</th>
                    <th>Und sup</th>
                    <th>Bahia</th>-->
                    
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                        
                            <td>{{ $server->cod_servicio }}</td>
                            <td>{{ $server->serie }}</td>
                            <td>{{ $server->marca->nombre }}</td>
                            <td>{{ $server->modelo->modelo }} - {{ $server->generacion->generacion }}</td>
                            <td>{{ $server->dataCenter->nombre }}</td>
                            <td>{{ $server->site }}</td>
                            <td>{{ $server->rack }}</td>
                            <td>{{ $server->cliente->nombre }}</td>
                            <!--<td>{{ $server->unidad_inferior }}</td>
                            <td>{{ $server->unidad_superior }}</td>
                            <td>{{ $server->bahia }}</td>-->
                            
                        
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Código de servicio</th>
                        <th>Serie</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Data center</th>
                        <th>Site</th>
                        <th>Rack</th>
                        <th>Cliente</th>
                        <!--<th>Und inf</th>
                        <th>Und sup</th>
                        <th>Bahia</th>-->
                                
                    </tr>
                </tfoot>
            </table>
        </div><!-- /.box-body -->
        
    </div><!-- /.box -->
    @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() 
        {
            var table = $('#example1').DataTable( 
            {
                "scrollY": "200px",
                "paging": false
                
            } );
        
            $('a.toggle-vis').on( 'click', function (e) {
                e.preventDefault();
        
                // Get the column API object
                var column = table.column( $(this).attr('data-column') );
        
                // Toggle the visibility
                column.visible( ! column.visible() );
            } );
            var buttons = new $.fn.dataTable.Buttons(table, 
            {
            buttons: [
                {
                    extend: 'copy',
                    text:'Copiar',
                    className: 'btn btn-sm',
                },{
                    extend: 'print',
                    text:'Imprimir',
                    className: 'btn btn-sm',
                },{
                    extend: 'collection',
                    className: 'btn btn-sm',
                    text: 'Exportar',
                    buttons: [
                        'csv',
                        'excel',
                    ]
                },{
                    extend: 'pdfHtml5',
                    className: 'btn btn-sm',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
                ],
            }).container().appendTo( '#btn_table' );
        } );
        
    </script>
    <script>
        $(document).ready(function() {

            var table = $('#example').DataTable( {
            
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
            "scrollX": true,
            initComplete: function () {
                
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value="">TODOS</option></select>')
                        .appendTo( $(column.footer()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
    
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
    
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
            
        });

        // Cargar botones para acciones de exportar de datatables

        var buttons = new $.fn.dataTable.Buttons(table, 
        {
            buttons: [
                {
                    extend: 'copy',
                    text:'Copiar',
                    className: 'btn btn-sm',
                },{
                    extend: 'print',
                    text:'Imprimir',
                    className: 'btn btn-sm',
                },{
                    extend: 'collection',
                    className: 'btn btn-sm',
                    text: 'Exportar',
                    buttons: [
                        'csv',
                        'excel',
                        'pdf',
                    ]
                },{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }
            ],
        }).container().appendTo( '#btn_table' );
        
    });
           
            
       
    </script>
    
@stop
