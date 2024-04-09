@extends('adminlte::page')
@section('content_header')
    <h1> Consultar mis requerimientos</h1><hr>
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
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Requerimientos registradas en el sistema</h3>
            </div>
            <!-- /.card-body -->
            <div class="card-body">
                <!-- /.table-responsive -->
                <table id="example1" class="table table-striped table-bordered" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Solicitante</th>
                            <th>Fecha de creación</th>
                            <th>Estado</th>
                            <th>Documentado</th>
                            <th>Fecha de cierre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reqs as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->customer->name }}</td>
                                <td>{{ $req->created_at }}</td>
                                <td>{{ $req->state->name }}</td>
                                <td>
                                    @if($req->improvement_id == 0)
                                        <span class="badge badge-success right">N/A</span>
                                    @else
                                        @if($req->improvement->documentation)
                                            @if($req->improvement->documentation->approval_status == 1)
                                                <span class="badge badge-success right">SI</span>
                                            @else
                                                <span class="badge badge-danger right">No</span>
                                            @endif
                                        @else
                                        <span class="badge badge-danger right">No</span>
                                        @endif
                                    @endif

                                </td>
                                <td>{{ $req->solved_at }}</td>
                                <td class="center">
                                    @can('devRequest-show')
                                        <a href="{{route('devRequests.show',$req->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @if($req->total_time == null && $req->client_id == \Illuminate\Support\Facades\Auth::user()->id)
                                        <a href="{{route('devRequestFields.index',$req->id)}}" title="Editar Campos">
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
        @include('layouts.del_modal')
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.tableFull')
@stop
