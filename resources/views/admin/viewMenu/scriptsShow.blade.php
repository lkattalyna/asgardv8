<script>
    let menusAdicionados = [
        [],
        []
    ];
    const formEmbeber = document.querySelector("#formEmbeber");

    formEmbeber.addEventListener('submit',(e) => {
        e.preventDefault();
        document.querySelector("#displayCheckBox").innerHTML = "";
        let html = `<input value="${menusAdicionados[0].join(";")}" name="menusAdicionados" />`;
        html+= `<input value="${menusAdicionados[1].join(";")}" name="menusAdicionadosTitulos" />`;
        document.querySelector("#displayCheckBox").innerHTML = html;
        formEmbeber.submit();
    });

    function adicionarMenuEmbebido(ref,titulo){
        let existe = menusAdicionados[0].includes(ref.value);

        if( existe ){
            menusAdicionados[0] = menusAdicionados[0].filter( m => m[0] != ref.value);
            menusAdicionados[1] = menusAdicionados[1].filter( m => m[1] != titulo);

        }else{
            menusAdicionados[0] = [...menusAdicionados[0], ref.value];
            menusAdicionados[1] = [...menusAdicionados[1], titulo];
        }

        if( menusAdicionados[0].length > 0){
            formEmbeber.classList.remove('d-none');
        }else{
            formEmbeber.classList.add('d-none');
        }
    }




</script>
