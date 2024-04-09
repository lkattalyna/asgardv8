@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de busqueda de reporte de check estado sistema operativo</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('windowsPH-run')
    <div class="card card-default">
        <div class="card-header with-border" style="background: #dfe1e4;">
            <h3 class="card-title">Datos de la búsqueda</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <tr>
                    <td>
                        <label for="case">{{ __('Número del cambio') }}</label>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-desktop"></i></span>
                            </div>
                            <input type="text" name="case" id="case" class="form-control input-md" value="{{ old('case') }}" maxlength="30"
                                   pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{1,}" placeholder="Número del cambio"  required>

                            <button type="button" class="btn btn-sm btn-danger" id="ejecutar">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>

                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card card-default">
        <div class="card-header with-border" style="background: #dfe1e4;">
            <h3 class="card-title">Resultado de la búsqueda</h3>
        </div>
        <div class="card-body" id="contenido">

        </div>
    </div>
@else
    @include('layouts.forbidden_1')
@endcan
@stop
@section('js')
<script>
    $(document).ready(function () {
        $('#formfield').keypress(function(e) {
            if (e.which == 13) {
                return false;
            }
        });
        var send = document.getElementById('ejecutar');
        send.addEventListener("click", function(){
            var num = $('#case').val();
            $.ajax({
                type: 'GET',
                url: '{{ route('windowsPH.getCheckSO') }}',
                dataType: 'json',
                data: {
                    'case': num,
                },
                success: function (data) {
                    $('#contenido').empty().append($(data));
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
