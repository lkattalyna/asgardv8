@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta WWN/NAA Discos</h1><hr>
@stop
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('san.wwnNaa')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de consulta WWN/NAA Discos</h3>
            </div>
            <div class="card-body">
                @if(!is_null($result))
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Marca del Storage</th>
                            <td>{{ $result['vendor'] }}</td>
                        </tr>
                        <tr>
                            <th>Nombre del Storage</th>
                            <td>{{ $result['name'] }}</td>
                        </tr>
                        <tr>
                            <th>Serial del Storage</th>
                            <td>{{ $result['serial'] }}</td>
                        </tr>
                        <tr>
                            <th>LUN/CU-ldev (Dec)</th>
                            <td>{{ $result['lundec'] }}</td>
                        </tr>
                        <tr>
                            <th>LUN/CU-ldev (Hex)</th>
                            <td>{{ $result['lunhex'] }}</td>
                        </tr>
                        <tr>
                            <th>Pool</th>
                            <td>{{ $result['pool'] }}</td>
                        </tr>
                        <tr>
                            <th>Capacidad</th>
                            <td>{{ $result['capacity'] }}</td>
                        </tr>
                        <tr>
                            <th>Nombre de la LUN</th>
                            <td>{{ $result['lunName'] }}</td>
                        </tr>
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
