@section('contentPanel')
    @isset($logs)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Estado Respaldo</th>
                <th>Nombre Maquina</th>
                <th>Cliente Virtualizacion</th>
                <th>Tipo Respaldo</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->commvaultVmStatus }}</td>
                    <td>{{ $log->commvaultMachineName }}</td>
                    <td>{{ $log->commvaultVirtualizationClient }}</td>
                    <td>{{ $log->commvaultBackupLevel }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
@stop
