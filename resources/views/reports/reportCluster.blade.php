
@extends('adminlte::page')
@section('content_header')
    <h1>Dashboard</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('contentPanel')
    <p>Bienvenido {{ Auth::user()->email  }}  <span class="float-right">Fecha última actualización: {{$UpdateDate[0]->fecha}}</span></p>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Total Cluster</span>
                                <span class="info-box-number">{{ $totalCluster }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-memory"></i></span>
              
                <div class="info-box-content">
                                <span class="info-box-text">Total Memoria</span>
                                <span class="info-box-number">{{ number_format($TotRecursos[0]->TotMemRam, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-microchip"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Total Cpu</span>
                                <span class="info-box-number">{{ number_format($TotRecursos[0]->TotalCpu, 0, ',', '.') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Total Storage</span>
                                <span class="info-box-number">{{ number_format($TotRecursos[0]->Storage, 0, ',', '.')  }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-desktop"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Total VMs</span>
                                <span class="info-box-number">{{ number_format($TotRecursos[0]->TotalVm, 0, ',', '.') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>


        <!-- /.col -->

            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">HA Datacenter {{strtoupper($datacenterName)}}</h5>
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
                                    Clusters con HA Operativo 
                                    <span class="float-right"><b>1</b>/{{$porcOperativo}}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width:{{$porcOperativo}}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                Clusters sin HA Inopertivo
                                    <span class="float-right"><b>0</b>/{{$porcInoperativo}}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width:{{$porcInoperativo}}%"></div>
                                    </div>
                                </div>

                                <!-- /.progress-group -->

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

            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Drs Datacenter {{ strtoupper($datacenterNameDrs)}} </h5>
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
                                Clusters con Drs Operativo
                                    <span class="float-right"><b>1</b>/{{$porcOperativoDrs}}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width:{{$porcOperativoDrs}}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                Clusters con Drs Inoperativo
                                    <span class="float-right"><b>0</b>/{{$porcInoperativoDrs}}%</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width:{{$porcInoperativoDrs}}%"></div>
                                    </div>
                                </div>

                                <!-- /.progress-group -->

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

            <!-- <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Storage total y usado por cluster</h5>
                    </div>                  
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <canvas id="pieChart3" height="150"></canvas>
                                </div>                               
                            </div>                           
                        </div>                      
                    </div>                   
                </div>               
            </div> -->
          



</div>
        @isset($datos)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre Cluster</th>
                    <th>NumCpuCores</th>
                    <th>TotalCpuGhz</th>
                    <th>TotalMemoryGb</th>
                    <th>TotalStorageGb</th>
                    <th>StorageUsedGb</th>
                    <th>TotalVm</th>
                    <th>HAEnabled</th>
                    <th>DrsEnabled</th>
                </tr>
            </thead>
            <tbody>
            @foreach($datos as $dato)
                <tr>
                    <td>{{ $dato->clusterName }}</td>
                    <td>{{ $dato->clusterNumCpuCores }}</td>
                    <td>{{ $dato->clusterTotalCpuGhz}}</td>
                    <td>{{ $dato->clusterTotalMemoryGb }}</td>
                    <td>{{ $dato->clusterTotalStorageGb }}</td>
                    <td>{{ $dato->clusterStorageUsedGb }}</td>
                    <td>{{ $dato->clusterTotalVm}}</td>
                    <td>{{ $dato->clusterHAEnabled}}</td>
                    <td>{{ $dato->clusterDrsEnabled}}</td>
                </tr>
            @endforeach
            </tbody>               
        </table>
    @endisset
<script>
        var botmanWidget = {
            chatServer: "/asgard/botman",
            frameEndpoint: "botman/chat",
            title: "Chat de ayuda",
            aboutText: 'Claro',
            introMessage: " Hola! Soy Loki y sere tu ayudante dentro del portal de Asgard",
            placeholderText: "Enviar mensaje",
            mainColor: "#DA291C",
            bubbleBackground: "#DA291C"
        };
</script>
<script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
    <script>       

        $(function () {

             //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                //alert(pieChartCanvas);

                //alert(pieChartCanvas);
                var pieData        = {
                    labels: [
                    'Operativo',
                    'Inoperativo'
                ],
                datasets: [
                    { 
                    data: ["{{$porcOperativo }}" ,"{{$porcInoperativo }}"],
                        backgroundColor : ['#00a65a', '#f56954'],
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

            //-------------
            //- PIE CHART -
            //-------------
            // Get context with jQuery - using jQuery's .get() method.
            var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')

                var pieData        = {
                    labels: [
                    'Operativo',
                    'Inoperativo'                    
                    ],
                    datasets: [
                        {
                        data: ["{{$porcOperativoDrs }}" ,"{{$porcInoperativoDrs}}"],
                        backgroundColor : ['#00a65a', '#f56954'],
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



            //----------------------------------------
            //- PIE CHART STORAGE USADO Y TOTAL VMHOST
            //----------------------------------------
    
            // Obtener una referencia al elemento canvas del DOM
/*             var pieChartCanvas = $('#pieChart3').get(0).getContext('2d')
            let dataStorage = @json($StorageCluster);            

            // Podemos tener varios conjuntos de datos
            const datosVentas2020 = {
                label: "Total Storage",
                data: dataStorage.map(storage => storage.clusterTotalStorageGb), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                backgroundColor: 'rgba(0, 99, 132, 1)', // Color de fondo
                //borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 1,// Ancho del borde
            };
            const datosVentas2021 = {
                label: "Total Storage Usado",
                data: dataStorage.map(storage => storage.clusterStorageUsedGb), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                backgroundColor: 'rgba(99, 132, 0, 0.6)',// Color de fondo
                //borderColor: 'rgba(255, 159, 64, 1)',// Color del borde
                borderWidth: 1,// Ancho del borde
            };

            new Chart(pieChartCanvas, {
                type: 'bar',// Tipo de gráfica
                data: {
                    labels: dataStorage.map(storage => storage.clusterName),               
                    datasets: [
                        datosVentas2020,
                        datosVentas2021,
                        // Aquí más datos...
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                    },
                }
            }); */
            //----------------
            //- END PIE CHART
            //----------------


          
        });
    </script>
@stop

