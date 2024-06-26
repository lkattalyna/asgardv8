@extends('adminlte::page')

@section('content_header')
    <h1>Formulario de Edición de Cliente</h1>
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

    <form method="POST" action="{{ route('customer.update', $customer->customerID) }}"> <!-- Cambiado de $customer->id a $customer->customerID -->
        @csrf
        @method('PUT')
        <div class="card card-default">
            <div class="card-header with-border">
                <p>Este formulario permitirá editar un nuevo cliente</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <!--nombre del cliente-->
                    <tr>
                        <th>
                            <label for="customerID" class="text-center">Nombre del Cliente</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <textarea name="customerName" id="customerName" class="form-control" placeholder="Nombre del Cliente" maxlength="200" rows="2" required>{{ old('customerName', $customer->customerName) }}</textarea>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Indique el nombre del cliente">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!--NIT del cliente-->
                    <tr>
                        <th>
                            <label for="customerName" class="text-center">Nit del Cliente</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <input type="text" name="customerNIT" id="customerNIT" class="form-control" placeholder="NIT del Cliente" maxlength="10" value="{{ old('customerNIT', $customer->customerNIT) }}" readonly>
                                <div class="input-group-append">
                                    <span class="input-group-text" data-toggle="popover" data-html="true" data-placement="left" title="Ayuda" data-content="Indique el NIT del cliente">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <!--Estado del cliente-->
                    <tr>
                        <th>
                            <label for="customerNIT" class="text-md-right">Estado del Cliente</label>
                        </th>
                        <td>
                            <select class="form-control" name="customerState" id="customerState" style="width: 100%;" required>
                                <option value="1" {{ old('customerState', $customer->customerState) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('customerState', $customer->customerState) == 0 ? 'selected' : '' }}>No Activo</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="fa fa-save"></i> Guardar
            </button>
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
            
        });
         // Función para verificar si el NIT ya existe
         function checkNIT() {
            var nit = $('#customerNIT').val(); // Obtener el valor del NIT

            $.ajax({
                url: "{{ route('checkNit') }}", // Ruta a tu controlador para verificar el NIT
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    nit: nit
                },
                success: function(response) {
                    if (response.exists) {
                        $('#nitError').text('El NIT ya existe en nuestros registros.'); // Mostrar mensaje de error
                        $('#submitBtn').prop('disabled', true); // Deshabilitar el botón de enviar
                    } else {
                        $('#nitError').text(''); // Limpiar mensaje de error si no existe
                        $('#submitBtn').prop('disabled', false); // Habilitar el botón de enviar
                    }
                }
            });
        }

        // Agregar un evento de escucha para verificar el NIT cuando cambia
        $('#customerNIT').on('input', function() {
            checkNIT();
        });
    </script>
@stop
