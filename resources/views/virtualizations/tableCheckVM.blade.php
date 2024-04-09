@section('contentPanel')
    @isset($hosts)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Nombre Maquina</th>
                <th>ID Asgard</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>

                <tr>
                    <td>{{ $hosts->name }}</td>
                    <td>{{ $hosts->id_asgard }}</td>
                    <td>{{ $hosts->created_at }}</td>
                    <td style="text-align:center; ">
                        <a href="{{route('virtualization.checkVMRepair',[$hosts->name, $hosts->id_asgard])}}" title="Ver" target="_blank">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>
    @endisset
@stop
