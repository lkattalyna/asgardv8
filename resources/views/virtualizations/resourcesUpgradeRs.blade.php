@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta cambio de recursos</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('implementation-user')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('virtualization.resourcesUpgrade')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de consulta cambio de recursos Memoria</h3>
            </div>
            <div class="card-body">
                @if(!is_null($results))
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Máquina</th>
                            <td>{{ $results['vmname'] }}</td>
                        </tr>
                        <tr>
                                <th>Ram Anterior</th>
                                <td>{{ $results['ram_old']}}</td>
                        </tr>
                        <tr>
                                <th>Ram Actual</th>
                                <td>{{ $results['ram_new'] }}</td>
                        </tr>
                        <tr>
                            <th>Resultado Maniobra</th>
                            <td>@if($results['status'] == 'Success') <i class="fa fa-circle" style="color: green"></i> @else <i class="fa fa-circle" style="color: red"></i> @endif{{ $results['status'] }}</td>
                        </tr>

                    </table>
                @else
                    <p>No existen datos para la consulta realizada</p>
                @endif
            </div>
        </div>
		@include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
