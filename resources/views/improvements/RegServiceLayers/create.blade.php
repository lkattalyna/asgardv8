@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de capas de servicio</h1><hr>
@stop
@section('plugins.Select2', true)
@section('content')
    @can('regServiceLayer-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('RegServiceLayers.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('RegServiceLayers.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de capas de servicio</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre de la capa:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" required  value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="segment" class="col-sm-2 control-label">Segmento al que pertenece:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="segment" id="segment" style="width: 100%;" required>
                                <option></option>
                                @foreach($segments as $segment)
                                    <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="model" class="col-sm-2 control-label">Modelo de negocio:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="model" id="model" style="width: 100%;" required>
                                <option></option>
                                <option value="IaaS">IaaS</option>
                                <option value="PaaS">PaaS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="leader" class="col-sm-2 control-label">Lider de la capa:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="leader" id="leader" style="width: 100%;" required>
                                <option></option>
                                <option value="0">No Disponible</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="coordinator" class="col-sm-2 control-label">Coordinador de la capa:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="coordinator" id="coordinator" style="width: 100%;" required>
                                <option></option>
                                <option value="0">No Disponible</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#segment').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#model').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
        });
    </script>
@endsection
