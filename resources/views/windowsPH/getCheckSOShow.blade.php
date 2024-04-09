@extends('adminlte::page')
@section('content')
    @can('executionLog-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('windowsPH.getCheckSO') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card card-default">
            <div class="card-header with-border" style="background: #dfe1e4;">
                <h3 class="card-title">Resultado del trabajo</h3>
            </div>
            <div class="card-body">
                <div class="embed-responsive embed-responsive-21by9">
                    <iframe class="embed-responsive-item" src="{{ route('windowsPH.getCheckSOFile',[$folder,$file]) }}"></iframe>
                </div>
            </div>

        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
