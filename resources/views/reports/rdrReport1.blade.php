@section('contentPanel')
    <table class="table table-bordered">
        <tr>
            <th>Total automatizaciones</th>
            <td>{{ $totalImp }}</td>
        </tr>
        <tr>
            <th>Total automatizaciones completadas 100%</th>
            <td>{{ $totalImpFinish }}</td>
        </tr>
        <tr>
            <th>Total tiempo antes de automatizar</th>
            <td>{{ $totalTimeB }} Minutos</td>
        </tr>
        <tr>
            <th>Total tiempo despues de automatizar</th>
            <td>{{ $totalTimeA }} Minutos</td>
        </tr>
        <tr>
            <th>Total tiempo optimizado</th>
            <td>{{ $totalTimeO }} Minutos</td>
        </tr>
    </table>
    <hr><br>
    @isset($improvements)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Segmento</th>
                    <th>Capa de servicio</th>
                    <th>Nombre de la automatización</th>
                    <th>Periodo inicial</th>
                    <th>Periodo final</th>
                    <th>Avance total</th>
                    <th>% de avance total</th>
                    <th>Tiempo antes de A.</th>
                    <th>Tiempo despues de A.</th>
                    <th>Tiempo optimizado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($improvements as $improvement)
                <tr>
                    <td>{{ $improvement->serviceSegment->name }}</td>
                    <td>{{ $improvement->serviceLayer->name }}</td>
                    <td>{{ $improvement->playbook_name }}</td>
                    <td>{{ $improvement->start_date }}</td>
                    <td>{{ $improvement->end_date }}</td>
                    <td>{{ $improvement->total_progress }}%</td>
                    <td>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-green" style="width: {{ $improvement->total_progress }}%">{{ $improvement->total_progress }}%</div>
                        </div>
                    </td>
                    <td>{{ $improvement->minutes_before }}</td>
                    <td>{{ $improvement->minutes_after }}</td>
                    <td>{{ $improvement->minutes_total }}</td>
                    <td style="text-align:center; ">
                        <a href="{{ route('improvements.show',$improvement->id) }}" target="_blank" title="Ver detalles">
                            <button class="btn btn-sm btn-default">
                                <i class="fa fa-eye" style="color: #0d6aad"></i>
                            </button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>Segmento</th>
                    <th>Capa de servicio</th>
                    <th colspan="7"></th>
                </tr>
            </tfoot>
        </table>
    @endisset
@stop
