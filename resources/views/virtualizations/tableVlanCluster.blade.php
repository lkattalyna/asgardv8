@section('contentPanel')
<div >
    <div >
<table  id="table_vlans" class="table table-bordered table-striped" style="width:100%">
    <tr>
            <td>
                <label style="text-align:center;">{{ __('Tarjetas de Red') }}</label>
            </td>
            <td >
                <label>{{ __('Nueva Vlan') }}</label>
            </td>
            <td>
                <label>{{ __('Vlan Actual') }}</label>
            </td>
            <td>
                <label>{{ __('Tipo') }}</label>
            </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_1" value="Network adapter 1" />Network Adapter  1

        </td>
        <td>
            <div class="input-group">
                <select name="vlan" id="V_Network_adapter_1" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>


                          
       

        <td id="N_Network_adapter_1" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_1" name="vlanAnt" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_1" style="color:red; font-weight: bold;"></td>

    </tr>
    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_2" value="Network adapter 2"/>Network Adapter  2

        </td>
        <td>
            <div class="input-group">
                <select name="vlan1" id="V_Network_adapter_2" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                    <option  value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                @endfor
                </select>
            </div>
        </td>

        <td id="N_Network_adapter_2"  style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_2" name="vlan1Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_2" style="color:red; font-weight: bold;"></td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_3" value="Network adapter 3"/>Network Adapter  3
        </td>
        <td>
            <div class="input-group">
                <select name="vlan2" id="V_Network_adapter_3" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                    <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                @endfor
                </select>
            </div>
        </td>

        <td id="N_Network_adapter_3" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_3" name="vlan3Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_3" style="color:red; font-weight: bold;"></td>
    </tr>

    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_4" value="Network adapter 4" />Network Adapter  4

        </td>
        <td>
            <div class="input-group">
                <select name="vlan3" id="V_Network_adapter_4" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_4" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_4" name="vlan4Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_4" style="color:red; font-weight: bold;"></td>

    </tr>

    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_5" value="Network adapter 5" />Network Adapter  5

        </td>
        <td>
            <div class="input-group">
                <select name="vlan5" id="V_Network_adapter_5" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_5" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_5" name="vlan5Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_5" style="color:red; font-weight: bold;"></td>

    </tr>

    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_6" value="Network adapter 6" />Network Adapter  6

        </td>
        <td>
            <div class="input-group">
                <select name="vlan6" id="V_Network_adapter_6" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_6" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_6" name="vlan6Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_6" style="color:red; font-weight: bold;"></td>

    </tr>

    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_7" value="Network adapter 7" />Network Adapter  7

        </td>
        <td>
            <div class="input-group">
                <select name="vlan7" id="V_Network_adapter_7" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_7" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_7" name="vlan7Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_7" style="color:red; font-weight: bold;"></td>

    </tr>

    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_8" value="Network adapter 8" />Network Adapter  8

        </td>
        <td>
            <div class="input-group">
                <select name="vlan8" id="V_Network_adapter_8" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_8" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_8" name="vlan8Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_8" style="color:red; font-weight: bold;"></td>

    </tr>

    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_9" value="Network adapter 9" />Network Adapter  9

        </td>
        <td>
            <div class="input-group">
                <select name="vlan9" id="V_Network_adapter_9" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_9" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_9" name="vlan9Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_9" style="color:red; font-weight: bold;"></td>

    </tr>


    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="networks[]" id="Network_adapter_10" value="Network adapter 10" />Network Adapter  10

        </td>
        <td>
            <div class="input-group">
                <select name="vlan10" id="V_Network_adapter_10" class="form-control" style="width: 100%" required>
                    @for ( $i = 0 ;$i<$countVLAN;$i++)
                        <option value="{{$vlans['vlanName'][$i]}}">{{$vlans['vlanName'][$i]}}</option>
                    @endfor
                </select>
            </div>
        </td>
        <td id="N_Network_adapter_10" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Network_adapter_10" name="vlan10Ant" class="form-control input-md"  maxlength="40">
        </td>

        <td id="T_Network_adapter_10" style="color:red; font-weight: bold;"></td>

    </tr>












</table>
</div>
</div>
@endsection

