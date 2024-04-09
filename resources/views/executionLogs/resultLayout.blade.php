<tr>
    <td>
        Resultado:
    </td>
    <td>
        @switch($executionLog->status)
            @case(0)
                {{ $executionLog->result }}
                @break
            @case(1)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(2)
                {{ $executionLog->result }}
                @break
            @case(3)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(4)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(5)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(6)
                <a href="{{ $executionLog->result }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(7)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(12)
                {{ $executionLog->result }}
                @break
            @case(13)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @case(14)
                <a href="{{ route('ExecutionLog.showRs',$executionLog->id) }}" target="_blank" title="Ver Resultado">
                    <button class="btn btn-sm btn-default">
                        <i class="fa fa-eye" style="color: #0d6aad"></i>
                    </button>
                </a>
                @break
            @default

        @endswitch
    </td>
</tr>
