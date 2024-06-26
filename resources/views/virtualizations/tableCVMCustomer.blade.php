@section('contentPanel')
    @isset($hosts)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nombre Maquina</th>
                <th>Estado</th>
                <th>Memoria</th>
                <th>CPU</th>
                <th>Cluster</th>
                <th>vCenter</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hosts as $host)
                <tr>
                    <td>{{ $host->name }}</td>
                    <?php if ($host->power_state == "1") { ?>
                        <td style="text-align:center; color: green"><i class="fas fa-power-off"></i></td>
                    <?php } else { ?>
                        <td style="text-align:center; color: red"><i class="fas fa-power-off"></i></td>
                    <?php } ?>
                    <td>{{ $host->memory }}</td>
                    <td>{{ $host->cpu }}</td>
                    <td>{{ $host->cluster }}</td>
                    <td>{{ $host->vcenter }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
@stop
