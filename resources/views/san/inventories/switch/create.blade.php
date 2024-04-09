@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de switch</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Input-Mask', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('sanSwitch-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanSwitch.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('sanSwitch.store') }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de switch</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="fabric" class="col-sm-2 control-label">Fabric al que pertenece:</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fabric" id="fabric" style="width: 100%;" required>
                                <option></option>
                                <option value="1">Fabric 1</option>
                                <option value="2">Fabric 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre del switch:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" maxlength="50"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,50}" required  value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ip"  class="col-sm-2 control-label">IP del switch</label>
                        <div class="col-sm-10">
                            <input type="text" name="ip" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="domain" class="col-sm-2 control-label">Dominio:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="domain" name="domain" type="number"  placeholder="Si el Switch es Access Gateway escribir 0 (Cero)" min="0"
                                required  value="{{ old('domain') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serial" class="col-sm-2 control-label">Serial del switch:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="serial" name="serial" type="text" maxlength="25"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,25}" required  value="{{ old('serial') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Codigo de servicio:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="code" name="code" type="text" maxlength="20"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,20}" required  value="{{ old('code') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="maker" class="col-sm-2 control-label">Fabricante del switch:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="maker" name="maker" type="text" maxlength="20"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,20}" required  value="{{ old('maker') }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="support" class="col-sm-2 control-label">{{ __('Fecha soporte') }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="support" id="support" class="form-control input-md" value="{{ old('support') }}"
                                    pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly>
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
            $('#fabric').select2({
                placeholder: "-- Seleccione --",
                allowClear: true
            });
            $('#support').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2018-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            });
        });
    </script>
@endsection
