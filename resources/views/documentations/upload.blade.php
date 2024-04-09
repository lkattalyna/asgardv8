@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de cargue de manual de usuario</h1><hr>
@stop
@section('plugins.Select2', true)
@section('content')
    @can('documentation-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('documentations.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('documentations.upload', $documentation->id) }}" method="post" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de cargue de manual de usuario</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label class="text-md-right">Id de la automatización</label>
                            </th>
                            <td>
                                {{ $documentation->regImprovement->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label class="text-md-right">Nombre de la automatización</label>
                            </th>
                            <td>
                                {{ $documentation->regImprovement->playbook_name }}
                            </td>
                        </tr>
                        @if($documentation->user_manual_link != 'N/A')
                            <tr>
                                <th>
                                    <label class="text-md-right">Manual de usuario cargado</label>
                                </th>
                                <td>
                                    <a href="{{ route('documentations.userFile',$documentation->user_manual_link) }}" title="Ver documento" target="_blank">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th>
                                <label for="docFile" class="text-md-right">Agregar archivo</label>
                            </th>
                            <td>
                                <input id="docFile" name="docFile" type="file" class="form-control" accept="application/pdf">
                            </td>
                        </tr>
                    </table>
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
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
    </script>
@endsection

