@section('contentPanel')
    @isset($items)
        @if(is_array($items))
            <table id="example1" class="table table-bordered table-striped" style="width:100%">
                <thead>
                <tr>
                    <th>Nombre del archivo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item }}</td>
                        <td style="text-align:center; ">
                            <a href="{{ route('windowsPH.getCheckSOShow',[$folder, $item]) }}" title="Ver" target="_blank">
                                <button class="btn btn-sm btn-default">
                                    <i class="fa fa-eye" style="color: #0d6aad"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>{{ $items }}</p>
        @endif
    @endisset
@stop
