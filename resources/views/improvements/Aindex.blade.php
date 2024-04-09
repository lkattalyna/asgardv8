@extends('adminlte::page')
@section('content_header')
    <h1> Consultar automatizaciones</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('regImprovement-list')
        <div class="card card-default">
            <div class="card-body">
                @can('regImprovement-create')
                    <a href="{{ route('improvements.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nueva Automatización
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Automatizaciones registradas en el sistema</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Segmento de servicio</th>
                            <th>Torre de servicio</th>
                            <th>Automatización</th>
                            <th>Periodo</th>
                            <th>Avance</th>
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
                                <td>{{ $improvement->start_date }} a {{ $improvement->end_date }}</td>
                                <td>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-green" style="width: {{ $improvement['total'] }}%">{{ $improvement['total'] }}%</div>
                                    </div>
                                </td>
                                <td class="center">
                                    @can('regImprovement-show')
                                        <a href="{{ route('improvements.show', $improvement->id ) }}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('improvements.history', $improvement->id ) }}" title="Seguimiento del progreso">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-clock" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('regImprovement-edit')
                                        @if($improvement->owner_id == \Illuminate\Support\Facades\Auth::user()->id && $improvement->approval_status == 0)
                                            <a href="{{route('improvements.edit',$improvement->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endif
                                    @endcan
                                    @if($improvement->approval_status == 0 )
                                        @if(\Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->leader_id ||
                                            \Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->coordinator_id)
                                            <a href="{{route('improvements.approval',$improvement->id)}}" title="Aprobar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-check" style="color: #47e50d"></i>
                                                </button>
                                            </a>
                                        @endif
                                    @endif
                                    @can('regImprovement-admin')
                                        @if($improvement->approval_status == 0 )
                                            @if(\Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->leader_id ||
                                                \Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->coordinator_id)
                                                <a href="{{route('improvements.deny',$improvement->id)}}" title="Denegar">
                                                    <button class="btn btn-sm btn-default">
                                                        <i class="fa fa-times-circle" style="color: #0d6aad"></i>
                                                    </button>
                                                </a>
                                            @endif
                                        @endif
                                    @endcan
                                    @if($improvement->test_approval_status == 0 && $improvement->test == 100 )
                                        @if(\Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->leader_id ||
                                            \Illuminate\Support\Facades\Auth::user()->id == $improvement->serviceLayer->coordinator_id)
                                            <a href="{{route('improvements.testApproval',$improvement->id)}}" title="Aprobar pruebas">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-check" style="color: #sxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"></i>
                                                </button>
                                            </a>
                                        @endif
                                    @endif
                                    @if($improvement->test_approval_status == 1 && $improvement->asgard_view == 1 && !$improvement->asgView )
                                        <a href="{{route('devRequests.createWithImprovement',$improvement->id)}}" title="Crear requerimiento de desarrollo">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-file-upload" style="color: #47e50d"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if($improvement->test_approval_status == 1 && $improvement->asgard_view == 1 && $improvement->asgView )
                                        <a href="{{route('devRequests.show',$improvement->asgView->id)}}" title="Ver requerimiento de desarrollo">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-file-invoice" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if($improvement->approval_status == 1 && !$improvement->documentation)
                                        <a href="{{route('documentations.create',$improvement->id)}}" title="Crear documentación">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-folder-plus" style="color: #47e50d"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if($improvement->approval_status == 1 && $improvement->documentation )
                                        <a href="{{route('documentations.show',$improvement->documentation->id)}}" title="Ver documentación">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-book" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if($improvement->tracing < 100)
                                        <a href="{{route('improvements.progressEdit',$improvement->id)}}" title="Registar Avance">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-tasks" style="color: #47e50d"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @can('regImprovement-delete')
                                        <a href="#" title="Eliminar" data-href="{{route('improvements.destroy',$improvement->id)}}" data-toggle="modal" data-target="#confirm-delete">
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
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
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
                    this.api().columns([1, 2]).every( function () {
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