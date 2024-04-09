@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de reportes Virtualización</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('plugins.Date-Picker', true)
@section('plugins.Select2', true)
@section('plugins.Chartjs', true)
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
                                    <option value="1">Filtrado</option>
                                    <option value="2" selected>General</option>
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
                                    <option value="{{ $segment->segmentID }}">{{ $segment->segmentName }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="layer" class="text-center">Vcenters</label>
                        </th>
                        <td>
                            <select class="form-control" name="layer" id="layer" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="datacenter" class="text-center">Datacenter</label>
                        </th>
                        <td>
                            <select class="form-control" name="datacenter" id="datacenter" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="cluster" class="text-center">Cluster</label>
                        </th>
                        <td>
                            <select class="form-control" name="cluster" id="cluster" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>


                    <!--     <tr>
            <td>
                <label for="dcluster1">{{ __('seleccionar') }}</label>
            </td>
            <td>
                <div>
                    <select class="form-control" name="cluster1" id="cluster1" style="width: 100%;" required>
                    <option value="">Seleccione</option>
                    <option value="0">Datastore</option>
                    <option value="1">Vmhost</option>
                    </select>
                </div>
            </td>
        </tr> -->
                    <tr id="seleccionar" style="display: none">
                        <td>
                            <label for="seleccionar1">{{ __('Seleccionar sub consulta') }}</label>
                        </td>
                        <td>
                        <div>
                            <select class="form-control" name="seleccionar1" id="seleccionar1" style="width: 100%;" required>
                            <option value="">Seleccione</option>
                            <option value="0">Datastore</option>
                            <option value="1">Vmhost</option>
                            </select>
                        </div>
                        </td>
                    </tr>

                    <tr id="dts" style="display: none">
                        <th>
                            <label for="datastore" class="text-center">Datastore</label>
                        </th>
                        <td>
                            <select class="form-control" name="datastore" id="datastore" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>
                    <tr id="vmhosts" style="display: none">
                        <th>
                            <label for="vmhost" class="text-center">Vmhost</label>
                        </th>
                        <td>
                            <select class="form-control" name="vmhost" id="vmhost" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="vm" class="text-center">Máquinas virtuales</label>
                        </th>
                        <td>
                            <select class="form-control" name="vm" id="vm" style="width: 100%;" required>
                                <option value="0" selected>Todas</option>
                            </select>
                        </td>
                    </tr>

                  <!--   <tr>
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
                    </tr> -->



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
            $('#datacenter').select2();
            $('#cluster').select2();
         

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

            $("#cluster").change(function(){
                var cluster1 = $(this).val();
                if(cluster1 != 0){
                    $("#seleccionar").show();

                }else{
                    $("#seleccionar").hide();

                }
            });

            $("#seleccionar1").change(function(){
                var seleccion = $(this).val();
                if(seleccion == 0){
                    $("#dts").show();
                    $("#vmhosts").hide();

                }else{
                    $("#vmhosts").show();
                    $("#dts").hide();
                }
            });


            $("#segment").change(function(){
                var segment = $(this).val()
                $.get('getVcenter/'+segment, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].vcenterID+'">'+data[i].vcenterAlias+'</option>';
                    }
                    $("#layer").html(select);
                });
            });
            $("#layer").change(function(){
                var layer = $(this).val()
                $.get('getDatacenter/'+layer, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].datacenterID+'">'+data[i].datacenterName+'</option>';
                    }
                    $("#datacenter").html(select);
                });
            });
            $("#datacenter").change(function(){
                var datacenter = $(this).val()
                $.get('getCluster/'+datacenter, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].clusterID+'">'+data[i].clusterName+'</option>';
                    }
                    $("#cluster").html(select);
                });
            });

            $("#cluster").change(function(){
                var cluster = $(this).val()
                $.get('getdatastore/'+cluster, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].datastoreID+'">'+data[i].datastoreName+'</option>';
                    }
                    $("#datastore").html(select);
                });
            });
            $("#cluster").change(function(){
                var cluster = $(this).val()
                $.get('getvmhost/'+cluster, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].vmhostID+'">'+data[i].vmhostName+'</option>';
                    }
                    $("#vmhost").html(select);
                });
            });
            $("#vmhost").change(function(){
                var vmhost = $(this).val()
                $.get('getvm/'+vmhost, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    select = '<option value="0">Todas</option>';
                    for (var i=0; i<data.length;i++){
                        select+='<option value="'+data[i].vmID+'">'+data[i].vmName+'</option>';
                    }
                    $("#vm").html(select);
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
                    var datacenter = $('#datacenter').val();
                    var cluster = $('#cluster').val();
                    var datastore = $('#datastore').val();
                    var vmhost = $('#vmhost').val();
                    var vm = $('#vm').val();
                    var seleccion = $('#seleccionar1').val();
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
                        url: '{{ route('reports.getGenerateReportVirt') }}',
                        dataType: 'json',
                        data: {
                            'report': report,
                            'segment': segment,
                            'layer': layer,
                            'datacenter': datacenter,
                            'cluster': cluster,
                            'datastore': datastore,
                            'vmhost': vmhost,
                            'vm': vm,
                            'seleccion': seleccion,
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
                }else{                  
                  
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('reports.getGenerateReporGral') }}',
                        dataType: 'json',
                        data: {
                            'report': report,                       
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
                }// fin tipo de reporte 2

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
