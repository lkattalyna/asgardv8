@extends('adminlte::page')
@section('content_header')
    <h1> Consultar documentaciones de automatizaciones</h1><hr>
@stop
@section('plugins.Datatables', true)
@section('content')
    @can('documentation-list')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right" id="btn_table"></div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="card">
            <!-- /.card-header -->
            <div class="card-header">
                <h3 class="card-title">Consultar documentaciones de automatizaciones</h3>
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
                            <th>Fecha de creación</th>
                            <th>Estado de documentación</th>
                            <th>Estado de aprobación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docs as $doc)
                            <tr>
                                <td>{{ $doc->id }}</td>
                                <td>{{ $doc->owner->name }}</td>
                                <td>{{ $doc->regImprovement->playbook_name }}</td>
                                <td>{{ $doc->created_at }}</td>
                                <td>
                                    @if($doc->tech_manual && $doc->tech_manual_link != 'N/A')
                                        <span class="badge badge-success right">Completado</span>
                                    @elseif(!$doc->tech_manual)
                                        <span class="badge badge-success right">Completado</span>
                                    @elseif($doc->tech_manual && $doc->tech_manual_link == 'N/A')
                                        <span class="badge badge-warning right">Pendiente subir documento</span>
                                    @endif
                                </td>
                                <td>
                                    @if($doc->approval_status == 1)
                                        <span class="badge badge-success right">Aprobado</span>
                                    @else
                                        <span class="badge badge-danger right">Pendiente de aprobación</span>
                                    @endif
                                </td>
                                <td class="center">
                                    @can('documentation-show')
                                        <a href="{{route('documentations.show',$doc->id)}}" title="Ver">
                                            <button class="btn btn-sm btn-default">
                                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                                            </button>
                                        </a>
                                    @endcan
                                    @can('documentation-edit')
                                        @if($doc->owner_id == \Illuminate\Support\Facades\Auth::user()->id && $doc->approval_status == 0)
                                            <a href="{{route('documentations.edit',$doc->id)}}" title="Editar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @elseif(Illuminate\Support\Facades\Auth::user()->id == $doc->regImprovement->serviceLayer->leader_id ||
                                            \Illuminate\Support\Facades\Auth::user()->id == $doc->regImprovement->serviceLayer->coordinator_id)
                                                <a href="{{route('documentations.edit',$doc->id)}}" title="Editar">
                                                    <button class="btn btn-sm btn-default">
                                                        <i class="fa fa-edit" style="color: #0d6aad"></i>
                                                    </button>
                                                </a>
                                        @endif
                                        @if($doc->owner_id == \Illuminate\Support\Facades\Auth::user()->id ||
                                            Illuminate\Support\Facades\Auth::user()->id == $doc->regImprovement->serviceLayer->leader_id ||
                                            \Illuminate\Support\Facades\Auth::user()->id == $doc->regImprovement->serviceLayer->coordinator_id)
                                                <a href="{{route('documentations.uploadForm',$doc->id)}}" title="Agregar Manual de usuario">
                                                    <button class="btn btn-sm btn-default">
                                                        <i class="fa fa-book" style="color: #0d6aad"></i>
                                                    </button>
                                                </a>
                                        @endif
                                    @endcan
                                    @if(($doc->approval_status == 0) && (\Illuminate\Support\Facades\Auth::user()->id == $doc->regImprovement->serviceLayer->leader_id ||
                                            \Illuminate\Support\Facades\Auth::user()->id == $doc->regImprovement->serviceLayer->coordinator_id))
                                        @if($doc->tech_manual == 1 && $doc->tech_manual_link != 'N/A')
                                            <a href="{{route('documentations.approval',$doc->id)}}" title="Aprobar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-check" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @elseif($doc->tech_manual == 0)
                                            <a href="{{route('documentations.approval',$doc->id)}}" title="Aprobar">
                                                <button class="btn btn-sm btn-default">
                                                    <i class="fa fa-check" style="color: #0d6aad"></i>
                                                </button>
                                            </a>
                                        @endif
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
