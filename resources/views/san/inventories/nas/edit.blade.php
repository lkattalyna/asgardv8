@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de NAS</h1><hr>
@stop
@section('plugins.Input-Mask', true)
@section('plugins.Date-Picker', true)
@section('content')
    @can('sanNas-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('sanNas.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('sanNas.update', $sanNas->id) }}" method="POST" class="form-horizontal">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de NAS</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nombre de la NAS:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="name" name="name" type="text" maxlength="40"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,40}" required  value="{{ $sanNas->name }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mark" class="col-sm-2 control-label">Marca de la NAS:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="mark" name="mark" type="text" maxlength="20"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,20}" required  value="{{ $sanNas->trademark }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="model" class="col-sm-2 control-label">Modelo de la NAS:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="model" name="model" type="text" maxlength="35"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,35}" required  value="{{ $sanNas->model }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="serial" class="col-sm-2 control-label">Serial de la NAS:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="serial" name="serial" type="text" maxlength="25"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,25}" required  value="{{ $sanNas->serial }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-2 control-label">Codigo de servicio:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="code" name="code" type="text" maxlength="20"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,20}" required  value="{{ $sanNas->code }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location" class="col-sm-2 control-label">Ubicación:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="location" name="location" type="text" maxlength="30"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,30}" required  value="{{ $sanNas->location }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ip"  class="col-sm-2 control-label">IP principal de la NAS:</label>
                        <div class="col-sm-10">
                            <input type="text" name="ip" class="form-control" data-inputmask="'alias': 'ip'" data-mask="" im-insert="true"  value="{{ $sanNas->main_ip }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="other" class="col-sm-2 control-label">Ip's segundarias de la NAS:</label>
                        <div class="col-sm-10">
                            <input class="form-control" id="other" name="other" type="text" maxlength="64"
                                pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,64}" required value="{{ $sanNas->others_ip }}"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="support" class="col-sm-2 control-label">{{ __('Fecha soporte') }}</label>
                        <div class="col-sm-10">
                            <input type="text" name="support" id="support" class="form-control input-md" value="{{ $sanNas->support_date }}"
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
