@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta de zonas</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('san.ZoneSearch')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
            @if(!is_null($zonas))
                @foreach ($zonas as $zona)
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">{{ $zona['name'] }}</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Zona</th>
                                    <th>WWN Destino</th>
                                    <th>Estado</th>
                                    <th>Ubicación</th>
                                </tr>
                                @foreach ($zona['zonas'] as $zna)
                                    <tr>
                                        <td>{{ $zna['Zona'] }}</td>
                                        <td>{{ $zna['Destino'] }}</td>
                                        <td>@if($zna['Estado'] == 'Online') <i class="fa fa-circle" style="color: green"></i> @else <i class="fa fa-circle" style="color: red"></i> @endif{{ $zna['Estado'] }}</td>
                                        <td>{{ $zna['switch'] }} / {{ $zna['Puerto'] }} </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="card card-default">
                    <div class="card-header with-border">
                        <h3 class="card-title">Formulario de consulta de WWN</h3>
                    </div>
                    <div class="card-body">
                        <p>No existen datos para la consulta realizada</p>
                    </div>
                </div>

            @endif

    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
