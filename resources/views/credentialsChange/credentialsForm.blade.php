@extends('adminlte::page')
@section('content_header')
    <h1>Cambio credenciales a servidores</h1><hr>
@stop
@php
    use Illuminate\Support\Facades\Auth;
    $names = Auth::user()->name;
    $user = Auth::user()->username;
@endphp
@section('plugins.Datatables', true)
@section('plugins.Select2', true)
@section('plugins.Sweetalert2', true)
@section('content')
    @can('recursos-run')
        @include('layouts.formError')
        @include('layouts.messages')
        @include('layouts.tableFull')
        <form action="" method="post" id="formfield">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Cambio credenciales a servidores</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="name" class="text-md-right">Encargado</label>
                            </th>
                            <td>
                                <label>{!! $user !!} / {!! $names !!}</label>
                            </td>
                        </tr>
							<th>
                                <label>Credenciales de autenticación al enclosure</label>
                            </th>
						<tr>
						</tr>
						<tr>
                            <th>
                                <label for="userEnclosure" class="text-md-right">Usuario acceso</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clipboard-list"></i></span>
                                    </div>
                                    <input name="userEnclosure" id="userEnclosure" class="form-control" placeholder="Usuario...">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="passEnclosure" class="text-md-right">Contraseña acceso</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clipboard-list"></i></span>
                                    </div>
                                    <input type="password" name="passEnclosure" id="passEnclosure" class="form-control" placeholder="Contraseña...">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="ipDestino" class="text-md-right">Direcciones IP Enclosure</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clipboard-list"></i></span>
                                    </div>
                                    <input name="ipDestino" id="ipDestino" class="form-control" placeholder="IP...">
                                </div>
                            </td>
                        </tr>
						</tr>
							<th>
                                <label>Cambio de credenciales a usuario</label>
                            </th>
						<tr>
                        <tr>
                            <th>
                                <label for="userServer" class="text-md-right">Usuario</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clipboard-list"></i></span>
                                    </div>
                                    <input name="userServer" id="userServer" class="form-control" placeholder="Usuario...">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="newPass" class="text-md-right">Nueva contraseña</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clipboard-list"></i></span>
                                    </div>
                                    <input type="password" name="newPass" id="newPass" class="form-control" placeholder="Nueva contraseña...">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-sm btn-danger" id="sendForm">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('css')
    <style>
    </style>
@stop
@section('js')
    @include('layouts.tableFull')
    <script>
        $(document).ready(function() {
            $('#formfield').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });
            $('#sendForm').on('click', function(){
                swal({
                    title: "¿Esta seguro?",
                    text: "¿Seguro de realizar el cambio de credenciales con los datos proporcionados?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "Confirmar"],
                }).then((seguro) => {
                    if (seguro) {
                        if($('#formfield')[0].checkValidity()){
                            $('#formfield').submit();
                        }else{
                            $('#formfield')[0].reportValidity();
                        }
                    }
                });
            });
        });
    </script>
@stop
