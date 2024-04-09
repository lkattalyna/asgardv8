@extends('adminlte::page')
@section('content_header')
    <h1> Consultar requerimientos</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('devRequest-list')
        <div class="card card-default">
            <div class="card-body">
                @can('devRequest-create')
                    <a href="{{ route('devRequests.create') }}" class="btn btn-sm btn-danger">
                        <span class="fa fa-plus fa-1x"></span>&nbsp Nuevo Requerimiento
                    </a>
                @endcan
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        @php
            $pos = strpos(\Illuminate\Support\Facades\Auth::user()->group,'GRP-ASG-Admin-Master');
        @endphp
        {{-- @if(isset($toDoReqs) && \Illuminate\Support\Facades\Auth::user()->group == 'GRP-ASG-Admin-Master') --}}
        @if(isset($toDoReqs) && $pos !== false)
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title">Requerimientos pendientes de asignación</h3>
                </div>
                <!-- /.card-body -->
                <div class="card-body">
                    <!-- /.table-responsive -->
                    <table id="example2" class="table table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Solicitante</th>
                                <th>Automatización</th>
                                <th>Tarea</th>
                                <th>Fecha de creación</th>
                                <th>Fecha aproximada de solución</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($toDoReqs as $toDoReq)
                                <tr>
                                    <td>{{ $toDoReq->id }}</td>
                                    <td>{{ $toDoReq->customer->name }}</td>
                                    @if($toDoReq->improvement_id != 0)
                                        <td>{{ $toDoReq->improvement->playbook_name }}</td>
                                    @else
                                        <td>N/A</td>
                                    @endif
                                    <td>{{ $toDoReq->task->name }}</td>
                                    <td>{{ $toDoReq->created_at }}</td>
                                    <td>{{ $toDoReq->expiration_date }}</td>
                                    <td class="center">
                                        <a href="{{route('devRequests.show',$toDoReq->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                        <a href="{{route('devRequests.assign',$toDoReq->id)}}" title="Asignar">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-share-square" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @endif
        @isset($assignReqs)
            <div class="card">
                <!-- /.card-header -->
                <div class="card-header">
                    <h3 class="card-title">Requerimientos asignados a mi usuario</h3>
                </div>
                <!-- /.card-body -->
                <div class="card-body">
                    <!-- /.table-responsive -->
                    <table id="example1" class="table table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Solicitante</th>
                            <th>Automatización</th>
                            <th>Tarea</th>
                            <th>Estado</th>
                            <th>Fecha aproximada de solución</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assignReqs as $assignReq)
                            <tr>
                                <td>{{ $assignReq->id }}</td>
                                <td>{{ $assignReq->customer->name }}</td>
                                @if($assignReq->improvement_id != 0)
                                    <td>{{ $assignReq->improvement->playbook_name }}</td>
                                @else
                                    <td>N/A</td>
                                @endif
                                <td>{{ $assignReq->task->name }}</td>
                                <td>{{ $assignReq->state->name }}</td>
                                <td>{{ $assignReq->expiration_date }}</td>
                                <td class="center">
                                    <a href="{{route('devRequests.show',$assignReq->id)}}" title="Ver">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-eye" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                    @if($assignReq->improvement_id != 0)
                                        <a href="{{route('improvements.show',$assignReq->improvement_id)}}" title="Ver automatización">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #47e50d"></i>
                                            </button>
                                        </a>
                                    @endif
                                    @if($assignReq->state_id <= 5)
                                        <a href="{{route('devRequests.change',$assignReq->id)}}" title="Cambiar estado">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-edit" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <input type="hidden" name="order" id="order" value="desc">
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        @endisset
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
