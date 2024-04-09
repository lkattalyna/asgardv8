@extends('adminlte::page')
@section('content_header')
    <h1> Template: {{ $awxTemplate->name }}</h1><hr>
@stop
@section('content')
    @can('awxTemplate-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('awxTemplates.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>ID del template</label>
                    <p>{{ $awxTemplate->id_template }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre del template</label>
                    <p>{{ $awxTemplate->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción del template</label>
                    <p>{{ $awxTemplate->description }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>ID del inventario</label>
                    <p>{{ $awxTemplate->id_inventory }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Playbook</label>
                    <p>{{ $awxTemplate->playbook }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Limite</label>
                    <p>{{ $awxTemplate->limite }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Preguntar variables al ejecutar</label>
                    @if($awxTemplate->ask_variables_on_launch)
                        <p><span class="fa fa-check"></span></p>
                    @else
                        <p><span class="fa fa-times"></span></p>
                    @endif
                    <hr>
                </div>
                <div class="form-group">
                    <label>Preguntar limite al ejecutar</label>
                    @if($awxTemplate->ask_limit_on_launch)
                        <p><span class="fa fa-check"></span></p>
                    @else
                        <p><span class="fa fa-times"></span></p>
                    @endif
                    <hr>
                </div>
                <div class="form-group">
                    <label>Permitir simultaneo</label>
                    @if($awxTemplate->allow_simultaneous)
                        <p><span class="fa fa-check"></span></p>
                    @else
                        <p><span class="fa fa-times"></span></p>
                    @endif
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de sincronización</label>
                    <p> {{ $awxTemplate->created_at }}</p>
                    <hr>
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    @include('layouts.justDelete')
@stop
