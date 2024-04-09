@extends('adminlte::page')
@section('content_header')
    <h1> Formulario de creación de usuarios</h1><hr>
@stop
@section('content')
    @can('user-create')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('users.index')}}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.formError')
        <form action="{{route('users.store') }}" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Formulario de creación de usuarios</h3>
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
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="Nombre Completo" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email" class="text-md-right">Email</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="Ej: example@example.com" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="password" class="text-md-right">Password</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="password_confirmation"
                                    class="text-md-right">Confirmar el password</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmar el password" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-].{2,}" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="roles" class="text-center">{{ __('Nivel de usuario') }}</label>
                            </th>
                            <td>
                                @can('user-admin')
                                    <select class="form-control" name="roles" id="roles" required>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol['id'] }}">{{ $rol['name'] }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="form-control" name="roles" id="roles" required>
                                        @foreach($roles as $rol)
                                            <option value="{{ $rol['id'] }}">{{ $rol['name'] }}</option>
                                        @endforeach
                                    </select>
                                @endcan
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

