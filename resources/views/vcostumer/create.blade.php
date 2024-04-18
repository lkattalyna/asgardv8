@extends('adminlte::page')

@section('content_header')
    <h1>Formulario de Registro de Clientes</h1>
    <hr>
@stop

@section('plugins.Select2', true)
@section('plugins.Date-Picker', true)

@section('content')
    <div class="card card-default">
        <div class="card-body">
            <div class="float-sm-right">
                <a class="btn btn-sm btn-danger" href="{{ route('vcostumer.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')

    <form action="" method="post" enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="card card-default">
            <div class="card-header with-border">
                <p>Este formulario permitirá registrar un nuevo cliente</p>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <!--nombre del cliente-->
                    <tr>
                        <th>
                            <label for="initiativeName" class="text-center">Nombre del Cliente</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <textarea name="customerName" id="customerName" class="form-control" placeholder="Nombre del Cliente" maxlength="200" rows="2" required>{{ old('customerName') }}</textarea>
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
                            <label for="initiativeName" class="text-center">Nit del Cliente</label>
                        </th>
                        <td>
                            <div class="input-group">
                                <textarea name="customerNIT" id="customerNIT" class="form-control" placeholder="NIT del Cliente" maxlength="200" rows="2" required>{{ old('customerNIT') }}</textarea>
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
                            <label for="customerState" class="text-md-right">Estado del Cliente</label>
                        </th>
                        <td>
                            <select class="form-control" name="customerState" id="customerState" style="width: 100%;" required>
                                <option></option>
                                <option value="Acción">Registrado</option>
                                <option value="Consulta">No Registrado</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>

    <script>
        // Obtener el campo de entrada por su ID
        var customerNameInput = document.getElementById('customerName');

        // Agregar un evento de escucha para el evento 'input'
        customerNameInput.addEventListener('input', function() {
            // Convertir el valor del campo a mayúsculas y actualizar el valor del campo
            this.value = this.value.toUpperCase();
        });
    </script>
@stop
