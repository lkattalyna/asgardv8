@section('contentPanel')
    @isset($tasks)
        <table id="example1" class="table table-bordered table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>ID Job AWX</th>
                    <th>Playbook</th>
                    <th>Usuario</th>
                    <th>Grupo</th>
                    <th>Estado</th>
                    <th title="Fecha de ejecución en Asgard">Fecha EA</th>
                    <th title="Fecha de inicio del job en Ansible">Fecha IJA</th>
                    <th title="Fecha de finalización del job en Ansible">Fecha FJA</th>
                </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->id_job }}</td>
                    @if ($task->playbook)
                        <td>{{ $task->playbook }}</td>
                    @else
                        <td>No Disponible</td>
                    @endif
                    <td>{{ $task->user }}</td>
                    <td>{{ $task->user_group }}</td>
                    <td>
                        @if($task->status==0)
                            <span class="badge badge-warning right">En proceso</span>
                        @elseif($task->status>=1 && $task->status<=9)
                            <span class="badge badge-success right">Finalizado</span>
                        @elseif($task->status>=11)
                            <span class="badge badge-danger right">Error</span>
                        @endif
                    </td>
                    <td>{{ $task->created_at }}</td>
                    <td>{{ $task->d_ini_script }}</td>
                    <td>{{ $task->d_end_script }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>
                    <th>Playbook</th>
                    <th>Usuario</th>
                    <th>Grupo</th>
                    <th colspan="4"></th>
                </tr>
            </tfoot>
        </table>
    @endisset
@stop
