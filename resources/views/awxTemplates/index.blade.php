@extends('adminlte::page')
@section('content_header')
    <h1> Consultar templates AWX</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('awxTemplate-list')
        <div class="card card-default">
            <div class="card-body">
                @can('awxTemplate-create')
                    <a href="{{ route('awxTemplates.create') }}" class="btn btn-sm btn-danger" id="download">
                        <span class="fa fa-download fa-1x"></span>&nbsp Sincronizar templates
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Templates AWX</h3> 
                <div class="float-sm-right"><h6>Última actualización: {{ $log }}</h6></div>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Inventario</th>
                            <th>Preguntar limite</th>
                            <th>Preguntar variables</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                            <tr>
                                <td>{{ $template->id_template }}</td>
                                <td>{{ $template->name }}</td>
                                <td>{{ $template->id_inventory }}</td>
                                @if($template->ask_limit_on_launch)
                                    <td><span class="fa fa-check"></span></td>
                                @else
                                    <td><span class="fa fa-times"></span></td>
                                @endif
                                @if($template->ask_variables_on_launch)
                                    <td><span class="fa fa-check"></span></td>
                                @else
                                    <td><span class="fa fa-times"></span></td>
                                @endif
                                <td class="center">
                                    @can('awxTemplate-show')
                                        <a href="{{route('awxTemplates.show',$template->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                </td> 
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot  >
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Inventario</th>
                            <td></td>
                            <td></td>
                            <td></td>
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
