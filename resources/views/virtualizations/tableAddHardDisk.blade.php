@section('contentPanel')
    <div >
        <div >

        <table  id="table_vlans" class="table table-bordered table-striped" style="width:102%">
                    <tr>
                    <th colspan= 3>Información de discos duros actuales en Vms</th> 
                    <tr>
                    <tr>
                        <th>Discos</th>
                        <th>Datastore</th>
                        <th>Tamaño aprovisonado GB</th>
                    </tr>
                    @for ( $i = 0 ;$i<$countdisk;$i++)    
                    <tr>
                            <td>{{$resultdisk['disco'][$i]}}</td>
                            <td>{{$resultdisk['datastore'][$i]}}</td>
                            <td>{{$resultdisk['capacityDisk'][$i]}}</td>
                    </tr>
            @endfor
    
        </table>

    <table  id="table_vlans" class="table table-bordered table-striped" style="width:102%">
        <tr>
        <th colspan= 2>Adición de discos duros</th> 
        </tr>    

        <tr>
                <td>
                    <label style="text-align:center;">{{ __('Datastore') }}</label>
                </td>
            <td >
                    <label>{{ __('CapacidadGB') }}</label>
                </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <select name="datastore[]" id="datastore" class="form-control" style="width: 102%" required>
                        <option value="0">Seleccione...</option> 
                        @for ( $i = 0 ;$i<$countDatastore;$i++)                       
                        <option value="{{$datastoreCluster['Name'][$i]}},{{$datastoreCluster['availableProvisioned'][$i]}}">{{$datastoreCluster['Name'][$i]}} => Tamaño disponible: {{$datastoreCluster['availableProvisioned'][$i]}} GB</option>
                        @endfor
                    </select>
                </div>
            </td>        
            <td>
                <input type="text" name="tamanoaprov" id="tamanoaprov" class="form-control input-md" value="{{ old('tamanoaprov') }}" maxlength="4" placeholder="Tamaño aprovisionar">
            </td>
            
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <select name="datastore1[]" id="datastore1" class="form-control" style="width: 100%" required>
                        <option value="0">Seleccione...</option>     
                        @for ( $i = 0 ;$i<$countDatastore;$i++)                       
                        <option value="{{$datastoreCluster['Name'][$i] }},{{$datastoreCluster['availableProvisioned'][$i]}}">{{$datastoreCluster['Name'][$i]}} => Tamaño disponible: {{$datastoreCluster['availableProvisioned'][$i]}} GB</option>
                        @endfor
                    </select>
                </div>
            </td>        
            <td>
                <input type="text" name="tamanoaprov1" id="tamanoaprov1" class="form-control input-md" value="{{ old('tamanoaprov') }}" maxlength="4" placeholder="Tamaño aprovisionar">
            </td>
        </tr>
        <tr>
            <td>
                <div class="input-group">
                    <select name="datastore2[]" id="datastore2" class="form-control" style="width: 100%" required>
                        <option value="0">Seleccione...</option>        
                        @for ( $i = 0 ;$i<$countDatastore;$i++)                   
                        <option value="{{$datastoreCluster['Name'][$i] }},{{$datastoreCluster['availableProvisioned'][$i]}}">{{$datastoreCluster['Name'][$i]}} => Tamaño disponible: {{$datastoreCluster['availableProvisioned'][$i]}} GB</option>
                        @endfor
                    </select>
                </div>
            </td>        
            <td>
                <input type="text" name="tamanoaprov2" id="tamanoaprov2" class="form-control input-md" value="{{ old('tamanoaprov') }}" maxlength="4" placeholder="Tamaño aprovisionar">
            </td>
        </tr>
    </table>
    </div>
    </div>
@endsection

