@extends('adminlte::page')
@section('content_header')
    <h1 class="content-max-width">Servidores Desinstalados</h1>
    <hr>
@stop
@section('content')
    @can('user-list')
    <div class="box box-default">
        <div class="box-body">
            
            <div class="pull-left" id="btn_table"></div>
        </div>
    </div>
    @include('layouts.messages')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Servidores Desinstalados En El Sistema</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <!-- /.table-responsive -->
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Código de servicio</th>
                    <th>Serie</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Data center</th>
                    <th>Site</th>
                    <th>Rack</th>
                    <th>Und inf</th>
                    <th>Und sup</th>
                    <th>Bahia</th>
                    <th>Cliente</th>
                </tr>
                </thead>
                <tbody>
                @foreach($servers as $server)
                    <tr>
                        <td class="center">
                            <div class="btn-group">
                                <div class="input-group-btn">
                                @can('user-list')
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Acciones
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href= "{{ route('uninstall.show',$server->id)}}">Rehusar</a></li>
                                    </ul>
                                @endcan
                                </div>
                            </div>
                        </td>
                    
                        <td>{{ $server->cod_servicio }}</td>
                        <td>{{ $server->serie }}</td>
                        <td>{{ $server->marca->nombre }}</td>
                        <td>{{ $server->modelo->modelo }} - {{ $server->generacion->generacion }}</td>
                        <td>{{ $server->dataCenter->nombre }}</td>
                        <td>{{ $server->site }}</td>
                        <td>{{ $server->rack }}</td>
                        <td>{{ $server->unidad_inferior }}</td>
                        <td>{{ $server->unidad_superior }}</td>
                        <td>{{ $server->bahia }}</td>
                        <td>{{ $server->cliente->nombre }}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="overlay" id="cargando"><!-- Animación Cargando -->
            <i class="fa fa-refresh fa-spin"></i>
        </div>
    </div><!-- /.box -->
    @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
