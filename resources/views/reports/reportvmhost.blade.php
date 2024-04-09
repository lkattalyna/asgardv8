
<!-- 'vmhostTotales','vmhostStorage','vmhostVerEsxi','vmhostConnected','vmhostVendor',vmhostUptime -->
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
                                <span class="info-box-text">Total Vmhost</span>
                                <span class="info-box-number">{{ $totalVmhost}}</span>
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
                                <span class="info-box-number">{{ number_format($vmhostTotales[0]->totMemory, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-memory"></i></span>
              
                <div class="info-box-content">
                                <span class="info-box-text">MemGB usada</span>
                                <span class="info-box-number">{{ number_format($vmhostTotales[0]->totMemoryUse, 0, ',', '.')}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-microchip"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">Tot. CpuGhz</span>
                                <span class="info-box-number">{{ number_format($vmhostTotales[0]->totCpu, 0, ',', '.') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-microchip"></i></span>

                <div class="info-box-content">
                                <span class="info-box-text">CpuGhz Usada</span>
                                <span class="info-box-number">{{ number_format($vmhostTotales[0]->totCpuUse, 0, ',', '.') }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>    
           


        <!-- Gráfica de barras para vmhostUptime -->
        <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Resumen host cantidad de días operativo</h5>
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
        </div>
        <!-- Fin Gráfica de barras para vmhostUptime -->

        <!-- Gráfica Storage -->
        <div class="col-md-12 ">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Storage total y usado por host</h5>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <canvas id="pieChart2" height="150"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                           
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /card -->
            </div>
            <!-- /md-6-->
        <!-- Fin Gráfica Storage -->

        @isset($vmhostVerEsxi)
            <!-- TABLE: Version ESXi -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Resumen versiones por host</h3>

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
                                    <th>Version host</th>
                                    <th>ESXi Build</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($vmhostVerEsxi as $version)
                                        </tr>
                                        @if($version->vmhostEsxiVersion == "")
                                            <td>Versión no disponible</td>
                                        @else
                                            <td>{{ $version->vmhostEsxiVersion }}</td>
                                        @endif 
                                        @if($version->vmhostEsxiBuild == "")
                                            <td>Build no disponible</td>
                                        @else
                                        <td>{{ $version->vmhostEsxiBuild }}</td>
                                        @endif                                            
                                           
                                            <td>{{ $version->cant }}</td>
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

        @isset($vmhostVendor)
            <!-- TABLE: Fabricante -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Fabricantes</h3>

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
                                    <th>Fabricante</th>                                    
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($vmhostVendor as $fabricante)
                                        </tr>
                                            <td>{{ $fabricante->fabricante }}</td>                                            
                                            <td>{{ $fabricante->cant }}</td>
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

       
      



</div>
@isset($datos)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>          
                    <th>vmhostName</th>    
                    <th>vmhostUptime</th>    
                    <th>vmhostVmCount</th>    
                    <th>vmhostTotalMemoryGb</th>    
                    <th>vmhostMemoryUsageGB</th>    
                    <th>vmhostTotalCpuGhz</th>    
                    <th>vmhostCpuUsageGhz</th>    
                    <th>vmhostTotalStorageGb</th>    
                    <th>vmhostStorageUsageGb</th>    
                    <th>vmhostEsxiVersion</th>    
                    <th>vmhostEsxiBuild</th>    
                    <th>vmhostIp</th>    
                    <th>vmhostManagementServerIp</th>    
                    <th>vmhostConnectionState</th>    
                    <th>vmhostPowerState</th>    
                    <th>vmhostVendor</th>
                    <th>Acciones</th>  
                </tr>
            </thead>
            <tbody>
            @foreach($datos as $dato)
                <tr>
                    <td>{{ $dato->vmhostName }}</td>   
                    <td>{{ $dato->vmhostUptime }}</td>   
                    <td>{{ $dato->vmhostVmCount }}</td>   
                    <td>{{ $dato->vmhostTotalMemoryGb }}</td>   
                    <td>{{ $dato->vmhostMemoryUsageGB }}</td>   
                    <td>{{ $dato->vmhostTotalCpuGhz }}</td>   
                    <td>{{ $dato->vmhostCpuUsageGhz }}</td>   
                    <td>{{ $dato->vmhostTotalStorageGb }}</td>   
                    <td>{{ $dato->vmhostStorageUsageGb }}</td>   
                    <td>{{ $dato->vmhostEsxiVersion }}</td>   
                    <td>{{ $dato->vmhostEsxiBuild }}</td>   
                    <td>{{ $dato->vmhostIp }}</td>   
                    <td>{{ $dato->vmhostManagementServerIp }}</td>   
                    <td>{{ $dato->vmhostConnectionState }}</td>   
                    <td>{{ $dato->vmhostPowerState }}</td>   
                    <td>{{ $dato->vmhostVendor }}</td>
                    <td style="text-align:center; ">
                        <a href="{{ route('virtualization.VMHostShow',$dato->vmhostID) }}" target="_blank" title="Ver detalles">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a>
                    </td>                              
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

            //-----------------------------
            //- PIE CHART UPTIME VMHOST
            //-----------------------------
            var pieChartCanvas = $('#pieChart3').get(0).getContext('2d')

            let vmhostUptime = @json($vmhostUptime);
           //console.log(vmhostUptime);

           var densityData = {
                label: 'Resumen cantidad de días operativo ESXi',
                data: vmhostUptime.map(uptime => uptime.vmhostUptime),
                backgroundColor : vmhostUptime.map(cluster => '#'+Math.floor(Math.random()*16777215).toString(16)),              
                //borderWidth: 2,
                hoverBorderWidth: 0
                };
                
                var chartOptions = {
                scales: {
                    yAxes: [{
                    barPercentage: 0.5
                    }]
                },
                elements: {
                    rectangle: {
                    borderSkipped: 'left',
                    }
                }
                };
                
                var barChart = new Chart(pieChartCanvas, {
                type: 'horizontalBar',
                data: {
                    labels: vmhostUptime.map(uptime => uptime.vmhostName),
                    datasets: [densityData],
                },
                options: chartOptions
            });       

            //-----------------
            //- END PIE CHART -
            //-----------------


            //----------------------------------------
            //- PIE CHART STORAGE USADO Y TOTAL VMHOST
            //----------------------------------------
    
            // Obtener una referencia al elemento canvas del DOM
            var pieChartCanvas = $('#pieChart2').get(0).getContext('2d')

            let vmhostStorage = @json($vmhostStorage);       
           

            // Podemos tener varios conjuntos de datos
            const datosVentas2020 = {
                label: "Total Storage",
                data: vmhostStorage.map(storage => storage.totStorage), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                backgroundColor: 'rgba(0, 99, 132, 1)', // Color de fondo
                //borderColor: 'rgba(54, 162, 235, 1)', // Color del borde
                borderWidth: 1,// Ancho del borde
            };
            const datosVentas2021 = {
                label: "Total Storage Usado",
                data: vmhostStorage.map(storage => storage.totStorageUse), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                backgroundColor: 'rgba(99, 132, 0, 0.6)',// Color de fondo
                //borderColor: 'rgba(255, 159, 64, 1)',// Color del borde
                borderWidth: 1,// Ancho del borde
            };

            new Chart(pieChartCanvas, {
                type: 'bar',// Tipo de gráfica
                data: {
                    labels: vmhostStorage.map(storage => storage.vmhostName.replace('.datacenterdhs.local', '')),
                  /*   labels: [
                    '1',
                    '2',
                    '3',
                    '4'
                ], */
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
            });

            //---------------
            //- END PIE CHART
            //--------------
            
         });
    </script>
@stop

