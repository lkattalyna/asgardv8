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

<form method="POST" action="{{ route('customer.show', $customer->customerID) }}">
    <!-- Cambiado de $customer->id a $customer->customerID -->
    @csrf
    @method('PUT')
    {{ csrf_field() }}

    <div class="card card-default">
        <div class="card-header with-border">
            <p>Este formulario permitirá agregar los vcenter asociados al cliente</p>
        </div>
        <div class="card-body">
            <table>
                <div class="card card-default">
                    <div class="card-header with-border" style="background: #dfe1e4;">
                        <h3 class="card-title">Vcenter</h3>
                    </div>
                    <input type="hidden" id="memory" name="memory" value="0">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
        </div>
</form>
</table>
<div class="card card-default">
    <div class="card-header with-border" style="background: #dfe1e4;">
        <h3 class="card-title">Selección de Vcenter asociado</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <tr>
                <td>
                    <label for="service">{{ __('Vcenter') }}</label>
                </td>
                <td>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                        </div>
                        <input type="text" name="service" id="service" class="form-control input-md"
                            value="{{ old('service') }}" maxlength="30" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}"
                            placeholder="Seleccione el vcenter" required
                            title="Seleccione el vcenter que esté asociado a la cuenta">

                        <button type="button" class="btn btn-sm btn-danger" id="ejecutar">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="card card-default">
    <div class="card-header with-border" style="background: #dfe1e4;">
        <h3 class="card-title">Resultado de la búsqueda</h3>
    </div>
    <div class="card-body" id="contenido">
    </div>
</div>
</form>
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
</script>
@stop