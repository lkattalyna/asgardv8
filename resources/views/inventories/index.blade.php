@extends('adminlte::page')
@section('content_header')
    <h1> Consultar inventario</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('inventory-list')
        <div class="card card-default">
            <div class="card-body">
                @can('inventory-edit')
                    <a href="{{ route('inventories.create') }}" class="btn btn-sm btn-danger" id="download">
                        <span class="fa fa-download fa-1x"></span>&nbsp Sincronizar inventario
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card overflow-auto" >
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Inventario del el sistema</h3>
                <div class="float-sm-right"><h6>Última actualización: {{ $log }}</h6></div>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID Inventario</th>
                            <th>Nombre del Inventario</th>
                            <th>ID Grupo</th>
                            <th>Nombre del Grupo</th>
                            <th>Host</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventarios as $inventario)
                            <tr>
                                <td>{{ $inventario->id_inventory }}</td>
                                <td>{{ $inventario->name_inventory }}</td>
                                <td>{{ $inventario->id_group }}</td>
                                <td>{{ $inventario->name_group }}</td>
                                <td>{{ $inventario->name_host }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot  >
                        <tr>
                            <th>ID Inventario</th>
                            <th>Nombre del Inventario</th>
                            <th>ID Grupo</th>
                            <th>Nombre del Grupo</th>
                            <th>Host</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        @include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableCF')
    <script>
        $(document).on('click','#download', function(e) { $('#cargando').modal('show'); });
    </script>
@stop
