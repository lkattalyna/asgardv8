@section('contentPanel')
    @isset($hosts)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nombre Maquina</th>
                <th>Estado</th>
                <th>vCenter</th>
                <th>Nombre del Snapshot</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($hosts as $host)
                <tr>
                    <td>{{ $host->vm_name }}</td>
                    <?php if ($host->power_status == "1") { ?>
                        <td style="text-align:center; color: green"><i class="fas fa-power-off"></i></td>
                    <?php } else { ?>
                        <td style="text-align:center; color: red"><i class="fas fa-power-off"></i></td>
                    <?php } ?>
                    <td>{{ $host->vcenter }}</td>
                    <td>{{ $host->snap_name }}</td>
                    <td>{{ $host->created_at }}</td>
                    <td style="text-align:center; ">
                        <a href="#" class="Vlink" data-id="{{ $host->vm_id }}" data-vcenter="{{ $host->vcenter }}" data-name="{{ $host->vm_name }}" data-snap="{{ $host->snap_name }}">
                            <button class="btn btn-sm btn-danger">
                                Add
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endisset
@stop
