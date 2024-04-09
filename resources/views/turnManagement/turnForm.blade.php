@extends('adminlte::page')
@section('content_header')
    <h1> Entrega de Turnos</h1><hr>
@stop
@php
    use Illuminate\Support\Facades\Auth;
    $names = Auth::user()->name;
@endphp
@section('plugins.Datatables', true)
@section('content')
    @can('administration-menu')
        @include('layouts.formError')
        @include('layouts.messages')
        @include('layouts.tableFull')
        <form action="" method="post">
            {!! csrf_field() !!}
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Entrega de turnos</h3>
                </div>
                <div class="card-body">
                    <div>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>
                                <label for="name" class="text-md-right">Nombre</label>
                            </th>
                            <td>
                                <label>{!! $names !!}</label>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="turn" class="text-md-right">Turno</label>
                            </th>
                            <td>
                                <div class="input-group" style="display: true">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-address-book"></i></span>
                                    </div>
                                    <select class="form-control" name="turn" id="turn" required>
                                            <option value="">Seleccione turno...</option>
                                            <option value=1>1 (6:14)</option>
                                            <option value=2>2 (14:22)</option>
                                            <option value=3>3 (22:06)</option>
                                            <option value=4>4 (7:17)</option>
                                            <option value=5>5 (6:18)</option>
                                            <option value=6>6 (18:06)</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="group" class="text-md-right">Área de gestión</label>
                            </th>
                            <td>
                                <div class="input-group" style="display: true">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-layer-group"></i></span>
                                    </div>
                                    <select class="form-control" name="group" id="group" required>
                                            <option value="">Seleccione área de gestión...</option>
                                            <option value="test">TEST</option>
                                            <option value="lider">Líder técnico administrativo</option>
                                            <option value="compensar">Datacenter - CEAC Compensar</option>
                                            <option value="gestionOpDel">Datacenter - Gestion de Operaciones Delegadas</option>
                                            <option value="titan">Proyecto Titán</option>
                                            <option value="ireIaas">Datacenter - IRE IaaS</option>
                                            <option value="ireIaasUnix">Datacenter - IRE PaaS Unix</option>
                                            <option value="ireIaasWin">Datacenter - IRE PaaS Windows</option>
                                            <option value="premium">Premium</option>
                                            <option value="notificacion">Notificación</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="observations" class="text-md-right">Observaciones</label>
                            </th>
                            <td>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-clipboard-list"></i></span>
                                    </div>
                                    <input type="textarea" name="observations" id="observations" class="form-control" placeholder="Observaciones...">
                                </div>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <div>
                    <table class="table table-bordered" id="suspendedCases">
                        <tr>
                            <h5>CASOS SUSPENDIDOS</h5>
                        </tr>
                        <tr>
                            <th>Caso</th>
                            <th>Razón</th>
							<th>Levantamiento</th>
							<th>Acción</th>
                        </tr>
                        <tr>
                            <td><input type="text" name="masSuspC[0]" placeholder="Caso" class="form-control" /></td>
                            <td><input type="text" name="masSuspR[0]" placeholder="Razón" class="form-control" /></td>
                            <td><input type="text" name="masSuspL[0]" placeholder="Levantamiento" class="form-control" /></td>
                            <td><button type="button" name="mas-susp" id="mas-susp" class="btn btn-success">Agregar</button></td>
                        </tr>
                    </table>
                    </div>
                    <div>
                        <table class="table table-bordered" id="pendingCases">
                            <tr>
                                <h5>CASOS PENDIENTES</h5>
                            </tr>
                            <tr>
                                <th>Caso</th>
                                <th>Razón</th>
                                <th>Acción</th>
                            </tr>
                            <tr>
                                <td><input type="text" name="masPendC[0]" placeholder="Caso" class="form-control" /></td>
                                <td><input type="text" name="masPendR[0]" placeholder="Razón" class="form-control"/></td>
                                <td><button type="button" name="mas-pend" id="mas-pend" class="btn btn-success">Agregar</button></td>
                            </tr>
                        </table>
                        </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-sm btn-danger" name="send" value="Send">
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Historial entregas</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Administrador</th>
                            <th>Turno</th>
                            <th>Observaciones</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ( $turnos as $turno )
                            <tr>
                                <td>{{ $turno->id }}</td>
                                <td>{{ $turno->name }}</td>
                                <td>{{ $turno->turn }}</td>
                                <td>{{ $turno->observations }}</td>
                                <td>{{ $turno->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
			<div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title">Historial de casos</h3>
                </div>
                <div class="card-body">
                    <table id="example2" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>Administrador</th>
							<th>Turno</th>
                            <th>Tipo</th>
                            <th>Caso</th>
                            <th>Razón</th>
							<th>Levantamiento</th>
							<th>Fecha</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ( $casos as $caso )
                            <tr>
                                <td>{{ $caso->name }}</td>
								<td>{{ $caso->turn }}</td>
                                <td>{{ $caso->type }}</td>
                                <td>{{ $caso->case}}</td>
								<td>{{ $caso->reason }}</td>
								<td>{{ $caso->dates }}</td>
                                <td>{{ $caso->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('css')
    <style>
        .ocultar{
        display:none;
    }
    </style>
@stop
@section('js')
    @include('layouts.tableFull')
    <script>
        function showSusp(){
            let suspCaso = document.getElementById('susp-caso');
            let suspRazon = document.getElementById('susp-razon');
            let suspLev = document.getElementById('susp-lev');
            if(suspCaso.classList.contains('ocultar')){
                suspCaso.classList.remove('ocultar');
            }else{
                suspCaso.classList.add('ocultar');
            }
            if(suspRazon.classList.contains('ocultar')){
                suspRazon.classList.remove('ocultar');
            }else{
                suspRazon.classList.add('ocultar');
            }
            if(suspLev.classList.contains('ocultar')){
                suspLev.classList.remove('ocultar');
            }else{
                suspLev.classList.add('ocultar');
            }
        }

        function showPend(){
            let pendCaso = document.getElementById('pend-caso');
            let pendRazon = document.getElementById('pend-razon');
            if(pendCaso.classList.contains('ocultar')){
                pendCaso.classList.remove('ocultar');
            }else{
                pendCaso.classList.add('ocultar');
            }
            if(pendRazon.classList.contains('ocultar')){
                pendRazon.classList.remove('ocultar');
            }else{
                pendRazon.classList.add('ocultar');
            }
        }

        var j = 0;
        $("#mas-susp").click(function(){
        ++j;
        $("#suspendedCases").append('<tr><td><input type="text" name="masSuspC['+j+']" placeholder="Caso" class="form-control" /></td><td><input type="text" name="masSuspR['+j+']" placeholder="Razón" class="form-control" /></td><td><input type="text" name="masSuspL['+j+']" placeholder="Levantamiento" class="form-control" /></td><td><button type="button" class="btn btn-danger menosSusp-tr">Eliminar</button></td></tr>');
        });
        $(document).on('click', '.menosSusp-tr', function(){
        $(this).parents('tr').remove();
        });

        var i = 0;
        $("#mas-pend").click(function(){
        ++i;
        $("#pendingCases").append('<tr><td><input type="text" name="masPendC['+i+']" placeholder="Caso" class="form-control" /></td><td><input type="text" name="masPendR['+i+']" placeholder="Razón" class="form-control"/></td><td><button type="button" class="btn btn-danger menosPend-tr">Eliminar</button></td></tr>');
        });
        $(document).on('click', '.menosPend-tr', function(){
        $(this).parents('tr').remove();
        });
    </script>
@stop
