@extends('adminlte::page')
@section('content_header')
    <h1> Seguimiento del progreso de la automatización número {{ $improvement->id }}</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('content')
    @can('regImprovement-show')
        <div class="card card-default">
            <div class="card-body">
                <div class="float-sm-right">
                    <a class="btn btn-sm btn-danger" href="{{ route('improvements.index') }}">
                        <i class="fa fa-reply"></i> Volver
                    </a>
                </div>
            </div>
        </div>
        <div class="card with-border">
            <div class="card-body">
                <div class="timeline timeline-inverse">
                    @if($improvement->histories->count() > 0)
                        <!-- timeline time label -->
                        <div class="time-label">
                            <span class="bg-danger">
                              {{ $improvement->created_at }}
                            </span>
                        </div>
                        <!-- /.timeline-label -->
                        @foreach($improvement->histories as $history)
                            <!-- timeline item -->
                            <div>
                                @switch($history->type)
                                    @case('dev')
                                        <i class="fas fa-file-invoice bg-danger"></i>
                                    @break
                                    @case('register')
                                        <i class="fas fa-pencil-alt bg-info"></i>
                                    @break
                                    @case('documentation')
                                        <i class="fas fa-book bg-warning"></i>
                                    @break
                                    @case('progress')
                                        <i class="fas fa-tasks bg-blue"></i>
                                    @break
                                @endswitch

                                    <div class="timeline-item">
                                        <span class="time"><i class="far fa-clock"></i>{{ $history->created_at }}</span>
                                        <h3 class="timeline-header">{{ $history->user->name }}</h3>
                                        <div class="timeline-body">
                                            {{ $history->comment }}
                                        </div>
                                        @if($history->evidence != 'N/A')
                                            <div class="timeline-footer">
                                                <a href="#" title="Ver documento" target="_blank">
                                                    <button class="btn btn-sm btn-default">
                                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                            </div>
                        @endforeach
                        <!-- END timeline item -->
                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    @else
                        <p>La automatización no tiene eventos históricos aun</p>
                    @endif
                </div>
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
