@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de registro de avances de automatizaciones</h1><hr>
@stop
@section('content')
    @can('regImprovement-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('improvements.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @if($progress['tracing'] < 100)
            @include('layouts.messages')
            @include('layouts.formError')
            <form action="{{route('improvements.progressUpdate',$improvement->id) }}" method="post">
                {!! csrf_field() !!}
                <div class="card card-default">
                    <div class="card-header with-border">
                        <p>Formulario de registro de avances de automatizaciones</p>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th>
                                    <label for="segment" class="text-center">Seleccione el servicio</label>
                                </th>
                                <td>
                                    <select class="form-control" name="service" id="service" style="width: 100%;"  required>
                                        <option selected disabled>-- Seleccione --</option>
                                        @if($progress['ci'] < 100)<option value="1">Cantidad de CIs</option>@endif
                                        @if($progress['dev'] < 100)<option value="2">Desarrollo o Programación</option>@endif
                                        @if($progress['int'] < 100)<option value="3">Integración</option>@endif
                                        @if($progress['test'] < 100)<option value="4">Pruebas superadas</option>@endif
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card card-default">
                    <div class="card-body" id="serviceForm">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        @endif
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(document).ready(function(){
            $("#service").change(function(){
                var service = $(this).val()
                $.get('progress/'+service, function(data){
                    //esta el la peticion get, la cual se divide en tres partes. ruta,variables y funcion
                    $("#serviceForm").html(data);
                });
            });
        });
    </script>
@endsection

