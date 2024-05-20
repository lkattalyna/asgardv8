@extends('adminlte::page')
@section('content_header')

@section('content_header')
    <h1>Formulario de Segregación de Cliente por Diccionario</h1>
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
            <form id="formulario_cluster" method="POST"
                action="{{ route('customer.saveClusters', ['customerID' => $customer->customerID]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                {{ csrf_field() }}

                <div class="card card-default">
                    <div class="card-header with-border">
                        <p>Este formulario permitirá realizar la segregación por Diccionario</p>
                    </div>
                    <div class="card-body" style="width: 25%;">
                        <td>
                            <label for="clusterAgregado" class="col-form-label">{{ _('CLUSTER AGREGADOS') }}</label>
                        </td>
                        <div id="cluster-container">
                            @if ($customerClusters === null || $customerClusters->isEmpty() || count($customerClusters) == 0)
                                <p>No se han agregado clusters</p>
                            @else
                                <!-- Clústeres agregados dinámicamente -->
                                @foreach ($customerClusters as $cluster)
                                    <div class="input-group">
                                        <input type="hidden" name="cluster_agregados[][id]"
                                            value="{{ $cluster->fk_clusterID }}" />
                                        <input class="form-control" name="cluster_agregados[][visible]"
                                            id="{{ $cluster->fk_clusterID }}"
                                            value="{{ $cluster->clusterData->clusterName }}" disabled>
                                        <button class="btn btn-sm btn-danger ml-2"
                                            onclick="eliminarCluster('{{ $cluster->fk_clusterID }}')">Eliminar</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- Botón de guardar -->
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
                @can('virtualization-run')
                    <div class="card card-default">
                        <div class="card-header with-border" style="background: #dfe1e4;">
                            <h3 class="card-title">Datos de la búsqueda</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <td>
                                        <label for="service">{{ __('Código de servicio') }}</label>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                                            </div>
                                            <input type="text" name="service" id="service" class="form-control input-md"
                                                value="{{ old('service') }}" maxlength="30"
                                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Código de servicio"
                                                required
                                                title="Proporcione el nombre exacto de la máquina virtual o código de servicio requerido como se visualiza en la consola de VCenter">

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
                @else
                    @include('layouts.forbidden_1')
                @endcan
            @stop
        </form>
    </div>
</div>
@stop
@section('js')
    <script>
        $(document).ready(function () {
            var send = document.getElementById('ejecutar');
            send.addEventListener("click", function(){
                var codigo = $('#service').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('virtualization.diagnostic') }}',
                    dataType: 'json',
                    data: {
                        'cod': codigo,
                    },
                    success: function (data) {
                        $('#contenido').empty().append($(data));
                        createTable();
                    },
                    error: function (data) {
                        //console.log('error');
                        var errors = data.responseJSON;
                        if (errors) {
                            $.each(errors, function (i) {
                                console.log(errors[i]);
                            });
                        }
                    }
                });
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
@endsection
