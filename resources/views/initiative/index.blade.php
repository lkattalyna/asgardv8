@extends('adminlte::page')

@section('title', 'Consultar automatizaciones')

@section('content_header')
<h1>Consultar Solicitud de Iniciativas de Automatizacion</h1>
<hr>
@stop
@if (Session::has('success'))
{{ Session::get('success') }}
@endif
@section('plugins.Datatables', true)

@section('content')
@can('regImprovement-list')
<div class="card card-default">
    <div class="card-body">
        @can('regImprovement-create')
        <div class="btn-group" role="group" aria-label="Actions">
            <a href="{{ route('initiative.create') }}" class="btn btn-sm btn-danger">
                <span class="fa fa-plus fa-1x"></span>&nbsp Nueva Iniciativa
            </a>
        </div>
        @endcan
        <div class="float-sm-right" id="btn_table"></div>
    </div>
    <!-- Nueva solicitud -->
    <div class="card-body">
        @can('...')
        <div class="btn-group" role="group" aria-label="Actions">
            <a href="{{ route('') }}" class="btn btn-sm btn-danger">
                <span class="fa fa-plus fa-1x"></span>&nbsp Nueva solicitud Automatización
            </a>
        </div>
        @endcan

        <div class="float-sm-right" id="btn_table"></div>
    </div>
</div>


@include('layouts.messages')
<div class="card">
    <!-- /.card-header -->
    <div class="card-header">
        <h3 class="card-title">Iniciativas Registradas en el Sistema</h3>
    </div>
    <!-- /.card-body -->
    <div class="card-body">
        <!-- /.table-responsive -->
        <table id="example1" class="table table-striped table-bordered">
            <thead>
                <tr>

                    <th>ID</th>
                    <th>Nombre de Iniciativa</th>
                    <th>Nombre del Segmento</th>
                    <th>Torre de Servicio</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Initiative as $initiative)
                <tr>
                    <td>{{ $initiative->id }}</td>
                    <td>{{ $initiative->initiative_name }}</td>
                    <td>{{ $initiative->segment->name }}</td>
                    <td>{{ $initiative->service_layer->name }}</td>
                    <td>{{ $initiative->initiative_state->status_name }}</td>
                    <td>{{ $initiative->created_at }}</td>
                    <td>

                        <a href="{{ url('/initiative/show/' . $initiative->id) }}" title="Ver">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a>
                        @if (Auth::user()->id == 1 || $initiative->state === 1)
                        <a href="{{ url('/initiative/edit/' . $initiative->id) }}" title="Editar">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-edit" style="color: #0d6aad"></i>
                            </button>
                        </a>
                        <!-- confirmacion borrado de registro -->
                        <a href="#" title="Eliminar" data-href="{{ route('initiative.destroy', $initiative->id) }}" data-toggle="modal" data-target="#confirm-delete">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-trash" style="color: #c51f1a;"></i>
                            </button>
                        </a>
                        @endif
                        <!--Boton de redireccion formulario improvements -->
                        <a href="{{ route('improvements.create', 
                                        [
                                            'segment' => $initiative->segment,
                                            'service_layer' => $initiative->service_layer,
                                            'initiative_id' => $initiative->id, 
                                            'description' => $initiative->how,
                                            'scope' => $initiative-> want,
                                            'objetive' => $initiative-> for,
                                            'task_type' => $initiative->task_type, 
                                            'aut_type' => $initiative->automation_type
                                        ]
                                        ) }}" title="Ir al Formulario Improvement">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-tag" style="color: #0d6aad"></i>
                            </button>
                        </a>


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

<!-- PAGINACION Y CRITERIOS DE ORGANIZACION ADICIONALES -->
<script>
    $(document).ready(function() {

        var table = $('#example1').DataTable({
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
            "order": [
                [0, "desc"]
            ],

        });
        // Apply the search
        table.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
        // Cargar botones para acciones de exportar de datatables

        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [{
                extend: 'copy',
                text: 'Copiar',
                className: 'btn btn-sm btn-default',
            }, {
                extend: 'print',
                text: 'Imprimir',
                className: 'btn btn-sm btn-default',
            }, {
                extend: 'collection',
                className: 'btn btn-sm btn-default',
                text: 'Exportar',
                buttons: [
                    'csv',
                    'excel',
                    'pdf',
                ]
            }],
        }).container().appendTo('#btn_table');
    });

    // Script para ejecutar el modal de confirmación de borrado

    $('#confirm-delete').on('show.bs.modal', function(e) {
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
        $(this).find('.btn-ok').on('click', function() {
            formulario.submit();
        });
    });
</script>
@stop