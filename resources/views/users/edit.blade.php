@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de edición de usuarios</h1><hr>
@stop
@section('content')
    @can('user-edit')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('users.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{ route('users.update',$user->id) }} " method="post">
            {!! csrf_field() !!}
            @method('PUT')
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de edición de usuarios</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="name" class="text-md-right">Nombre completo</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}"
                                        placeholder="Nombre Completo" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required>
                                </div>
                            </td>
                        </tr>
                        @can('user-admin')
                            <tr>
                                <th>
                                    <label for="activate" class="text-center">{{ __('Usuario habilitado') }}</label>
                                </th>
                                <td>
                                    <select class="form-control" name="activate" id="activate" required>
                                        <option value="0" @if($user->active == 0) selected @endif >No</option>
                                        <option value="1" @if($user->active == 1) selected @endif >Si</option>
                                    </select>
                                </td>
                            </tr>
                        @endcan
                        @can('user-admin')
                            <tr>
                                <th>
                                    <label for="dev" class="text-center">{{ __('Usuario es desarrollador') }}</label>
                                </th>
                                <td>
                                    <select class="form-control" name="dev" id="dev" required>
                                        <option value="0" @if($user->developer == 0) selected @endif >No</option>
                                        <option value="1" @if($user->developer == 1) selected @endif >Si</option>
                                    </select>
                                </td>
                            </tr>
                        @endcan
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

