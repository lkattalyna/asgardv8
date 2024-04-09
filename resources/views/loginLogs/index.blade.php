@extends('adminlte::page')
@section('content_header')
    <h1> Logs de inicio de sesión</h1><hr>
@stop
@section('plugins.Date-Picker', true)
@section('plugins.Select2', true)
@section('content')
    @can('loginLog-list')
        @include('layouts.formError')
        <form action="{{ route('loginLogs.showLogs') }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos de la busqueda</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="usuario">{{ __('Usuarios') }}</label>
                            </td>
                            <td>
                                <div>
                                    <select class="form-control" name="usuario" id="usuario" required>
                                        <option value="all" selected>Todos</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->username }}">{{ $user->username }}</option>    
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="tipo">{{ __('Fechas inicial') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="text" name="f_ini" id="f_ini" class="form-control input-md" value="{{ old('f_ini') }}"
                                        pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="tipo">{{ __('Fechas final') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="text" name="f_fin" id="f_fin" class="form-control input-md" value="{{ old('f_fin') }}"
                                        pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-clipboard-check"></i> Generar reporte
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
            $('#usuario').select2();
        });
        $('#f_ini').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2018-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
        })
        $('#f_fin').datepicker({
            format: 'yyyy-mm-dd',
            startDate: "2018-01-01",
            todayBtn: "linked",
            orientation: "bottom auto",
            language: "es",
            todayHighlight: true,
            autoclose: true,
        })
    </script>
@stop
