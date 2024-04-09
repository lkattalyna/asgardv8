@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de reportes de capacidad de cluster</h1><hr>
@stop
@section('plugins.Date-Picker', true)
@section('content')
    @can('virtualization-run')
        @include('layouts.messages')
        <form action="{{ route('virtualization.clusterCapacityReportRs') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border" style="background: #dfe1e4;">
                    <h3 class="card-title">Datos de la búsqueda</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <td>
                                <label for="fecha">{{ __('Fecha del reporte') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-calendar-day"></i></span>
                                    </div>
                                    <input type="text" name="fecha" id="fecha" class="form-control input-md" value="{{ old('fecha') }}"
                                        pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" readonly required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="report">{{ __('Seleccione el reporte') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="report" id="report" class="form-control" required>
                                        <option value="0" selected>Todos</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vcenter">{{ __('VCenter') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="vcenter" id="vcenter" class="form-control" required>
                                        <option value="0" selected>Todos</option>
                                        @foreach ($vcenters as $vcenter)
                                            <option value="{{ $vcenter->vcenter }}">{{ $vcenter->vcenter }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="segment">{{ __('Segmento') }}</label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <select name="segment" id="segment" class="form-control" required>
                                        <option value="0" selected>Todos</option>
                                        @foreach ($segments as $segment)
                                            <option value="{{ $segment->segment }}">{{ $segment->segment }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-file-alt"></i> Generar Reporte
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
        $(document).ready(function () {
            $('#fecha').datepicker({
                format: 'yyyy-mm-dd',
                startDate: "2018-01-01",
                todayBtn: "linked",
                orientation: "bottom auto",
                language: "es",
                todayHighlight: true,
                autoclose: true,
            })
            $("#fecha").change(function(){
                var fecha = $('#fecha').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('virtualization.clusterCapacityReport') }}',
                    dataType: 'json',
                    data: {
                        'fecha': fecha,
                    },
                    success: function (data) {
                        $('#report').empty();
                        var select = '<option value="0">Todos</option>'
                        for (var i=0; i<data.length;i++){
                            if(data[i] !== null){
                                select+='<option value="'+data[i].created_at+'">'+data[i].created_at+'</option>';
                            }
                        }
                        $("#report").html(select);
                    },
                    error: function (data) {
                        //console.log('error');
                        var errors = data.responseJSON;
                        if (errors) {
                            $.each(errors, function (i) {
                                console.log(errors[i]);
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
