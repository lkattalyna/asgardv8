@extends('adminlte::page')

@section('content_header')
<h1>Formulario de Segregación de Cliente</h1>
<hr>
@stop

@section('plugins.Select2', true)
@section('plugins.Date-Picker', true)

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

<form id="formulario_segregacion" method="POST" action="{{ route('customer.guardarInformacion', ['customerID' => $customerID]) }}" enctype="multipart/form-data">
    <!-- Cambiado de $customer->id a $customer->customerID -->
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
            <!-- <td>
                <div class="input-group">
                    <textarea class="form-control" id="vcenters" name="vcenters" rows="3"></textarea>
                </div>
            </td> -->
            <div id="vcenter-container">
                <!-- vcenter agregados dinamicamente -->
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
            </td>
        </div>
        </table>
</form>


<table id="example1" class="table table-striped table-bordered">
    <thead>
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Listado de Vcenter</h3>
            </div>
            <input type="hidden" id="memory" name="memory" value="0">
        </div>
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
                <a href="#" <button class="btn btn-sm btn-default"
                    onclick="agregarInformacion('{{ $vcenter->vcenterID }}', '{{ $vcenter->vcenterAlias }}')">
                    <i class="fa fa-plus" style="color: red"></i>
                    </button>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
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

    $(document).ready(function() {
        $('#formfield').keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });
        $('#sendForm').on('click', function() {
            swal({
                title: "¿Esta seguro?",
                text: "Esta completamente seguro de ejecutar la tarea con los parametros seleccionados",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                buttons: ["Cancelar", "Si, estoy seguro"],
            }).then((seguro) => {
                if (seguro) {
                    if ($('#formfield')[0].checkValidity()) {
                        $('#formfield').submit();
                    } else {
                        $('#formfield')[0].reportValidity();
                    }
                }
            });
        });
        $('#vHost').select2({
            maximumSelectionLength: 10
        });


    });

    $(document).on("click", ".Vlink", function(e) {
        selectedItem = '<option value="' + $(this).data('id') + ',' + $(this).data(
                'vcenter') +
            '" selected>' + $(this).data('name') + '</option>';
        if ($('#vHost :selected').length <= 9) {
            var an = $(this).data('id') + ',' + $(this).data('vcenter');
            if ($("#vHost option:selected").length >= 1) {
                var found = false;
                $("#vHost option:selected").each(function() {
                    if ($(this).val() == an) {
                        found = true
                    }
                });
                if (!found) {
                    $("#vHost").append(selectedItem);
                }
            } else {
                $("#vHost").append(selectedItem);
            }

        }
    });

    function createTable() {
        $('#example1').dataTable({
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
            "scrollX": true,
        });
    }

    
});

function agregarInformacion(id, alias) {
    // Código para agregar vcenter
    const vcenterContainer = document.getElementById('vcenter-container');
    console.log('agregando - ' + id)
    const nuevoCriterioDiv = document.createElement('div');
    nuevoCriterioDiv.classList.add('input-group');

    const nuevoCriterioHidden = document.createElement('input');
    nuevoCriterioHidden.name = 'vcenter_agregados[][id]';
    nuevoCriterioHidden.type = 'hidden';
    nuevoCriterioHidden.value = id;

    const nuevoCriterio = document.createElement('input');
    nuevoCriterio.name = 'vcenter_agregados[][visible]';
    nuevoCriterio.classList.add('form-control');
    nuevoCriterio.rows = 1;
    nuevoCriterio.value = alias
    nuevoCriterio.id = id
    nuevoCriterio.disabled = true

     const eliminarCriterioBtn = document.createElement('button');
    eliminarCriterioBtn.type = 'button';
    eliminarCriterioBtn.classList.add('btn', 'btn-sm', 'btn-danger', 'ml-2');
    eliminarCriterioBtn.textContent = 'Eliminar';
    eliminarCriterioBtn.addEventListener('click', function() {
        vcenterContainer.removeChild(nuevoCriterioDiv);
    });

    nuevoCriterioDiv.appendChild(nuevoCriterioHidden);
    nuevoCriterioDiv.appendChild(nuevoCriterio);
    nuevoCriterioDiv.appendChild(eliminarCriterioBtn);
    vcenterContainer.appendChild(nuevoCriterioDiv);
}
</script>
@stop