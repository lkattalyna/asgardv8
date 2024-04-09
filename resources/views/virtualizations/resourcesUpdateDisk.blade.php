@extends('adminlte::page')
@section('content_header')
    <h1>Resultado ejecución aumento de Disco Duro</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('implementation-user')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('virtualization.resourcesDisk')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card card-default">
            <div class="card-header with-border">
                <h3 class="card-title">Resultado ejecución aumento de Disco Duro</h3>
            </div>
            <div class="card-body">
                    <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Disco duro</th>
                                    <th>Tamaño disco anterior</th>
                                    <th>Tamaño disco actual</th>
                                </tr>
                        @foreach($salidaFinal as $salida)
                                <tr>
                                        <td>{{$salida["hardDisknew"]}}</td>
                                        <td>{{$salida["tamAnt"]}}</td>
                                        <td>{{$salida["valueDisk"]}}</td>
                                </tr>
                        @endforeach
                                <tr>
                                    <th>Resultado Ejecución</th>
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
