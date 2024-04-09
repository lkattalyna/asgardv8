@extends('adminlte::page')
@section('content_header')
    <h1> Formulario Verificacion Commvault Central</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('telephony-run')
        <div class="alert alert-danger" style="display: none;" id="errores">
            <strong>Whoops!</strong> Hay algunos problemas con los datos del formulario.<br><br>
            <ul>

            </ul>
        </div>
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Datos de la búsqueda</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>
                            <label for="customer">{{ __('Usuario') }}</label>
                        </td>
                        <td>
                            <div>
                                <select class="form-control" name="customer" id="customer" required>
                                    <option value="todos" selected>Todos</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->commvaultClientName }}">{{ $customer->commvaultClientName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="tipo">{{ __('Fechas inicial') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="text" name="f_ini" id="f_ini" class="form-control input-md" value="{{ old('f_ini') }}"
                                    pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="tipo">{{ __('Fechas final') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="text" name="f_fin" id="f_fin" class="form-control input-md" value="{{ old('f_fin') }}"
                                    pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-danger" id="buscar">
                    <i class="fa fa-search"></i> Buscar
                </button>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Resultados de la búsqueda</h3>
                <div class="float-sm-right" id="btn_table"></div>
            </div>
            <div class="card-body" id="contenido">

            </div>
        </div>



    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $('#f_ini').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2018-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
        })
        $('#f_fin').datepicker({
            format: 'yyyy-mm-dd',
            startDate: "2018-01-01",
            todayBtn: "linked",
            orientation: "bottom auto",
            language: "es",
            todayHighlight: true,
            autoclose: true,
        })
        $(document).ready(function () {
            var send = document.getElementById('buscar');
            send.addEventListener("click", function(){
                $("#errores ul").empty();
                $('#errores').hide();
                var customer = $('#customer').val();
                var f_ini = $('#f_ini').val();
                var f_fin = $('#f_fin').val();
                var error = false;
                if(f_ini == ''){
                    $('#errores ul').append('<li>Debe indicar una fecha inicial</li>');
                    error = true;
                }
                if(f_fin == ''){
                    $('#errores ul').append('<li>Debe indicar una fecha final</li>');
                    error = true;
                }
                if(error){
                    $('#errores').show();
                }
                $.ajax({
                    type: 'GET',
                    url: '{{ route('analytics.central') }}',
                    dataType: 'json',
                    data: {
                        'customer': customer,
                        'f_ini': f_ini,
                        'f_fin': f_fin,
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
                    }
                });
                var buttons = new $.fn.dataTable.Buttons(table, {
                    buttons: [
                        {
                            extend: 'copy',
                            text:'Copiar',
                            className: 'btn btn-sm btn-default',
                        },{
                            extend: 'print',
                            text:'Imprimir',
                            //className: 'btn btn-sm btn-danger',
                            className: 'btn btn-sm btn-default',
                        },{
                            extend: 'collection',
                            className: 'btn btn-sm btn-default',
                            text: 'Exportar',
                            buttons: [
                                'csv',
                                'excel',
                                'pdf',
                            ]
                        }
                    ],
                }).container().appendTo( '#btn_table' );
            }
        });
    </script>
@endsection
