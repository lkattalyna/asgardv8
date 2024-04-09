@extends('adminlte::page')
@section('content_header')
    <h1>Inventario General Plataforma - Virtualización</h1><hr>
@stop
@section('plugins.Chartjs', true)
@section('contentPanel')
    <p>Bienvenido {{ Auth::user()->email  }} <span class="float-right">Fecha última actualización: {{$UpdateDate[0]->fecha}}</span></p>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Tot. Host Físicos</span> 
                    <span class="info-box-number">{{number_format($cantTotalHost[0]->cantSegm3, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>

               <div class="info-box-content">
                    <span class="info-box-text">Total Clusters</span>
                    <span class="info-box-number">{{number_format($cantTotalCluster[0]->cant, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-desktop"></i></span>

               <div class="info-box-content">
                    <span class="info-box-text">Total Vms</span>
                    <span class="info-box-number">{{number_format($cantTotalvms[0]->CANT, 0, ',', '.')}}</span>
                </div>

                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>

               <div class="info-box-content">
                    <span class="info-box-text">Total Datastore</span>
                    <span class="info-box-number">{{number_format($cantTotalDts[0]->cant, 0, ',', '.')}}</span>
                </div>

                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-desktop"></i></span>

               <div class="info-box-content">
                    <span class="info-box-text">Tot. Vms apagadas</span>                   
                        <span class="info-box-number">{{number_format($cantTotalVmsOff[0]->cant, 0, ',', '.')}}</span>                    
                </div>               
            </div>           
        </div>      

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-desktop"></i></span>

               <div class="info-box-content">
                    <span class="info-box-text">Tot. Vms encendidas</span>                  
                            <span class="info-box-number">{{number_format($cantTotalVmsOn[0]->cant, 0, ',', '.')}}</span>                      
                </div>                
            </div>            
        </div>    

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Distribución de Host Físicos </h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart" height="150"></canvas>
                                </div>                               
                            </div>                           
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>
                                @foreach ($porcxsegHost as $datos)
                                    <div class="progress-group">                                      
                                        {{$datos->segmentName}}
                                        <span class="float-right"><b>{{$datos->cantNum}}</b>/{{$datos->porcentaje}}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$datos->cantNum}}%"></div>
                                        </div>
                                    </div>
                                @endforeach                                
                            </div>                           
                        </div>                      
                    </div>                   
                </div>              
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Distribución de Clústeres</h5>
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

                                @foreach ($porcxsegCluster as $datos)
                                    <div class="progress-group">                                     
                                        {{$datos->segmentName}}
                                        <span class="float-right"><b>{{$datos->cantNum}}</b>/{{$datos->porcentaje}}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$datos->cantNum}}%"></div>
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

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Distribución de Máquinas Virtuales</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart3" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>

                                @foreach ($porcxsegVms as $datos)
                                    <div class="progress-group">                                     
                                        {{$datos->segmentName}}
                                        <span class="float-right"><b>{{$datos->cantNum}}</b>/{{$datos->porcentaje}}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$datos->cantNum}}%"></div>
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

            
        <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Distribución de DataStore</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart4" height="150"></canvas>
                                </div>                               
                            </div>                           
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>
                                @foreach ($porcxsegDts as $datos)
                                    <div class="progress-group">                                      
                                        {{$datos->segmentName}}
                                        <span class="float-right"><b>{{$datos->cantNum}}</b>/{{$datos->porcentaje}}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$datos->cantNum}}%"></div>
                                        </div>
                                    </div>
                                @endforeach                                
                            </div>                           
                        </div>                      
                    </div>                   
                </div>              
            </div>
            

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Distribución Máquinas virtuales apagadas</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart5" height="150"></canvas>
                                </div>                               
                            </div>                           
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>
                                @foreach ($porcxsegVmsOff as $datos)
                                    <div class="progress-group">                                      
                                        {{$datos->segmentName}}
                                        <span class="float-right"><b>{{$datos->cantNum}}</b>/{{$datos->porcentaje}}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$datos->cantNum}}%"></div>
                                        </div>
                                    </div>
                                @endforeach                                
                            </div>                           
                        </div>                      
                    </div>                   
                </div>              
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Distribución de Máquinas virtuales encendidas</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="chart-responsive">
                                    <canvas id="pieChart6" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-5">
                                <p class="text-center">
                                    <strong>Resumen</strong>
                                </p>

                                @foreach ($porcxsegVmsOn as $datos)
                                    <div class="progress-group">                                     
                                        {{$datos->segmentName}}
                                        <span class="float-right"><b>{{$datos->cantNum}}</b>/{{$datos->porcentaje}}%</span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$datos->cantNum}}%"></div>
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

                let dataPorcxsegHost = @json($porcxsegHost);            

                var pieData        = {
                    labels: dataPorcxsegHost.map(datos => datos.segmentName),
                datasets: [
                    {
                    data: dataPorcxsegHost.map(datos => datos.cantNum),
                    backgroundColor : dataPorcxsegHost.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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
                //alert(pieChartCanvas);

                let porcxsegCluster = @json($porcxsegCluster);            

                var pieData        = {
                    labels: porcxsegCluster.map(datos => datos.segmentName),
                datasets: [
                    {
                    data: porcxsegCluster.map(datos => datos.cantNum),
                    backgroundColor : porcxsegCluster.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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
            var pieChartCanvas = $('#pieChart3').get(0).getContext('2d')
                //alert(pieChartCanvas);

                let porcxsegVms = @json($porcxsegVms);            

                var pieData        = {
                    labels: porcxsegVms.map(datos => datos.segmentName),
                datasets: [
                    {
                    data: porcxsegVms.map(datos => datos.cantNum),
                    backgroundColor : porcxsegVms.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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
            var pieChartCanvas = $('#pieChart4').get(0).getContext('2d')
                //alert(pieChartCanvas);

                let porcxsegDts = @json($porcxsegDts);            

                var pieData        = {
                    labels: porcxsegDts.map(datos => datos.segmentName),
                datasets: [
                    {
                    data: porcxsegDts.map(datos => datos.cantNum),
                    backgroundColor : porcxsegDts.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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
            var pieChartCanvas = $('#pieChart5').get(0).getContext('2d')
                //alert(pieChartCanvas);

                let  porcxsegVmsOff = @json($porcxsegVmsOff);            

                var pieData        = {
                    labels:  porcxsegVmsOff.map(datos => datos.segmentName),
                datasets: [
                    {
                    data:  porcxsegVmsOff.map(datos => datos.cantNum),
                    backgroundColor :  porcxsegVmsOff.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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
            var pieChartCanvas = $('#pieChart6').get(0).getContext('2d')
                //alert(pieChartCanvas);

                let  porcxsegVmsOn = @json($porcxsegVmsOn);            

                var pieData        = {
                    labels:  porcxsegVmsOn.map(datos => datos.segmentName),
                datasets: [
                    {
                    data:  porcxsegVmsOn.map(datos => datos.cantNum),
                    backgroundColor :  porcxsegVmsOn.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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

