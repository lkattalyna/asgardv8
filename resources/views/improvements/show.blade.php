@extends('adminlte::page')
@section('content_header')
    <h1> Automatización número {{ $improvement->id }}</h1><hr>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Avance de la automatización</h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-responsive">
                            <canvas id="pieChart" height="120"></canvas>
                        </div>
                        <!-- ./chart-responsive -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <p class="text-center">
                            <strong>Resumen</strong>
                        </p>
                        <div class="progress-group">
                            Progreso total
                            <span class="float-right"><b>{{ $progress['total'] }}%</b>/100%</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success" style="width: {{ $progress['total'] }}%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Registro y aprobación
                            <span class="float-right"><b>{{ $progress['registerGen'] }}%</b>/{{ $progress['registerTot'] }}%</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-orange" style="width: {{ $progress['register'] }}%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->

                        <div class="progress-group">
                            Documentación
                            <span class="float-right"><b>{{ $progress['documentationGen'] }}%</b>/{{ $progress['documentationTot'] }}%</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning" style="width: {{ $progress['documentation'] }}%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Vista en asgard
                            <span class="float-right"><b>{{ $progress['asgardGen'] }}%</b>/{{ $progress['asgardTot'] }}%</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger" style="width: {{ $progress['asgard'] }}%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="progress-group">
                            Seguimiento
                            <span class="float-right"><b>{{ $progress['tracingGen'] }}%</b>/{{ $progress['tracingTot'] }}%</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-blue" style="width: {{ $progress['tracing'] }}%"></div>
                            </div>
                        </div>
                        <!-- /.progress-group -->
                        <div class="row justify-content-end">
                            <div class="col-md-11">
                                <div class="progress-group">
                                    Cantidad de CIs
                                    <span class="float-right"><b>{{ $progress['ciGen'] }}%</b>/{{ $progress['ciTot'] }}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-blue" style="width: {{ $progress['ci'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Desarrollo o Programación
                                    <span class="float-right"><b>{{ $progress['devGen'] }}%</b>/{{ $progress['devTot'] }}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-blue" style="width: {{ $progress['dev'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Integración
                                    <span class="float-right"><b>{{ $progress['intGen'] }}%</b>/{{ $progress['intTot'] }}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-blue" style="width: {{ $progress['int'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Pruebas superadas
                                    <span class="float-right"><b>{{ $progress['testGen'] }}%</b>/{{ $progress['testTot'] }}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-blue" style="width: {{ $progress['test'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            </div>
                        </div>

                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la automatización</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Segmento</label>
                    <p>{{ $improvement->serviceSegment->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Torre de servicio</label>
                    <p>{{ $improvement->serviceLayer->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Debe ser publicado en Asgard</label>
                    <p>@if($improvement->asgard == 0) No @else Si @endif</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <p>{{ $improvement->description }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Alcance</label>
                    <p> {{ $improvement->scope }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Objetivo</label>
                    <p> {{ $improvement->objetive }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo de automatización</label>
                    <p> {{ $improvement->aut_type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tipo de tarea</label>
                    <p> {{ $improvement->task_type }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de inicio del periodo</label>
                    <p> {{ $improvement->start_date }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de finalización del periodo</label>
                    <p> {{ $improvement->end_date }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Entregable</label>
                    <p> {{ $improvement->deliverable }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nombre del playbook o automatización</label>
                    <p> {{ $improvement->playbook_name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Frecuencia de la ejecución</label>
                    <p> {{ $improvement->frequency }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Cantidad de ejecuciones</label>
                    <p> {{ $improvement->frequency_times }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nivel que ejecuta sin automatizar</label>
                    <p> {{ $improvement->customerLevel->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tiempo antes de automatización</label>
                    <p> {{ $improvement->minutes_before }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tiempo después de automatización</label>
                    <p> {{ $improvement->minutes_after }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Tiempo optimizado</label>
                    <p> {{ $improvement->minutes_total }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Nivel que ejecutará después de automatizar</label>
                    <p> {{ $improvement->customerLevelPost->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Total de CI's a intervenir</label>
                    <p> {{ $improvement->ci_goal }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Total de CI's intervenidos actualmente</label>
                    <p> {{ $improvement->ci_progress }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Responsable de la automatización</label>
                    <p> {{ $improvement->owner->name }}</p>
                    <hr>
                </div>
                <div class="form-group">
                    <label>Fecha de registro de la automatización</label>
                    <p> {{ $improvement->created_at }}</p>
                    <hr>
                </div>
                @if($improvement->approver_id != 0)
                    <div class="form-group">
                        <label>Automatización aprobada por</label>
                        <p> {{ $improvement->approver->name }}</p>
                        <hr>
                    </div>
                @endif
                @if(!is_null($improvement->close_date))
                    <div class="form-group">
                        <label>Fecha de finalización de la automatización</label>
                        <p> {{ $improvement->close_date }}</p>
                        <hr>
                    </div>
                @endif
            </div>
        </div>
        <div class="card with-border">
            <div class="card-header">
                <h3 class="card-title">Historial de la automatización</h3>
            </div>
            <div class="card-body">
                @if($improvement->histories->count() > 0)
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Responsable</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                        </tr>
                        @foreach($improvement->histories as $history)
                            <tr>
                                <td>{{ $history->user->name }}</td>
                                <td>{{ $history->comment }}</td>
                                <td>{{ $history->created_at }}</td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p>La automatización no tiene eventos históricos aun</p>
                @endif
            </div>
        </div>
    @else
        @include('layouts.forbidden_1')
    @endcan
@stop
@section('js')
    <script>
        $(function () {

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = {
                labels: [
                    'Registro y aprobación',
                    'Documentación',
                    'Vista en asgard',
                    'Seguimiento',
                    'Pendiente'
                ],
                datasets: [
                    {
                        data: [
                            {{ $progress['registerGen'] }},
                            {{ $progress['documentationGen'] }},
                            {{ $progress['asgardGen'] }},
                            {{ $progress['tracingGen'] }},
                            {{ $progress['pending'] }}
                        ],
                        backgroundColor : ['#fd7e14', '#ffc107', '#ef3829','#005dfa','#848282'],
                    }
                ]
            }
            var pieOptions     = {
                legend: {
                    display: true
                }
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

            //-----------------
            //- END PIE CHART -
            //-----------------
        });
    </script>
@stop
