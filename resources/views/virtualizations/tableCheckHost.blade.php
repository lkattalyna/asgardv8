@section('contentPanel')
    @isset($hosts)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Acciones</th>
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
                    <td style="text-align:center; ">
                        <a href="#" title="Ejecutar Diagnostico" class="Vlink" data-id="{{ $host->host_id }}" data-vcenter="{{ $host->vcenter }}"
                            data-name="{{ $host->name }}">
                            <button class="btn btn-sm btn-danger">
                                Add
                            </button>
                        </a>
                    </td>
                    <td>{{ $host->name }}</td>
                    @if($host->power_state == "PoweredOn")
                        <td style="text-align:center; color: green"><i class="fas fa-power-off"></i></td>
                    @else
                        <td style="text-align:center; color: red"><i class="fas fa-power-off"></i></td>
                    @endif
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
