@section('contentPanel')
    @isset($logs)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Fecha de conexión</th>
                <th>Username</th>
                <th>IP</th>
                <th>Hora de conexión</th>
            </tr>
            </thead>
            <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->ing_date }}</td>
                    <td>{{ $log->loginname }}</td>
                    <td>{{ $log->userip }}</td>
                    <td>{{ $log->act_date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
@stop
