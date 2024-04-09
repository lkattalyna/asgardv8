@section('contentPanel')
<div >
    <div >
<table  id="table_vlans" class="table table-bordered table-striped" style="width:101%">
    <tr>
            <td>
                <label style="text-align:center;">{{ __('Disco duro') }}</label>
            </td>

            <td>
                <label>{{ __('Tamaño actual ') }}</label>
            </td>
            <td>
                <label>{{ __('Datastore') }}</label>
            </td>
            <td>
                <label>{{ __('Tamaño total disco duro') }}</label>
            </td>
            <td >
                <label>{{ __('Tamaño aprovisionar') }}</label>
            </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="hardDisk[]" id="Hard_disk_1" value="Hard disk 1"/>Hard disk 1
        </td>
        <td id="N_Hard_disk_1" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Hard_disk_1" name="tamanoctual" class="form-control input-md"  maxlength="40">
        </td>
        <td id="T_Hard_disk_1" style="color:red; font-weight: bold;">
            <input type="hidden" id="TI_Hard_disk_1" name="datastore" class="form-control input-md"  maxlength="40">
        </td>
        <td id="C_Hard_disk_1" style="color:red; font-weight: bold;">
            <input type="hidden" id="CI_Hard_disk_1" name="tamanomaxdts" class="form-control input-md"  maxlength="40">
        </td>
        <td>
            <input type="text" name="tamanoaprov" id="tamanoaprov" class="form-control input-md" value="{{ old('disknew') }}" maxlength=10" placeholder="Tamaño aprovisionar" >
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" class="chk-box" name="hardDisk[]" id="Hard_disk_2" value="Hard disk 2"/>Hard disk 2
        </td>
        <td id="N_Hard_disk_2" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Hard_disk_2" name="tamanoctual1" class="form-control input-md"  maxlength="40">
        </td>
        <td id="T_Hard_disk_2" style="color:red; font-weight: bold;">
            <input type="hidden" id="TI_Hard_disk_2" name="datastore1" class="form-control input-md"  maxlength="40">
        </td>
        <td id="C_Hard_disk_2" style="color:red; font-weight: bold;">
            <input type="hidden" id="CI_Hard_disk_2" name="tamanomaxdts1" class="form-control input-md"  maxlength="40">
        </td>
        <td>
            <input type="text" name="tamanoaprov1" id="tamanoaprov1" class="form-control input-md" value="{{ old('tamanoaprov') }}" maxlength="3" placeholder="Tamaño aprovisionar"  >
        </td>
    </tr>
	<tr>
        <td>
            <input type="checkbox" class="chk-box" name="hardDisk[]" id="Hard_disk_3" value="Hard disk 2"/>Hard disk 3
        </td>
        <td id="N_Hard_disk_3" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Hard_disk_3" name="tamanoctual2" class="form-control input-md"  maxlength="40">
        </td>
        <td id="T_Hard_disk_3" style="color:red; font-weight: bold;">
            <input type="hidden" id="TI_Hard_disk_3" name="datastore2" class="form-control input-md"  maxlength="40">
        </td>
        <td id="C_Hard_disk_3" style="color:red; font-weight: bold;">
            <input type="hidden" id="CI_Hard_disk_3" name="tamanomaxdts2" class="form-control input-md"  maxlength="40">
        </td>
        <td>
            <input type="text" name="tamanoaprov2" id="tamanoaprov2" class="form-control input-md" value="{{ old('tamanoaprov2') }}" maxlength="3" placeholder="Tamaño aprovisionar"  >
        </td>
    </tr>
	<tr>
        <td>
            <input type="checkbox" class="chk-box" name="hardDisk[]" id="Hard_disk_4" value="Hard disk 2"/>Hard disk 4
        </td>
        <td id="N_Hard_disk_4" style="color:red; font-weight: bold;">
            <input type="hidden" id="NI_Hard_disk_4" name="tamanoctual3" class="form-control input-md"  maxlength="40">
        </td>
        <td id="T_Hard_disk_4" style="color:red; font-weight: bold;">
            <input type="hidden" id="TI_Hard_disk_4" name="datastore3" class="form-control input-md"  maxlength="40">
        </td>
        <td id="C_Hard_disk_4" style="color:red; font-weight: bold;">
            <input type="hidden" id="CI_Hard_disk_4" name="tamanomaxdts3" class="form-control input-md"  maxlength="40">
        </td>
        <td>
            <input type="text" name="tamanoaprov3" id="tamanoaprov3" class="form-control input-md" value="{{ old('tamanoaprov3') }}" maxlength="3" placeholder="Tamaño aprovisionar"  >
        </td>
    </tr>
	




</table>
</div>
</div>
@endsection

