@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de ejecución de comandos remotos</h1><hr>
@stop
@section('content')
    @can('virtualization-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('virtualization.commandExe')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @if($type == 'ESXi')
            <div class="card card-default">
                <div class="card-body">
                    @if(is_array($results))
                        @foreach ($results as $result)
                            <p>{{ $result }}</p>
                        @endforeach
                    @else
                        <p>{{ $results }}</p>
                    @endif
                </div>
            </div>
        @else
            @foreach ($results as $result)
                <div class="card card-default">
                    <div class="card-body">
                        @foreach ($result as $key => $value)
                            <div class="form-group">
                                <label for="name" class="control-label">{{ $key }}: </label>
                                @if(is_array($value))
                                    @foreach($value as $item) {{ $item }} / @endforeach
                                @elseif(is_object($value))
                                    @foreach($value as $item => $val) {{ $item }}: {{ $val }} / @endforeach
                                @else
                                    {{ $value }}
                                @endif

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif

    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
