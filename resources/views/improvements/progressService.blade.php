<table class="table table-bordered table-hover">
    @switch($service)
        @case(1)
            <tr>
                <th>
                    <label class="text-md-right">Cantidad de CI's total</label>
                </th>
                <td>{{ $improvement->ci_goal }}</td>
            </tr>
            <tr>
                <th>
                    <label class="text-md-right">Progreso de avance en alcance de CI's</label>
                </th>
                <td>{{ $improvement->ci_progress }}</td>
            </tr>
            <tr>
                <th>
                    <label class="text-md-right">CI's pendientes por alcanzar</label>
                </th>
                <td>{{ $improvement->ci_goal - $improvement->ci_progress }}</td>
            </tr>
            <tr>
                <th>
                    <label for="progress" class="text-md-right">Cantidad de CI's en esta actualización</label>
                </th>
                <td>
                    <input type="number" name="progress" id="progress" class="form-control" value="{{ old('progress') }}"  placeholder="0"
                           min="1" max="{{ $improvement->ci_goal - $improvement->ci_progress }}" required>
                </td>
            </tr>
            <input type="hidden" name="service" id="service" value="{{ $service }}">
        @break
        @case(2)
            <tr>
                <th>
                    <label class="text-md-right">Progreso actual</label>
                </th>
                <td>{{ $improvement->dev_progress }}%</td>
            </tr>
            <tr>
                <th>
                    <label class="text-md-right">Progreso pendiente por alcanzar</label>
                </th>
                <td>{{ 100 - $improvement->dev_progress }}%</td>
            </tr>
            <tr>
                <th>
                    <label for="progress" class="text-md-right">Progreso de esta actualización</label>
                </th>
                <td>
                    <input type="number" name="progress" id="progress" class="form-control" value="{{ old('progress') }}"  placeholder="0"
                           min="1" max="{{ 100 - $improvement->dev_progress }}" required>
                </td>
            </tr>
            <input type="hidden" name="service" id="service" value="{{ $service }}">
        @break
        @case(3)
            <tr>
                <th>
                    <label class="text-md-right">Progreso actual</label>
                </th>
                <td>{{ $improvement->int_progress }}%</td>
            </tr>
            <tr>
                <th>
                    <label class="text-md-right">Progreso pendiente por alcanzar</label>
                </th>
                <td>{{ 100 - $improvement->int_progress }}%</td>
            </tr>
            <tr>
                <th>
                    <label for="progress" class="text-md-right">Progreso de esta actualización</label>
                </th>
                <td>
                    <input type="number" name="progress" id="progress" class="form-control" value="{{ old('progress') }}"  placeholder="0"
                           min="1" max="{{ 100 - $improvement->int_progress }}" required>
                </td>
            </tr>
            <input type="hidden" name="service" id="service" value="{{ $service }}">
        @break
        @case(4)
            <tr>
                <th>
                    <label class="text-md-right">Progreso actual</label>
                </th>
                <td>{{ $improvement->test_progress }}%</td>
            </tr>
            <tr>
                <th>
                    <label class="text-md-right">Progreso pendiente por alcanzar</label>
                </th>
                <td>{{ 100 - $improvement->test_progress }}%</td>
            </tr>
            <tr>
                <th>
                    <label for="progress" class="text-md-right">Progreso de esta actualización</label>
                </th>
                <td>
                    <input type="number" name="progress" id="progress" class="form-control" value="{{ old('progress') }}"  placeholder="0"
                           min="1" max="{{ 100 - $improvement->test_progress }}" required>
                </td>
            </tr>
            <input type="hidden" name="service" id="service" value="{{ $service }}">
        @break
        @default
            <tr>
                <th>No existe un formulario asociado al servicio seleccionado</th>
            </tr>
            <input type="hidden" name="service" id="service" value="0">
        @break
    @endswitch
</table>
