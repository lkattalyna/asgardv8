@extends('adminlte::page')
@section('content_header')
    <h1> Resultado de la ejecución del commando {{ $command }}</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('san.fabricCommand')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @if(count($results) != 4)
            @foreach ($results as $result)
                <div class="card card-default">
                    <div class="card-header with-border">
                        <h3 class="card-title">{{ $result['switch_name'] }}</h3>
                    </div>
                    <div class="card-body">
                        @if(is_null($result['error']))
                            @if(is_array($result['command_Output']))
                                @foreach ($result['command_Output'] as $line)
                                    <p>{{ $line }}</p>
                                @endforeach
                            @else
                                <p>{{ $result['command_Output'] }}</p>
                            @endif
                        @else
                            <p>Error: {{ $result['error'] }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">{{ $results['switch_name'] }}</h3>
                </div>
                <div class="card-body">
                @if(is_null($results['error']))
                    @if(is_array($results['command_Output']))
                        @foreach ($results['command_Output'] as $line)
                            <p>{{ $line }}</p>
                        @endforeach
                    @else
                        <p>{{ $results['command_Output'] }}</p>
                    @endif
                @else
                    <p>Error: {{ $results['error'] }}</p>
                @endif
                </div>
            </div>
        @endif
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
