@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de consulta WWN/NAA Discos</h1><hr>
@stop
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('san-run')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                </div>
            </div>
        </div>
        @include('layouts.formError')
        @include('layouts.messages')
        <form action="{{ route('san.wwnNaaStore') }}" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de consulta de estados de puerto</h3>
                </div>
                <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr>
                        <td>
                            <label for="storage">{{ __('Datastorage VM') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <select name="storage" id="storage" class="form-control" style="width: 100%">
                                    <option></option>
                                    @foreach ($datastorages as $datastorage)
                                        <option value="{{ $datastorage->naa }}">{{ $datastorage->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="wwn">{{ __('WWN/NAA') }}</label>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text" name="wwn" id="wwn" class="form-control input-md" placeholder="WWN/NAA que desea buscar"
                                pattern="^([0-9a-fA-F]{30,50})$" value="{{ old('wwn') }}" required>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                    <i class="fa fa-terminal"></i> Ejecutar
                </button>
            </div>
        </div>
    </form>
    @include('layouts.wait_modal')
@else
    @include('layouts.forbidden_1')
@endcan
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#storage').select2({
                placeholder: "--Seleccione--",
                allowClear: true
            });
            $('#storage').on('change', function(){
                var naa = $(this).val();
                $('#wwn').val(naa);
            });
            $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });
            $('#sendForm').on('click', function(){
                swal({
                    title: "¿Esta seguro?",
                    text: "Esta completamente seguro de ejecutar la tarea con los parametros seleccionados",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "Si, estoy seguro"],
                }).then((seguro) => {
                    if (seguro) {
                        if($('#formfield')[0].checkValidity()){
                            $('#formfield').submit();
                            $('#cargando').modal('show');
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
        });
    </script>
@stop


