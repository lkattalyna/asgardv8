@extends('adminlte::page')

@section('content_header')
    <h1>Consulta de segregaciones creadas</h1>
    <hr>
@stop

@section('plugins.Datatables', true)

@section('content')
    @can('devState-list')
        <div class="card card-default">
            <div class="card-body">
                @can('devState-create')
                    <a href="{{ route('customer.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo registro
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>

        @include('layouts.messages')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Segregación Clientes</h3>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Customer id</th>
                            <th>Nombre de Cliente</th>
                            <th>NIT</th>
                            <th>Estado</th>
                            <th>Fecha de creación</th>
                            <th>Fecha de modificación</th>
                            <th>Segregación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Customer as $customer)
                            <tr>
                                <td>{{ $customer->customerID }}</td>
                                <td>{{ $customer->customerName }}</td>
                                <td>{{ $customer->customerNIT }}</td>
                                @if ($customer->customerState == 0)
                                    <td>No Activo</td>
                                @else
                                    <td>Activo</td>
                                @endif
                                <td>{{ $customer->customerCreatedAt }}</td>
                                <td>{{ $customer->customerUpdatedAt }}</td>
                                <td>
                                    <a href="" title="VCenter">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-tasks" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                </td>
                                <td class="center">
                                    <a href="{{ route('customer.edit', $customer->customerID) }}" class="btn btn-sm btn-default" title="Editar">
                                        <i class="fa fa-edit" style="color: #0d6aad"></i>
                                    </a>
                                    <a href="#" title="Eliminar" data-href="{{ route('customer.destroy', $customer->customerID) }}" data-toggle="modal" data-target="#confirm-delete">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop

@section('js')
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
        });
    </script>
@stop
