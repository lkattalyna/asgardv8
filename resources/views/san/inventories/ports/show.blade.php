@extends('adminlte::page')
@section('content_header')
    <h1> Slot {{ $sanPort->slot }} Puerto {{ $sanPort->port }}</h1><hr>
@stop
@section('content')
    @can('sanPort-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanPorts.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos del puerto</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Switch al que pertenece</label>
                            <p>{{ $sanPort->getSwitch->sw }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Nombre del puerto</label>
                            <p>{{ $sanPort->name }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Slot</label>
                            <p>{{ $sanPort->slot }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Puerto</label>
                            <p> {{ $sanPort->port }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Estado</label>
                            <p> {{ $sanPort->status }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Servicio</label>
                            <p> {{ $sanPort->service }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>IM</label>
                            <p> {{ $sanPort->im }}</p>
                            <hr>
                        </div>

                        <div class="form-group">
                            <label>Observación</label>
                            <p> {{ $sanPort->comment }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Creado el</label>
                            <p> {{ $sanPort->created_at }}</p>
                            <hr>
                        </div>
                        <div class="form-group">
                            <label>Actualizado el</label>
                            <p> {{ $sanPort->updated_at }}</p>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Datos del puerto online</h3>
                    </div>
                    <div class="card-body">
                        @if(is_array($console))
                            @foreach ($console as $line)
                                {{ $line }}<br>
                            @endforeach
                        @else
                            {{ $console }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
