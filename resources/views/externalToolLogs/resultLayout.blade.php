<tr>
    <td>
        Resultado:
    </td>
    <td>
        @switch($externalToolLog->status)
            @case(0)
                {{ $externalToolLog->result }}
                @break
            @case(1)
                <a href="{{ asset('scriptRs/'.$externalToolLog->result) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(2)
                {{ $externalToolLog->result }}
                @break
            @case(3)
                <a href="{{ route('ExecutionLog.getJobResult',$externalToolLog->id_job) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(4)
                <a href="{{ $externalToolLog->result }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(12)
                {{ $externalToolLog->result }}
                @break
            @case(13)
                <a href="{{ route('ExecutionLog.getJobResult',$externalToolLog->id_job) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @default

        @endswitch
    </td>
</tr>
