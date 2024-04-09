@section('contentPanel')
    @isset($hosts)
    <p><span class="float-right">Fecha última actualización: {{$UpdateDate[0]->fecha}}</span></p>
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nombre Maquina</th>
                <th>Estado</th>
                <th>Cluster</th>
                <th>vCenter</th>
                <th>Acciones</th>
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
                    <td>{{ $host->cluster }}</td>
                    <td>{{ $host->vcenter }}</td>
                    <td style="text-align:center; ">
                        <a href="#" title="Ejecutar Diagnostico" class="Vlink" data-id="{{ $host->vm_id }}" data-vcenter="{{ $host->vcenter }}" data-name="{{ $host->name }}" data-cluster="{{ $host->cluster }}" data-power_state="{{ $host->power_state }}">
                            <button class="btn btn-sm btn-danger" data-="">
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
