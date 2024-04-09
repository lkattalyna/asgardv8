@section('plugins.Select2', true)
<script>
    let mainWindows = @json($mainWindows);
    let mainUnix = @json($mainUnix);
    let firstTime = false;

$(document).ready(function() {
    $('#id_menu_father').select2({
        placeholder: "--Seleccione--",
        allowClear: true
    });

    $('#id_permission').select2({
        placeholder: "--Seleccione--",
        allowClear: true
    });


    $('#inventario').select2({
            placeholder: "--Seleccione--",
            allowClear: true
        });


        $('#grupo').select2({
            placeholder: "--Seleccione--",
            allowClear: true
        });


        $("#inventario").change(function(){
                let inventario = $(this).val();



        let parametros = {
            _token : $('meta[name="csrf-token"]').attr('content'),
            inventario

        };

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: "{{ route('global.get' ,[ 'automatizacion' => 'getGroups' ])}} ",
            type: 'post',
            data: parametros,
            success: function(data) {
                let select = "";
                for (var i=0; i<data.length;i++){
                        if(data[i]["name_group"] !== null){
                            if( firstTime ){                         
                                let seleccionado = "{{ isset($menuView) ? $menuView->grupo: '-n' }}";
                                select+=`<option value="${data[i]['id_group']}" ${ seleccionado == data[i]['id_group'] ? 'selected':'' }>${data[i]["id_group"]} - ${data[i]["name_group"]} </option>`;

                            }else{
                                select+='<option value="'+data[i]["id_group"]+'">'+data[i]["name_group"]+'</option>';
                            }
                        }
                }
                firstTime = false;
                $("#grupo").html(select);
            }
        });

        
          
        });
                        
        $("#inventario").trigger("change");        
})

    const menuFather = document.querySelector("#id_menu_father");
    const level = document.querySelector("#level");

    menuFather.addEventListener('change',() => {
        seleccionarNivel(menuFather.value);
    });

    $( document ).ready(function() {
        seleccionarNivel(menuFather.value);
    });

    function seleccionarNivel(menuPadre) {

        if( menuPadre == 0 ){
            $(level).val(1);
        }
        else{
            $(level).val(2);
        }
    }

    function cambiarAutos(selectSO){
        let value = selectSO.value;
        let selectAuto = document.querySelector("#automatizacion");
        let options = "";

        if( value == "unix"){
            options = preparar(mainUnix);
        }


        if( value == "windows"){
            options = preparar(mainWindows);
        }

        selectAuto.innerHTML = options;
        
    }

    function preparar(json) {

        let options="";
        for( let obj of json ){
            options+=`<option value="${obj.value}">${obj.tag}</option>`;
        }

        return options;
    }

</script>
