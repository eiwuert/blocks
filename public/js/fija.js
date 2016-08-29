$( document ).ready(function() {
   $("#link_fija").closest("ul").closest("li").attr('class', 'active');
   $("#link_fija").closest("ul").fadeIn();
   $("#link_fija").addClass("current-page"); 
});

function buscar_fija(peticion){
    if(peticion == null){
        var pista = $("#Fija_pista").val();
    }else{
        var pista = peticion;
    }
    if(pista == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe especificar una pista para buscar");
        remodal.open();
    }else{
        $.get('/buscar_fija', {dato:pista}, function(data){
            limpiar_modal();
            if(data != ''){
                $("#buscar_fija").find(".text_container").show();
                $('#Fija_peticion_copia').text(data.peticion);
                $('#Fija_responsable').text(data.Actor_cedula);
                $('#Fija_responsable').attr("href","/personal?cedula=" + data.Actor_cedula);
                $('#Fija_cliente').text(data.Cliente_identificacion);
                $('#Fija_cliente').attr("href","/cliente?cliente=" + data.cliente_identificacion);
                $('#Fija_tipo_producto').val(data.tipo_producto);
                $('#Fija_nombre_producto').val(data.nombre_producto);
                $("#contenedor_acciones").show();
            }else{
                $('#buscar_fija .form :input').val("");
                $("#buscar_fija").find(".text_container").hide();
                $('#Fija_peticion_copia').text("");
                $('#Fija_responsable').text("");
                $('#Fija_cliente').text("");
                $('#Fija_responsable').attr("href","");
                $('#Fija_cliente').attr("href","");
                $("#contenedor_acciones").hide();
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Petición no encontrada");
                remodal.open();
            }
        });
    }
}

function modal_cargar_fija(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("CARGAR ARCHIVO DE FIJA");
    $("#contenido_modal").text('Selecciona el archivo y oprime "subir"');
    $("#cargar_fija_modal").show();  
    remodal.open();
}