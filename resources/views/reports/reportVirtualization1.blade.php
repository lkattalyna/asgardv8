@section('plugins.Chartjs', true)
@section('contentPanel')

<div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-server"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Vcenters</span>
                    <span class="info-box-number">{{  $totalVcenterXSegmento }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
       
       
</div>
<!-- <table class="table table-bordered">
        <tr>
            <th>Total Vcenters x segmento</th>
            <td>{{ $totalVcenterXSegmento }}</td>
        </tr>
        <tr>
            <th>Total automatizaciones completadas 100%</th>
            <td></td>
        </tr>
        <tr>
            <th>Total tiempo antes de automatizar</th>
            <td> Minutos</td>
        </tr>
        <tr>
            <th>Total tiempo despues de automatizar</th>
            <td> Minutos</td>
        </tr>
        <tr>
            <th>Total tiempo optimizado</th>
            <td> Minutos</td>
        </tr>
    </table> -->
    <hr><br>
    @isset($datos)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre Vcenter</th>              
                    <th>IP Vcenter</th>
                                   
                   
                </tr>
            </thead>
            <tbody>
            @foreach($datos as $improvement)
                <tr>
                    <td>{{ $improvement->vcenterAlias }}</td>                   
                    <td>{{ $improvement->vcenterIp }}</td>
                              
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
