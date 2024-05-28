@extends('adminlte::page')

@section('content_header')
    <h1>Formulario de Segregación de Cliente por Diccionario</h1>
    <hr>
@stop

@section('plugins.Datatables', true)

@section('content')
<style>
    .paginacion{
    display: none;
   
}
</style>
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
        <form id="formulario_Dictionary" method="POST" action="{{ route('customer.saveCustomerDictionary', ['customerID' => $customerID]) }}" enctype="multipart/form-data">
    @csrf
    @method('POST')

    <div id="Dictionary-container" style="width: 25%;">
        <input type="hidden" name="valores_agregados_db[]" value="" />
        @if ($customerDictionaries === null || $customerDictionaries->isEmpty() || count($customerDictionaries) == 0)
            <p>No hay información de la consulta</p>
        @else
            @foreach ($customerDictionaries as $customerDictionary)
                <div class="input-group mb-2" id="val-{{ $customerDictionary->customerdictionaryID }}">
                    <input type="hidden" name="valores_agregados_db[]" value="{{ $customerDictionary->value }}" />
                    <input class="form-control" name="valores_agregados[]" value="{{ $customerDictionary->value }}" disabled />
                    <button class="btn btn-sm btn-danger ml-2" type="button" onclick="eliminarValor(event, 'val-{{ $customerDictionary->customerdictionaryID }}')">Eliminar</button>
                </div>
            @endforeach
        @endif
    </div>
    
    <button type="submit" class="btn btn-sm btn-danger">
        <i class="fa fa-save"></i> Guardar
    </button>
</form>

        </div>
    </div>
    <div class="card card-default">
        <div class="card-header with-border" style="background: #dfe1e4;">
            <h3 class="card-title">Búsqueda</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <td>
                        <label for="service">{{ __('Búsqueda TFM') }}</label>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                            </div>
                            <input type="text" name="service" id="service" class="form-control input-md"
                                value="{{ old('service') }}" maxlength="30" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}"
                                placeholder="Búsqueda por Nomenclatura" required
                                title="Proporcione el nombre exacto de la máquina virtual o código de servicio requerido como se visualiza en la consola de VCenter">
                            <button type="button" class="btn btn-sm btn-danger" id="ejecutar">
                                <i class="fa fa-search"></i>
                            </button>
                            <button class="btn btn-sm btn-danger ml-2" id="agregar">
                                <i class="fa fa-plus"></i> Agregar
                            </button>
                        </div>

                        <!-- Segundo input donde se mostrarán los elementos agregados -->
                        <div id="Dictionary-container" style="margin-top: 10px;"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card card-default paginacion">
        <div class="card-body">
            <table id="example1" class="table table-striped table-bordered" style="display: none;">
                <thead>
                    <tr>
                        <th>Nombre Maquina</th>
                        <th>Estado</th>
                        <th>Memoria</th>
                        <th>CPU</th>
                        <th>Cluster</th>
                        <th>vCenter</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($virtualMachines as $virtualMachine)
                        <tr>
                            <td>{{ $virtualMachine->vmName }}</td>
                            <?php if ($virtualMachine->vmPowerState == "1") { ?>
                            <td style="text-align:center; color: green"><i class="fas fa-power-off"></i></td>
                            <?php } else { ?>
                            <td style="text-align:center; color: red"><i class="fas fa-power-off"></i></td>
                            <?php } ?>
                            <td>{{ $virtualMachine->vmMemoryGB }}</td>
                            <th>{{ $virtualMachine->vmCpuCount }}</th>
                            <td>{{ $virtualMachine->clusterName }}</td>
                            <td>{{ $virtualMachine->vcenterAlias }}</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
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
    </div>
@stop

@section('js')
    <script>
     document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formulario_Dictionary').addEventListener('submit', function(event) {
        var hiddenInputs = document.querySelectorAll('input[name="valores_agregados_db[]"]');
        
        hiddenInputs.forEach(function(input) {
            if (input.value.trim() === '') {
                input.parentNode.removeChild(input);
            }
        });

        // Asegurar que el array `valores_agregados_db[]` esté siempre definido
        if (hiddenInputs.length === 0) {
            var emptyInput = document.createElement('input');
            emptyInput.setAttribute('type', 'hidden');
            emptyInput.setAttribute('name', 'valores_agregados_db[]');
            emptyInput.setAttribute('value', '');
            this.appendChild(emptyInput);
        }
    });

    document.getElementById('agregar').addEventListener('click', function() {
        var service = document.getElementById('service').value.trim();
        if (service) {
            var newInputGroup = document.createElement('div');
            newInputGroup.className = 'input-group mb-2';
            var uniqueId = 'val-' + service.replace(/\s+/g, '-');
            newInputGroup.setAttribute('id', uniqueId);

            var newInput = document.createElement('input');
            newInput.setAttribute('type', 'text');
            newInput.setAttribute('name', 'valores_agregados[]');
            newInput.setAttribute('value', service);
            newInput.setAttribute('class', 'form-control');
            newInput.setAttribute('disabled', 'disabled');

            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'valores_agregados_db[]');
            hiddenInput.setAttribute('value', service);

            var deleteButton = document.createElement('button');
            deleteButton.className = 'btn btn-sm btn-danger ml-2';
            deleteButton.innerText = 'Eliminar';
            deleteButton.type = 'button';
            deleteButton.onclick = function() {
                eliminarValor(event, uniqueId);
            };

            newInputGroup.appendChild(newInput);
            newInputGroup.appendChild(hiddenInput);
            newInputGroup.appendChild(deleteButton);
            document.getElementById('Dictionary-container').appendChild(newInputGroup);
            document.getElementById('service').value = '';
        } else {
            alert('Por favor, ingrese un valor para agregar.');
        }
    });
});

function eliminarValor(event, id) {
    event.preventDefault();
    var elementToRemove = document.getElementById(id);
    if (elementToRemove) {
        if (confirm('¿Seguro que quiere eliminar este valor?')) {
            elementToRemove.parentNode.removeChild(elementToRemove);
        }
    } else {
        console.error('Elemento con ID ' + id + ' no encontrado en el DOM.');
    }
}





        $(document).ready(function() {
            // Ocultar la tabla y la paginación inicialmente
            $('#example1').hide();
            $('.dataTables_paginate').hide();

            var table = $('#example1').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar MENU registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del START al END de un total de TOTAL registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de MAX registros)",
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
                "search": {
                    "smart": false // desactivar la búsqueda inteligente para coincidencias exactas
                }
            });

            // Mostrar la tabla y la paginación al hacer clic en el botón de búsqueda
            $('#ejecutar').on('click', function() {
                var searchString = $('#service').val().trim();
                var contenedorTable = document.querySelector('.paginacion');
                contenedorTable.style.display = 'flex';
 
                if (searchString !== '') {
                    table.search(searchString).draw();
                    $('#example1').show();
                    $('.dataTables_paginate').show();
                }
            });

            // Ocultar la tabla y la paginación si no hay términos de búsqueda en la entrada
            $('#service').on('keyup', function() {
                var searchString = $(this).val().trim();
                var contenedorTable = document.querySelector('.paginacion');
                contenedorTable.style.display = 'none';
 
                if (searchString === '') {
                    $('#example1').hide();
                    $('.dataTables_paginate').hide();
                }
            });

            // Cargar botones para acciones de exportar de datatables
            var buttons = new $.fn.dataTable.Buttons(table, {
                buttons: [{
                    extend: 'copy',
                    text: 'Copiar',
                    className: 'btn btn-sm btn-default'
                }, {
                    extend: 'print',
                    text: 'Imprimir',
                    className: 'btn btn-sm btn-default'
                }, {
                    extend: 'collection',
                    className: 'btn btn-sm btn-default',
                    text: 'Exportar',
                    buttons: [
                        'csv',
                        'excel',
                        'pdf'
                    ]
                }]
            }).container().appendTo('#btn_table');

            // Aplicar la búsqueda a cada columna
            table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        });

        // Script para ejecutar el modal de confirmación de borrado
        $('#confirm-delete').on('show.bs.modal', function(e) {
            var formulario = createForm();

            function createForm() {
                var form = $('<form>', {
                    'method': 'POST',
                    'action': $(e.relatedTarget).data('href')
                });

                var token = $('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': '{{ csrf_token() }}'
                });

                var hiddenInput = $('<input>', {
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

        function agregarValor(id, alias) {
            // Verificar si el cluster ya está presente
            var Dictionarycontainer = document.getElementById('Dictionary-container');
            var alreadyAdded = false;

            Dictionary - container.querySelectorAll('input[name="valores_agregados[][id]"]').forEach(function(input) {
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
                        <h5 class="modal-title">VM ya agregado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¡Este VM ya ha sido agregado!</p>
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
            nuevoCriterioHidden.name = 'valores_agregados[][id]';
            nuevoCriterioHidden.type = 'hidden';
            nuevoCriterioHidden.value = id;

            var nuevoCriterio = document.createElement('input');
            nuevoCriterio.name = 'valores_agregados[][visible]';
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
                eliminarValor(event, id);

            });

            nuevoCriterioDiv.appendChild(nuevoCriterioHidden);
            nuevoCriterioDiv.appendChild(nuevoCriterio);
            nuevoCriterioDiv.appendChild(eliminarCriterioBtn);
            Dictionary - container.appendChild(nuevoCriterioDiv);
        }

        function eliminarValor(event, id) {
    event.preventDefault();
    var elementToRemove = document.getElementById(id);
    if (elementToRemove) {
        if (confirm('¿Seguro que quiere eliminar este valor?')) {
            elementToRemove.parentNode.removeChild(elementToRemove);
        }
    } else {
        console.error('Elemento con ID ' + id + ' no encontrado en el DOM.');
    }
}





    </script>

@stop
