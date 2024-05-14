@extends('adminlte::page')

@section('content_header')
    <h1>Formulario de Segregación de Cliente por Cluster</h1>
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
        <form id="formulario_cluster" method="POST" action="{{ route('customer.guardarInformacion', ['customerID' => $customerID]) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            {{ csrf_field() }}

            <div class="card card-default">
                <div class="card-header with-border">
                    <p>Este formulario permitirá realizar la segregación por Cluster</p>
                </div>
                <div class="card-body" style="width: 25%;">
                <label for="clusterAgregado" class="col-form-label">{{ _('CLUSTER AGREGADOS') }}</label>
                <div id="cluster-container">
                    <!-- Clústeres agregados dinámicamente -->
                    @forelse ($customerClusters as $cluster)
                    <div class="input-group">
                        <input type="hidden" name="cluster_agregados[][id]" value="{{ $cluster->id }}" />
                        <input class="form-control" name="cluster_agregados[][visible]"value="{{ $cluster->clusterName }}" disabled>
                        <button class="btn btn-sm btn-danger ml-2"
                        onclick="eliminarCluster('{{ $cluster->id }}')">Eliminar</button>
                    </div>
                    @empty
                    <p>No se han agregado clusters</p>
                    @endforelse
                </div>
                <!-- Botón de guardar -->
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </form>
</div>
</div>
<div class="card card-default">
    <div class="card-body">
            <table id="example1" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Total Maquinas</th>
                        <th>IP</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($clustersDisponibles as $cluster)
                        <tr>
                            <td>{{ $cluster->clusterID }}</td>
                            <td>{{ $cluster->clusterName }}</td>
                            <td>{{ $cluster->clusterTotalVm }}</td>
                            <td></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-default"
                                    onclick="agregarCluster('{{ $cluster->clusterID }}', '{{ $cluster->clusterName }}')">
                                    <i class="fa fa-plus" style="color: red"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay clusters disponibles</td>
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
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).ready(function () {
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
            ]
        });
        
        // Apply the search
        table.columns().every(function () {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function () {
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
    });

    // Script para ejecutar el modal de confirmación de borrado
    $('#confirm-delete').on('show.bs.modal', function (e) {
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
        $(this).find('.btn-ok').on('click', function () {
            formulario.submit();
        });
    });

    function agregarCluster(id, alias) {
        // Verificar si el cluster ya está presente
        var clusterContainer = document.getElementById('cluster-container');
        var alreadyAdded = false;

        clusterContainer.querySelectorAll('input[name="cluster_agregados[][id]"]').forEach(function (input) {
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
                        <h5 class="modal-title">Cluster ya agregado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¡Este cluster ya ha sido agregado!</p>
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
        nuevoCriterioHidden.name = 'cluster_agregados[][id]';
        nuevoCriterioHidden.type = 'hidden';
        nuevoCriterioHidden.value = id;

        var nuevoCriterio = document.createElement('input');
        nuevoCriterio.name = 'cluster_agregados[][visible]';
        nuevoCriterio.classList.add('form-control');
        nuevoCriterio.rows = 1;
        nuevoCriterio.value = alias;
        nuevoCriterio.id = id;
        nuevoCriterio.disabled = true;

        var eliminarCriterioBtn = document.createElement('button');
        eliminarCriterioBtn.type = 'button';
        eliminarCriterioBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'ml-2');
        eliminarCriterioBtn.textContent = 'Eliminar';
        eliminarCriterioBtn.addEventListener('click', function () {
            // Remover el div contenedor del botón eliminar
            this.parentNode.parentNode.removeChild(this.parentNode);
        });

        nuevoCriterioDiv.appendChild(nuevoCriterioHidden);
        nuevoCriterioDiv.appendChild(nuevoCriterio);
        nuevoCriterioDiv.appendChild(eliminarCriterioBtn);
        clusterContainer.appendChild(nuevoCriterioDiv);
    }

    function eliminarCluster(id) {
        // Eliminar el div contenedor del cluster
        var divToRemove = document.getElementById(id).parentNode;
        divToRemove.parentNode.removeChild(divToRemove);
    }
</script>
@stop



