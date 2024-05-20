@extends('adminlte::page')

@section('content_header')
    <h1>Formulario de Segregación de Cliente por Diccionario</h1>
    <hr>
@stop

@section('plugins.Datatables', true)

@section('content')
    <div class="card card-default">
        <div class="card-body">
            <div class="float-sm-right">
                <a class="btn btn-sm btn-danger" href="{{ route('customer.index') }}">
                    <i class="fa fa-reply"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.formError')
    <div class="card card-default">
        <div class="card-body">
            <form id="formulario_cluster" method="POST"
                action="{{ route('customer.saveClusters', ['customerID' => $customerID]) }}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                {{ csrf_field() }}

                <div class="card card-default">
                    <div class="card-header with-border">
                        <p>Este formulario permitirá realizar la segregación por Cluster</p>
                    </div>
                    <div class="card-body" style="width: 25%;">
                        <td>
                            <label for="clusterAgregado" class="col-form-label">{{ _('CLUSTER AGREGADOS') }}</label>
                        </td>
                        <div id="cluster-container">
                            @if ($customerClusters === null || $customerClusters->isEmpty() || count($customerClusters) == 0)
                                <p>No se han agregado clusters</p>
                            @else
                                <!-- Clústeres agregados dinámicamente -->
                                @foreach ($customerClusters as $cluster)
                                    <div class="input-group">
                                        <input type="hidden" name="cluster_agregados[][id]"
                                            value="{{ $cluster->fk_clusterID }}" />
                                        <input class="form-control" name="cluster_agregados[][visible]"
                                            id="{{ $cluster->fk_clusterID }}"
                                            value="{{ $cluster->clusterData->clusterName }}" disabled>
                                        <button class="btn btn-sm btn-danger ml-2"
                                            onclick="eliminarCluster('{{ $cluster->fk_clusterID }}')">Eliminar</button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- Botón de guardar -->
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
