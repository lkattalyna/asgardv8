@extends('adminlte::page')
@section('content_header')
    <h1> Consultar automatizaciones proyectadas 2021</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('regImprovement-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regImprovement-create')
                    <a href="{{ route('regImprovementMin.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nueva automatización
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Automatizaciones registradas en el sistema para el 2021</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Segmento de servicio</th>
                            <th>Capa de servicio</th>
                            <th>Automatización</th>
                            <th>Entrega proyectada</th>
                            <th>ID Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($improvements as $improvement)
                            <tr>
                                <td>{{ $improvement->id }}</td>
                                <td>{{ $improvement->serviceSegment->name }}</td>
                                <td>{{ $improvement->serviceLayer->name }}</td>
                                <td>{{ $improvement->playbook_name }}</td>
                                <td>{{ $improvement->end_month }}</td>
                                <td>{{ $improvement->improvement }}</td>
                                <td class="center">
                                    @can('regImprovement-show')
                                        <a href="{{ route('regImprovementMin.show', $improvement->id ) }}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('regImprovement-edit')
                                        @if(\Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->leader_id ||
                                        \Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->coordinator_id)
                                            <a href="{{route('regImprovementMin.edit',$improvement->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('regImprovement-delete')
                                        <a href="#" title="Eliminar" data-href="{{route('regImprovementMin.destroy',$improvement->id)}}" data-toggle="modal" data-target="#confirm-delete">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                            </button>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Segmento</th>
                            <th>Capa de servicio</th>
                            <th></th>
                            <th>Entrega proyectada</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @include('layouts.del_modal')
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
                initComplete: function () {
                    this.api().columns([1, 2, 4]).every( function () {
                        var column = this;
                        var select = $('<select><option value="">Todos</option></select>')
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
            // Apply the search
            table.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
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

        // Scrript para ejecutar el modal de confirmación de borrado

        $('#confirm-delete').on('show.bs.modal', function (e) {
            var formulario = createForm();
            function createForm() {
                var form =
                    $('<form>', {
                        'method': 'POST',
                        'action': $(e.relatedTarget).data('href')
                    });

                var token =
                    $('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': '<?php echo csrf_token(); ?>'
                    });

                var hiddenInput =
                    $('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': 'DELETE'
                    });

                return form.append(token, hiddenInput).appendTo('body');
            }
            $(this).find('.btn-ok').on('click', function () {
                formulario.submit();
            });
        });
    </script>
@stop
