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
        <form id="formulario_cluster" method="POST" enctype="multipart/form-data">
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
                        @foreach($clusters as $cluster)
                            <div class="input-group">
                                <input type="hidden" name="cluster_agregados[][id]" value="{{ $cluster->id }}">
                                <input class="form-control" name="cluster_agregados[][visible]" value="{{ $cluster->clusterName }}">
                                <button class="btn btn-sm btn-danger ml-2" onclick="eliminarCluster({{ $cluster->id }})">Eliminar</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </form>
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
                        @foreach($clusters as $cluster)
                            <tr>
                                <td>{{ $cluster->clusterID }}</td>
                                <td>{{ $cluster->clusterName }}</td>
                                <td>{{ $cluster->clusterTotalVm }}</td>
                                <td></td>
                                <td>{{-- Aquí puedes poner las acciones si las necesitas --}}
                                    <a href="#" class="btn btn-sm btn-default" onclick="agregarInformacion('{{ $cluster->clusterID }}', '{{ $cluster->clusterName }}')">
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
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
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
            ],

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

    // Obtener el campo de entrada del nombre del cliente por su ID
    var customerNameInput = document.getElementById('customerName');

    // Agregar un evento de escucha para el evento 'input'
    customerNameInput.addEventListener('input', function () {
        // Convertir el valor del campo a mayúsculas y actualizar el valor del campo
        this.value = this.value.toUpperCase();
    });

    // Obtener el campo de entrada del NIT por su ID
    var customerNITInput = document.getElementById('customerNIT');

    // Agregar un evento de escucha para el evento 'input'
    customerNITInput.addEventListener('input', function () {
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
        // Lógica para agregar información
    }

    function eliminarCluster(id) {
        // Lógica para eliminar un cluster
    }
</script>
@stop
