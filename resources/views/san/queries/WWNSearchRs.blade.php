@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta de WWN</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('san.WWNSearch')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de consulta de WWN</h3>
            </div>
            <div class="card-body">
                @if(!is_null($result))
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Fabric</th>
                            <td>{{ $result['Fabric'] }}</td>
                        </tr>
                        <tr>
                            <th>Switch</th>
                            <td>{{ $result['Sw'] }}</td>
                        </tr>
                        <tr>
                            <th>Puerto</th>
                            <td>{{ $result['Port'] }}</td>
                        </tr>
                        <tr>
                            <th>Ip</th>
                            <td>{{ $result['Ip'] }}</td>
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
