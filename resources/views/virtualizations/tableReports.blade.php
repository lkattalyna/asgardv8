@section('contentPanel')
    @isset($reports)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nombre del reporte</th>
                <th>Tipo de reporte</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->name }}</td>
                    <td>{{ $report->report }}</td>
                    <td>{{ $report->created_at }}</td>                    
                    <td style="text-align:center; ">
                        <a href="{{ asset('scriptRs/VReports/'.$report->name) }}" target="_blank" title="Ver Resultado">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
@stop
