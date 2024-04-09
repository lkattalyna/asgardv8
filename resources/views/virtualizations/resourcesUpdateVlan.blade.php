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
                    <a class="btn btn-sm btn-danger" href="{{ route('virtualization.vlanUpdate')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Formulario de consulta cambio de Vlan</h3>
            </div>
            <div class="card-body">
                    <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Tarjeta de red</th>
                                    <th>Vlan Anterior</th>
                                    <th>Vlan Actual</th>
                                </tr>
                        @foreach($salidaFinal as $salida)

                                <tr>
                                        <td>{{$salida["NetworkAdapternew"]}}</td>
                                        <td>{{$salida["vlanAnt"]}}</td>
                                        <td>{{$salida["vlanNew"]}}</td>
                                </tr>
                        @endforeach
                                <tr>
                                    <th>Resultado Maniobra</th>
                                    <td>@if($results['status'] == 'Success') <i class="fa fa-circle" style="color: green"></i> @else <i class="fa fa-circle" style="color: red"></i> @endif{{ $results['status'] }}</td>
                                </tr>
                    </table>
            </div>
        </div>
		@include('layouts.wait_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
