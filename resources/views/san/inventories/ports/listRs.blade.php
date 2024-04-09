@section('contentPanel')
    @isset($items)
        <table class="table table-striped table-bordered" >
            <thead>
                <tr><th class="text-center" colspan="4">Distribución de puertos</th></tr>
                <tr>
                    <th class="text-center">Total</th>
                    <th class="text-center">Libres</th>
                    <th class="text-center">Aprovisionados</th>
                    <th class="text-center">Reservados</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ $total }}</td>
                    <td class="text-center">{{ $libre }}</td>
                    <td class="text-center">{{ $aprovisionado }}</td>
                    <td class="text-center">{{ $reservado }}</td>
                </tr>
            </tbody>
        </table>
        <hr>
        <table id="example1" class="table table-striped table-bordered" >
            <thead>
                <tr>
                    <th>Nombre del switch</th>
                    <th>Nombre del puerto</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Slot</th>
                    <th>Puerto</th>
                    <th>IM</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->getSwitch->sw }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->service }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->slot }}</td>
                        <td>{{ $item->port }}</td>
                        <td>{{ $item->im }}</td>
                        <td class="center">
                            <div class="btn-group">
                                <a href="{{ route('sanPorts.show',$item->id)}}" title="Ver">
                                    <button class="btn btn-sm btn-default">
                                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                                    </button>
                                </a>
                                @can('sanSwitch-edit')
                                    <a href="{{ route('sanPorts.edit',$item->id)}}" title="Editar">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-edit" style="color: #0d6aad"></i>
                                        </button>
                                    </a>
                                @endcan
                                @can('sanSwitch-delete')
                                    <a href="#" title="Eliminar" data-href="{{route('sanPorts.destroy',$item->id)}}" data-toggle="modal" data-target="#confirm-delete">
                                        <button class="btn btn-sm btn-default">
                                            <i class="fa fa-trash" style="color: #c51f1a;"></i>
                                        </button>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endisset
@stop
