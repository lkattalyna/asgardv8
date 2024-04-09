@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta de estados de puerto</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('san.portState')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de consulta de estados de puerto</h3>
            </div>
            <div class="card-body">
                @if(!is_null($results))
                    <table class="table table-bordered table-hover">
                    @if(sizeof($results) == 5)
                        <tr>
                            <th>Puerto</th>
                            <td>{{ $results['Port'] }}</td>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <td>{{ $results['PortName'] }}</td>
                        </tr>
                        <tr>
                            <th>Estado</th>
                            <td>@if($results['State'] == 'Online') <i class="fa fa-circle" style="color: green"></i> @else <i class="fa fa-circle" style="color: red"></i> @endif{{ $results['State'] }}</td>
                        </tr>
                        <tr>
                            <th>Port Wwn</th>
                            <td>{{ $results['PortWwnOfDevice'] }}</td>
                        </tr>
                    @else
                        @foreach ($results as $result)
                            <tr>
                                <th>Puerto</th>
                                <td>{{ $result['Port'] }}</td>
                            </tr>
                            <tr>
                                <th>Nombre</th>
                                <td>{{ $result['PortName'] }}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td>@if($result['State'] == 'Online') <i class="fa fa-circle" style="color: green"></i> @else <i class="fa fa-circle" style="color: red"></i> @endif{{ $result['State'] }}</td>
                            </tr>
                            <tr>
                                <th>Port Wwn</th>
                                <td>{{ $result['PortWwnOfDevice'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                        @endforeach
                    @endif
                    </table>
                @else
                    <p>No existen datos para la consulta realizada</p>
                @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
