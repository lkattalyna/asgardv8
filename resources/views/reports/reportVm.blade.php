<!-- 'VmVersion','','VmHot',' VmTotales' -->


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
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-desktop"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Total Vms</span>
                                <span class="info-box-number">{{ $totalVm }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-memory"></i></span>
              
                <div class="info-box-content">
                                <span class="info-box-text">Tot. MemoriaGB</span>
                                <span class="info-box-number">{{ number_format($VmTotales[0]->sumMemory, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-microchip"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Tot. CpuGB</span>
                                <span class="info-box-number">{{ number_format($VmTotales[0]->sumcpu, 0, ',', '.') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Total AprovGB</span>
                                <span class="info-box-number">{{ number_format($VmTotales[0]->sumProv, 0, ',', '.')  }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-database"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Tot. LibreGB</span>
                                <span class="info-box-number">{{ number_format($VmTotales[0]->sumEspacio, 0, ',', '.') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>    

            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Vmware Tools Instalados / No instalados</h5>
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
                                @foreach($VmGuestFamily as $guestfamily)
                                    <div class="progress-group">
                                        @if($guestfamily->vmGuestFamily == "")
                                            vmwareTools no instalados <b>{{$guestfamily->cantidadGuestFamily}}</b>
                                        @else
                                            {{$guestfamily->vmGuestFamily}} <b>{{$guestfamily->cantidadGuestFamily}}</b>
                                        @endif
                                     
                                        <span class="float-right"></span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$guestfamily->cantidadGuestFamily}}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>                          
                        </div>                        
                    </div>                   
                </div>               
            </div>           

            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Información HotAddMemory / HotAddCpu </h5>
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
                                HotAddMemory
                                    <span class="float-right"><b>{{$VmHot[0]->cantmemory}}</b></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width:{{$VmHot[0]->cantmemory}}%"></div>
                                    </div>
                                </div>                             
                                <div class="progress-group">
                                HotAddCpu
                                    <span class="float-right"><b>{{$VmHot[0]->cantCpu}}</b></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" style="width:{{$VmHot[0]->cantCpu}}%"></div>
                                    </div>
                                </div>                             
                            </div>                         
                        </div>                       
                    </div>                   
                </div>               
            </div>           

            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Resumen de Versiones instaladas</h5>
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
                                @foreach($VmVersion as $version)
                                    <div class="progress-group">
                                        @if($version->vmHardwareVersion == "")
                                            Sin versión <b>{{$version->cantidadVersion}}</b>
                                        @else
                                            {{$version->vmHardwareVersion}} <b>{{$version->cantidadVersion}}</b>
                                        @endif
                                     
                                        <span class="float-right"></span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar bg-info" style="width:{{$guestfamily->cantidadGuestFamily}}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>                          
                        </div>                        
                    </div>                   
                </div>               
            </div>        



</div>
@isset($datos)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>       
                <tr>               
                        <th>vmNameFFFFF {{ $totalVm }}</th>  
                        <th>vmPowerState</th>  
                        <th>vmMemoryGB</th>  
                        <th>vmCpuCount</th>  
                        <th>vmResourcePool</th>  
                        <th>vmHotAddMemory</th>  
                        <th>vmHotAddCpu</th>  
                        <th>vmHardwareVersion</th>  
                        <th>vmProvisionedSpaceGB</th>  
                        <th>vmUsedSpaceGB</th>  
                        <th>vmGuestFamily</th>  
                        <th>vmGuestFullName</th>  
                        <th>vmToolsStatus</th>  
                        <th>vmToolsRunningStatus</th>  
                        <th>vmHostName</th>  
                        <th>vmIpAddress</th>   
                </tr>           
            </thead>

            <tbody>
                @foreach($datos as $dato)
                    <tr>
                        <td>{{ $dato->vmName }}</td>  
                        <td>{{ $dato->vmPowerState }}</td>  
                        <td>{{ $dato->vmMemoryGB }}</td>  
                        <td>{{ $dato->vmCpuCount }}</td>  
                        <td>{{ $dato->vmResourcePool }}</td>  
                        <td>{{ $dato->vmHotAddMemory }}</td>  
                        <td>{{ $dato->vmHotAddCpu }}</td>  
                        <td>{{ $dato->vmHardwareVersion }}</td>  
                        <td>{{ $dato->vmProvisionedSpaceGB }}</td>  
                        <td>{{ $dato->vmUsedSpaceGB }}</td>  
                        <td>{{ $dato->vmGuestFamily }}</td>  
                        <td>{{ $dato->vmGuestFullName }}</td>  
                        <td>{{ $dato->vmToolsStatus }}</td>  
                        <td>{{ $dato->vmToolsRunningStatus }}</td>  
                        <td>{{ $dato->vmHostName }}</td>  
                        <td>{{ $dato->vmIpAddress }}</td>
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
                let VmGuestFamily = @json($VmGuestFamily);
                //console.log(dataStorage);
              
                var pieData = {
                    labels: VmGuestFamily.map(GuestFamily => GuestFamily.vmGuestFamily),
                    datasets: [
                        { 
                            data: VmGuestFamily.map(GuestFamily => GuestFamily.cantidadGuestFamily),
                            backgroundColor: VmGuestFamily.map(GuestFamily => '#'+Math.floor(Math.random()*16777215).toString(16)),
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
              
                var pieData = {
                    labels: [
                    'HotAddMemory',
                    'HotAddCpu'
                ],
                    datasets: [
                        { 
                            data: ["{{$VmHot[0]->cantmemory}}" ,"{{$VmHot[0]->cantCpu}}"],                  
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
            var pieChartCanvas = $('#pieChart3').get(0).getContext('2d')
                let VmVersion = @json($VmVersion);
                //console.log(dataStorage);
              
                var pieData = {
                    labels: VmVersion.map(version => version.vmHardwareVersion),
                    datasets: [
                        { 
                            data: VmVersion.map(version => version.cantidadVersion),
                            backgroundColor: VmVersion.map(version => '#'+Math.floor(Math.random()*16777215).toString(16)),
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

