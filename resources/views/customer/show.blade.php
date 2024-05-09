@extends('adminlte::page')

@section('content_header')
    <h1>Formulario de Segregación de Cliente</h1>
    <hr>
@stop

@section('plugins.Datatables', true)

@section('content')
    <div class="card card-default">
        <div class="card-body">
            <div class="float-sm-right">
                <a class="btn btn-sm btn-danger" href="{{ route('customer.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <div class="card card-default">
        <div class="card-body">
            <form id="formulario_segregacion" method="POST"
                action="{{ route('customer.guardarInformacion', ['customerID' => $customerID]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                {{ csrf_field() }}

                <div class="card card-default">
                    <div class="card-header with-border">
                        <p>Este formulario permitirá agregar los vcenter asociados al cliente</p>
                    </div>
                    <div class="card-body">
                        <div class="card card-default">
                            <div class="card-header with-border" style="background: #dfe1e4;">
                                <h3 class="card-title">Vcenter</h3>
                            </div>
                            <input type="hidden" id="memory" name="memory" value="0">
                        </div>
                        <td>
                            <label for="vcenterAgregado" class="col-form-label">{{ _('vcenter Agregados') }}</label>
                        </td>

                        <div id="vcenter-container">
                            <!-- vcenter agregados dinamicamente -->
                            @foreach ($CustomerVcenters as $vcenterCustomer)
                                <div class="input-group">
                                    <input type="hidden" name="vcenter_agregados[][id]"
                                        value="{{ $vcenterCustomer->fk_vcenterID }}" />
                                    <input class="form-control" name="vcenter_agregados[][visible]"
                                        id="{{ $vcenterCustomer->fk_vcenterID }}"
                                        value="{{ $vcenterCustomer->vcenterData->vcenterAlias }}" disabled>
                                    <button class="btn btn-sm btn-danger ml-2"
                                        onclick="eliminarVcenter('{{ $vcenterCustomer->fk_vcenterID }}')">Eliminar</button>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <!-- /.card-header -->
        <div class="card-header">
            <h3 class="card-title">VCenters registrados en el Sistema</h3>
        </div>
        <!-- /.card-body -->
        <div class="card-body">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Alias</th>
                        <th>Segment</th>
                        <th>IP</th>
                        <th>Estado</th>
                        <th>Rol</th>
                        <th>Version</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Vcenter as $vcenter)
                        <tr>
                            <td>{{ $vcenter->vcenterID }}</td>
                            <td>{{ $vcenter->vcenterAlias }}</td>
                            <td>{{ $vcenter->segment->segmentName }}</td>
                            <td>{{ $vcenter->vcenterIp }}</td>
                            @if ($vcenter->customerState == 0)
                                <td>No Activo</td>
                            @else
                                <td>Activo</td>
                            @endif
                            <td>{{ $vcenter->roles->rolesAlias }}</td>
                            <td>{{ $vcenter->vcenterVersion }}</td>
                            <td>{{ $vcenter->Acciones }}
                                <a href="#" class="btn btn-sm btn-default"
                                    onclick="agregarInformacion('{{ $vcenter->vcenterID }}', '{{ $vcenter->vcenterAlias }}')">
                                    <i class="fa fa-plus" style="color: red"></i>
                                </a>
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
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@stop

<!-- /.card -->
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
                    [0, "asc"]
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

        // document.getElementById("searchInput").addEventListener("keyup", filterTable);

        // Obtener el campo de entrada del nombre del cliente por su ID
        var customerNameInput = document.getElementById('customerName');

        // Agregar un evento de escucha para el evento 'input'
        customerNameInput.addEventListener('input', function() {
            // Convertir el valor del campo a mayúsculas y actualizar el valor del campo
            this.value = this.value.toUpperCase();
        });

        // Obtener el campo de entrada del NIT por su ID
        var customerNITInput = document.getElementById('customerNIT');

        // Agregar un evento de escucha para el evento 'input'
        customerNITInput.addEventListener('input', function() {
            // Obtener el valor del campo de entrada
            var value = this.value.trim();

            // Eliminar cualquier carácter que no sea un dígito
            value = value.replace(/\D/g, '');

            // Añadir guion antes del último dígito si hay 10 dígitos
            if (value.length === 10) {
                value = value.slice(0, -1) + '-' + value.slice(-1);
            }

            // Actualizar el valor del campo de entrada
            this.value = value;
        });

        function agregarInformacion(id, alias) {
            // Verificar si el vCenter ya está presente
            var vcenterContainer = document.getElementById('vcenter-container');
            var alreadyAdded = false;

            vcenterContainer.querySelectorAll('input[name="vcenter_agregados[][id]"]').forEach(function(input) {
                if (input.value === id) {
                    alreadyAdded = true;
                }
            });

            if (alreadyAdded) {
                // Eliminar el modal existente si hay alguno
                $('.modal').remove();

                var modalHtml = `
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">VCenter ya agregado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¡Este vCenter ya ha sido agregado!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>`;

                // Convertir el HTML en un elemento del DOM
                var modalElement = document.createRange().createContextualFragment(modalHtml);

                // Agregar el modal al cuerpo del documento
                document.body.appendChild(modalElement);

                // Mostrar el modal
                $('.modal').modal('show');

                return;
            }

            // Si no está presente, agregarlo
            var nuevoCriterioDiv = document.createElement('div');
            nuevoCriterioDiv.classList.add('input-group');

            var nuevoCriterioHidden = document.createElement('input');
            nuevoCriterioHidden.name = 'vcenter_agregados[][id]';
            nuevoCriterioHidden.type = 'hidden';
            nuevoCriterioHidden.value = id;

            var nuevoCriterio = document.createElement('input');
            nuevoCriterio.name = 'vcenter_agregados[][visible]';
            nuevoCriterio.classList.add('form-control');
            nuevoCriterio.rows = 1;
            nuevoCriterio.value = alias;
            nuevoCriterio.id = id;
            nuevoCriterio.disabled = true;

            var eliminarCriterioBtn = document.createElement('button');
            eliminarCriterioBtn.type = 'button';
            eliminarCriterioBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'ml-2');
            eliminarCriterioBtn.textContent = 'Eliminar';
            eliminarCriterioBtn.addEventListener('click', function() {
                // Remover el div contenedor del botón eliminar
                this.parentNode.parentNode.removeChild(this.parentNode);
            });

            nuevoCriterioDiv.appendChild(nuevoCriterioHidden);
            nuevoCriterioDiv.appendChild(nuevoCriterio);
            nuevoCriterioDiv.appendChild(eliminarCriterioBtn);
            vcenterContainer.appendChild(nuevoCriterioDiv);
        }

        function eliminarVcenter(id) {
            // Eliminar el div contenedor del vcenter
            var divToRemove = document.getElementById(id).parentNode;
            divToRemove.parentNode.removeChild(divToRemove);
        }
    </script>
@stop
