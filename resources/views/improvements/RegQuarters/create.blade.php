@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de periodos</h1><hr>
@stop
@section('plugins.Date-Picker', true)
@section('content')
    @can('regQuarter-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('RegQuarters.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('RegQuarters.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de periodos</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del periodo:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" required  value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="start" class="col-sm-2 control-label">Fecha de inicio del periodo:</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="text" name="start" id="start" class="form-control input-md" value="{{ old('start') }}"
                                   pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="end" class="col-sm-2 control-label">Fecha de finalización del periodo:</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                </div>
                                <input type="text" name="end" id="end" class="form-control input-md" value="{{ old('end') }}"
                                       pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                            </div>
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
        $('#start').datepicker({
            format: 'yyyy-mm-dd',
            startDate: "2020-01-01",
            todayBtn: "linked",
            orientation: "bottom auto",
            language: "es",
            todayHighlight: true,
            autoclose: true,
        })
        $('#end').datepicker({
            format: 'yyyy-mm-dd',
            startDate: "2020-01-01",
            todayBtn: "linked",
            orientation: "bottom auto",
            language: "es",
            todayHighlight: true,
            autoclose: true,
        })
    </script>
@endsection
