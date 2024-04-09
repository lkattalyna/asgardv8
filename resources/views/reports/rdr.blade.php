@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de reportes Registro-Documentación-Requerimiento</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Date-Picker', true)
@section('plugins.Select2', true)
@section('content')
    @can('report-user')
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
                        <th>
                            <label for="report">{{ __('Tipo de reporte') }}</label>
                        </th>
                        <td>
                            <div>
                                <select class="form-control" name="report" id="report" required>
                                    <option value="1">RDR Filtrado</option>
                                    <option value="2" selected>RDR General</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </table>
                <hr>
                <table class="table table-bordered table-hover" id="filtered" style="display: none">
                    <tr>
                        <th>
                            <label for="segment" class="text-center">Segmento</label>
                        </th>
                        <td>
                            <select class="form-control" name="segment" id="segment" required>
                                <option value="0" selected>Todos</option>
                                @foreach($segments as $segment)
                                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="layer" class="text-center">Capa de servicio</label>
                        </th>
                        <td>
                            <select class="form-control" name="layer" id="layer" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="term">{{ __('Periodo') }}</label>
                        </td>
                        <td>
                            <div>
                                <select class="form-control" name="term" id="term" style="width: 100%;" required>
                                    <option value="0">Seleccionar rango</option>
                                    <option value="all" selected>Todos</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr id="date_start" style="display: none">
                        <td>
                            <label for="d_start">{{ __('Fecha inicial') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="text" name="d_start" id="d_start" class="form-control input-md" value="{{ old('d_start') }}"
                                    pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly>
                            </div>
                        </td>
                    </tr>
                    <tr id="date_end" style="display: none">
                        <td>
                            <label for="d_end">{{ __('Fecha final') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="text" name="d_end" id="d_end" class="form-control input-md" value="{{ old('d_end') }}"
                                    pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-danger" id="buscar">
                    <i class="fa fa-search"></i> Generar reporte
                </button>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Resultados de la búsqueda</h3>
                <div class="float-sm-right" id="btn_table"></div>
            </div>
            <div class="card-body" id="contenido"></div>
        </div>



    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function () {
            $('#d_start').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2018-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            })
            $('#d_end').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2018-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            })
            $('#term').select2();
            $('#layer').select2();
            $("#term").change(function(){
                var term = $(this).val();
                if(term == 0){
                    $("#date_start").show();
                    $("#date_end").show();
                }else{
                    $("#date_start").hide();
                    $("#date_end").hide();
                }
            });
            $("#segment").change(function(){
                var segment = $(this).val()
                $.get('getLayers/'+segment, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $("#layer").html(select);
                });
            });
            // envio reportes
            $("#report").change(function(){
                var report = $(this).val()
                if(report == 1){
                    $("#filtered").show();
                }
                if(report == 2){
                    $("#filtered").hide();
                }
            });
            var send = document.getElementById('buscar');
            send.addEventListener("click", function(){
                $("#errores ul").empty();
                $('#errores').hide();
                var report = $('#report').val();
                var error = false;
                if(report == 1){
                    var segment = $('#segment').val();
                    var layer = $('#layer').val();
                    var term = $('#term').val();
                    var d_start = $('#d_start').val();
                    var d_end = $('#d_end').val();
                    if(term == 0){
                        if(d_start == ''){
                            $('#errores ul').append('<li>Debe indicar una fecha inicial</li>');
                            error = true;
                        }
                        if(d_end == ''){
                            $('#errores ul').append('<li>Debe indicar una fecha final</li>');
                            error = true;
                        }
                        if(error){
                            $('#errores').show();
                        }
                    }
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('reports.rdrReport') }}',
                        dataType: 'json',
                        data: {
                            'report': report,
                            'segment': segment,
                            'layer': layer,
                            'term': term,
                            'd_start': d_start,
                            'd_end': d_end,
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
                }
            });
            // Fin reportes
            function createTable() {
                var table = $('#example1').DataTable({
                    initComplete: function () {
                        this.api().columns([0, 1]).every( function () {
                            var column = this;
                            var select = $('<select><option value="">Todos</option></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );

                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    },
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
                $( '#btn_table' ).empty();
                // Cargar botones para acciones de exportar de datatables
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
                        },{
                            extend: 'colvis',
                            text: 'Visualización',
                            className: 'btn btn-sm btn-default',
                        }
                    ],
                }).container().appendTo( '#btn_table' );
            }
            // fin create table
        });
    </script>
@endsection
