@section('plugins.Chartjs', true)
@section('contentPanel')
<div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Datacenter</span>
                    <span class="info-box-number">{{ $totalDatacenter }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>       
</div>   
    @isset($datos)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr> 
                    <th>Nombre Datacenter</th>              
                    <th>datacenterCluster</th>
                    <th>datacenterHost</th>   
                    <th>datacenterVm</th>   
                    <th>datacenterNetwork</th>   
                    <th>datacenterDatastore</th>                  
                </tr>
            </thead>
            <tbody>
            @foreach($datos as $dato)
                <tr>
                    <td>{{ $dato->datacenterName }}</td>                   
                    <td>{{ $dato->datacenterCluster }}</td>
                    <td>{{ $dato->datacenterHost}}</td> 
                    <td>{{ $dato->datacenterVm}}</td>     
                    <td>{{ $dato->datacenterNetwork}}</td>     
                    <td>{{ $dato->datacenterDatastore}}</td>                                         
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
@stop
