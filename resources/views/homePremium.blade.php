@extends('adminlte::page')

@section('content_header')
    <h1>Dashboard</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('plugins.Botman', true)
@section('content')
    <p>Bienvenido {{ Auth::user()->email  }}</p>
    <div class="row">
    

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <!-- /.col -->
        @isset($porcentajes)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Resumen de tareas ejecutadas por Premium</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>

                                <div class="progress-group">
                                    Exitosos
                                    <span class="float-right"><b>{{ $ejecuciones['correctas'] }}</b>/{{ $logs_premium }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: {{ $porcentajes['correctas'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                    Fallidos
                                    <span class="float-right"><b>{{ $ejecuciones['erróneas'] }}</b>/{{ $logs_premium }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: {{ $porcentajes['erróneas'] }}%"></div>
                                    </div>
                                </div>

                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Pendientes
                                    <span class="float-right"><b>{{ $ejecuciones['pendientes'] }}</b>/{{ $logs_premium }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: {{ $porcentajes['pendientes'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /card -->
            </div>
            <!-- /md-6-->
        @endisset


        @isset($porcentajes_au)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Resumen de tareas ejecutadas POR Soporte DC</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart2" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>

                                <div class="progress-group">
                                    Exitosos
                                    <span class="float-right"><b>{{ $ejecuciones_au['correctas'] }}</b>/{{ $logs_soporte }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: {{ $porcentajes_au['correctas'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                    Fallidos
                                    <span class="float-right"><b>{{ $ejecuciones_au['erróneas'] }}</b>/{{ $logs_soporte }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: {{ $porcentajes_au['erróneas'] }}%"></div>
                                    </div>
                                </div>

                                <!-- /.progress-group -->
                                <div class="progress-group">
                                    Pendientes
                                    <span class="float-right"><b>{{ $ejecuciones_au['pendientes'] }}</b>/{{ $logs_soporte }}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: {{ $porcentajes_au['pendientes'] }}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /card -->
            </div>
            <!-- /md-6-->
        @endisset
        @isset($max_logs_prem)
            <!-- TABLE: Playbooks mas ejecutados -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Playbooks más ejecutados (PREMIUM)</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Playbook</th>
                                    <th># de tareas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($max_logs_prem as $max_log)
                                        </tr>
                                            <td>{{ $max_log->playbook }}</td>
                                            <td>{{ $max_log->cantidad }}</td>
                                        </tr>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        @endisset
        @isset($max_logs_soporte)
            <!-- TABLE: Playbooks mas ejecutados -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Playbooks más ejecutados (SOPORTE DC)</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Playbook</th>
                                    <th># de tareas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($max_logs_soporte as $max_log_au)
                                        </tr>
                                            <td>{{ $max_log_au->playbook }}</td>
                                            <td>{{ $max_log_au->cantidad }}</td>
                                        </tr>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        @endisset


@stop
@section('js')
    <script>
        var botmanWidget = {
            chatServer: "/asgard/botman",
            frameEndpoint: "botman/chat",
            title: "Chat de ayuda",
            aboutText: 'Claro',
            introMessage: "✋ Hola! Soy Loki y sere tu ayudante dentro del portal de Asgard",
            placeholderText: "Enviar mensaje",
            mainColor: "#DA291C",
            bubbleBackground: "#DA291C"
        };
    </script>
    <!-- <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script> -->
    <script>
        $(function () {

             //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                    'Exitosos',
                    'Fallidos',
                    'Pendientes'
                ],
                datasets: [
                    {
                    data: [{{ $porcentajes['correctas'] }}, {{ $porcentajes['erróneas'] }}, {{ $porcentajes['pendientes'] }}],
                    backgroundColor : ['#00a65a', '#f56954', '#f39c12'],
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
                type: 'doughnut',
                data: pieData,
                options: pieOptions
                })

            //-----------------
            //- END PIE CHART -
            //-----------------
              //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')
                var pieData        = {
                    labels: [
                    'Exitosos',
                    'Fallidos',
                    'Pendientes'
                ],
                datasets: [
                    {
                    data: [{{ $porcentajes_au['correctas'] }}, {{ $porcentajes_au['erróneas'] }}, {{ $porcentajes_au['pendientes'] }}],
                    backgroundColor : ['#00a65a', '#f56954', '#f39c12'],
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
                type: 'doughnut',
                data: pieData,
                options: pieOptions
                })

            //-----------------
            //- END PIE CHART -
            //-----------------
        });
    </script>
@stop

