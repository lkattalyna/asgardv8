
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
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>
                
                <div class="info-box-content">
                    <span class="info-box-text">Tot. Datastore</span>
                    <span class="info-box-number">{{ number_format($totalDatastore, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>  
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tot. DatastoreGB</span>
                    <span class="info-box-number">{{ number_format($DataStoreTotales[0]->totDatastore, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>      
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tot. EfectivoGB</span>
                    <span class="info-box-number">{{ number_format($DataStoreTotales[0]->totalEfectivo, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3"> 
               @if($DataStoreTotales[0]->totUsado >= $DataStoreTotales[0]->totalEfectivo)
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-database"></i></span>
                @else
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-database"></i></span>
                @endif      
                <!-- <span class="info-box-icon bg-success elevation-1"><i class="fas fa-database"></i></span> -->
                @if($DataStoreTotales[0]->totUsado >= $DataStoreTotales[0]->totalEfectivo)
                    <div class="info-box-content bg-danger">
                    <span class="info-box-text">Tot. UtilizadoGB (Atención)</span>    
                @else 
                    <div class="info-box-content">
                    <span class="info-box-text">Tot. UtilizadoGB</span>    
                @endif
                    <!-- <span class="info-box-text">Tot. UtilizadoGB</span> -->
                    <span class="info-box-number">{{ number_format($DataStoreTotales[0]->totUsado, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
            @if($DataStoreTotales[0]->totUsado >= $DataStoreTotales[0]->totalEfectivo)
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-database"></i></span>
                <div class="info-box-content bg-primary">
                    <span class="info-box-text">Tot. aprovisionadoGB (Atención)</span>
            @else 
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Tot. aprovGB</span>           
            @endif 
                <span class="info-box-number">{{ number_format($DataStoreTotales[0]->totAprovisionado, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tot. Esp. LibreGB</span>
                    <span class="info-box-number">{{ number_format($DataStoreTotales[0]->totLibre, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content --> 
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Libre Efectivo</span>
                    <span class="info-box-number">{{ number_format($DataStoreTotales[0]->libreEfectivo, 0, ',', '.')}}</span>
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
                        <h5 class="card-title">Total Datastore Diponibles / No disponibles</h5>
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
                                Available
                                    <span class="float-right"><b></b>{{$stateAvailable}}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width:{{$stateAvailable}}%"></div>
                                    </div>
                                </div>
                                <!-- /.progress-group -->

                                <div class="progress-group">
                                Unavailable
                                    <span class="float-right"><b></b>{{$stateUnavailable}}</span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width:{{$stateUnavailable}}%"></div>
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
                        <h5 class="card-title">Cantidad por tipo de versión</h5>
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
                                @foreach($DataStoreVersion as $version)
                                    <div class="progress-group">
                                    Versión: {{ $version->datastoreVersion }}
                                        <span class="float-right"><b></b>{{$version->Cantidad}}</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-success" style="width:{{$version->Cantidad}}%"></div>
                                        </div>
                                    </div>
                                @endforeach                             
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

          



</div>
@isset($datos)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>               
                    <th>Nombre Datastore</th>              
                    <th>Estado Datastore</th>
                    <th>datastoreNaa</th>                 
                    <th>datastoreCapacityGB</th>
                    <th>datastoreUsedGB </th>
                    <th>datastoreProvisionedGB </th>
                    <th>datastoreFreeSpaceGB</th>     
                    <th>datastoreType</th>      
                    <th>datastoreVersion</th> 
                    <th>datastoreHostCount</th>     
                    <th>datastoreVmCount</th>  
                </tr>
            </thead>
            <tbody>
            @foreach($datos as $dato)
                <tr>
                    <td>{{ $dato->datastoreName }}</td>                   
                    <td>{{ $dato->datastoreState }}</td>
                    <td>{{ $dato->datastoreNaa}}</td>
                    <td>{{ $dato->datastoreCapacityGB }}</td>                   
                    <td>{{ $dato->datastoreUsedGB }}</td>
                    <td>{{ $dato->datastoreProvisionedGB }}</td>
                    <td>{{ $dato->datastoreFreeSpaceGB}}</td>     
                    <td>{{ $dato->datastoreType}}</td>      
                    <td>{{ $dato->datastoreVersion}}</td> 
                    <td>{{ $dato->datastoreHostCount}}</td>     
                    <td>{{ $dato->datastoreVmCount}}</td>                              
                </tr>
            @endforeach
            </tbody>
                <!-- <tfoot>
                    <tr>
                        <th>Segmento</th>
                        <th>Capa de servicio</th>
                        <th colspan="7"></th>
                    </tr>
                </tfoot>           -->
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
                let dataDatastore = @json($dataStoreState);
 
                var pieData        = {
                     labels: dataDatastore.map(datastore => datastore.datastoreState),
                     datasets: [
                        {
                        data: dataDatastore.map(datastore => datastore.cantidadState),
                        backgroundColor : ['#00a65a', '#f56954'],
                        //Math.floor(Math.random()*16777215).toString(16);
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
                let DataStoreVersion = @json($DataStoreVersion);
                console.log(DataStoreVersion);

 
                var pieData        = {
                    labels: DataStoreVersion.map(version => version.datastoreVersion),
                     datasets: [
                        {
                        data: DataStoreVersion.map(version => version.Cantidad),
                        backgroundColor : DataStoreVersion.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
                        //Math.floor(Math.random()*16777215).toString(16);
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

