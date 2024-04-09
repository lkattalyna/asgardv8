@section('plugins.Select2', true)
<script>
$(document).ready(function() {

    $(".select2").select2({
        placeholder: "--Seleccione--",
        allowClear: true
    });

    $('#id_menu_father').select2({
        placeholder: "--Seleccione--",
        allowClear: true
    });

    $('#id_permission').select2({
        placeholder: "--Seleccione--",
        allowClear: true
    });



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


</script>
