$( document ).ready(function() {
   $("#link_equipos").closest("ul").closest("li").attr('class', 'active');
   $("#link_equipos").closest("ul").fadeIn();
   $("#link_equipos").addClass("current-page"); 
});


function buscar_equipo_general(cod_scl){
    if(cod_scl == null){
        var pista = $("#Equipo_general_pista").val();
    }else{
        var pista = cod_scl;
    }
    if(pista == ""){
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe especificar una pista para buscar");
        remodal.open();
    }else{
        $.get('/buscar_equipo_general', {dato:pista}, function(data){
            limpiar_modal();
            if(cod_scl == null){
                //BORRAR DATOS DE SECCION EQUIPO ESPECIFICO
                $("#Equipo_especifico_pista").val("");
                $("#buscar_equipo_especifico").hide();
                $('#buscar_equipo_especifico .form :input').val("");
                $('#Equipo_IMEI_copia').text("");
                $('#Equipo_simcard').text("Simcard");
                $('#Equipo_simcard').attr("href","#");
                $('#simcard_container').attr("class","container");
                $('#Equipo_cliente').text("Cliente");
                $('#Equipo_cliente').attr("href","#");
            }
            
            //LIMPIAR LISTADO DE EQUIPOS
            $("#listado_equipos").html("");
            if(data != ''){
                $("#buscar_equipo_general").find(".text_container").show();
                $('#Equipo_cod_scl_copia').text(data.cod_scl);
                $('#Equipo_cod_scl').val(data.cod_scl);
                $('#Equipo_gama').text(data.gama);
                $('#Equipo_marca').val(data.marca);
                $('#Equipo_modelo').val(data.modelo);
                $('#Equipo_precio_prepago').val(data.precio_prepago);
                $('#Equipo_precio_postpago').val(data.precio_postpago);
                $('#Equipo_precio_3_cuotas').val(data.precio_3_cuotas);
                $('#Equipo_precio_6_cuotas').val(data.precio_6_cuotas);
                $('#Equipo_precio_9_cuotas').val(data.precio_9_cuotas);
                $('#Equipo_precio_12_cuotas').val(data.precio_12_cuotas);
                //LISTAR EQUIPOS ESPECIFICOS
                if(data.equipos != ""){
                    $("#listado_equipos_container").show();
                    $.each(data.equipos, function( index, equipo ) {
                        $("#listado_equipos").append('<button class="btn" id="' + equipo.IMEI + '" onClick="buscar_equipo_especifico(this.id)">' + equipo.IMEI + '</button>');       
                    });
                }else{
                    $("#listado_equipos_container").hide();
                }
            }else{
                $('#buscar_equipo_general .form :input').val("");
                $("#buscar_equipo_general").find(".text_container").hide();
                $('#Equipo_gama').text("Gama");
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Equipo no encontrado");
                remodal.open();
            }
        });
    }
}

function buscar_equipo_especifico(IMEI){
    if(IMEI == null){
        var pista = $("#Equipo_especifico_pista").val();
    }else{
        var pista = IMEI;
    }
    
    if(pista == ""){
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe especificar un IMEI para buscar");
        remodal.open();
    }else{
        $.get('/buscar_equipo_especifico', {dato:pista}, function(data){
            limpiar_modal();
            if(data != ''){
                $("#buscar_equipo_especifico").show();
                $("#buscar_equipo_general").show();
                $("#buscar_equipo_especifico").find(".text_container").show();
                $('#Equipo_IMEI_copia').text(data.IMEI);
                $('#Equipo_IMEI').val(data.IMEI);
                if(data.simcard != null){
                    $('#simcard_container').addClass(data.color);
                    $('#Equipo_simcard').text(data.simcard.numero_linea);
                    $('#Equipo_simcard').attr("href","/simcard?simcard=" + data.simcard.ICC);
                }else{
                    $('#Equipo_simcard').text("Simcard");
                    $('#Equipo_simcard').attr("href","#");
                    $('#simcard_container').attr("class","container");
                }
                if(data.Cliente_identificacion != null){
                    $('#Equipo_cliente').text(data.cliente.nombre);
                    $('#Equipo_cliente').attr("href","/cliente?cliente=" + data.cliente.identificacion);
                }else{
                    $('#Equipo_cliente').text("Cliente");
                    $('#Equipo_simcard').attr("href","#");
                }
                $('#Equipo_modelo').val(data.modelo);
                $('#Equipo_fecha_venta').val(data.fecha_venta);
                $('#Equipo_descripcion_precio').val(data.descripcion_precio);
                buscar_equipo_general(data.descripcion_equipo.cod_scl);
            }else{
                $("#Equipo_general_pista").val("");
                //BORRAR DATOS DE SECCION EQUIPO ESPECIFICO
                $("#buscar_equipo_general").hide();
                $('#buscar_equipo_especifico .form :input').val("");
                $('#Equipo_IMEI_copia').text("");
                $('#Equipo_simcard').text("Simcard");
                $('#Equipo_simcard').attr("href","#");
                $('#simcard_container').attr("class","container");
                $('#Equipo_cliente').text("Cliente");
                $('#Equipo_cliente').attr("href","#");
                $('#buscar_equipo_general .form :input').val("");
                $("#buscar_equipo_general").find(".text_container").hide();
                $('#Equipo_gama').text("Gama");
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Equipo no encontrado");
                remodal.open();
            }
        });
    }
}

function actualizar_descripcion_equipo(){
    var cod_scl = $("#Equipo_cod_scl_copia").text();
    if(cod_scl == ""){
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un equipo antes de actualizarlo");
        remodal.open();
    }else{
        var datos_descripcion_equipo = {};
        var inputs = $('#buscar_equipo_general .form :input');
        inputs.each(function() {
            datos_descripcion_equipo[this.id] = $(this).val();
        });
        datos_descripcion_equipo["cod_scl_copia"] = cod_scl;
        datos_descripcion_equipo["Equipo_gama"] = $("#Equipo_gama").text();
        $.get('/actualizar_equipo_general', {dato:datos_descripcion_equipo}, function(data){
            limpiar_modal();
            if(data == 'EXITOSO'){
                modal.addClass("modal_exito");
                $("#titulo_modal").text("EXITO!!");
                $("#contenido_modal").text("Descripcion de equipo actualizada satisfactoriamente");
                remodal.open();
            }else{
                buscar_equipo_general(cod_scl);
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text(data);
                remodal.open();
            }
        });
    }
}

function actualizar_equipo(){
    var IMEI = $("#Equipo_IMEI_copia").text();
    if(IMEI == ""){
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un equipo antes de actualizarlo");
        remodal.open();
    }else{
        var datos_equipo = {};
        var inputs = $('#buscar_equipo_especifico .form :input');
        inputs.each(function() {
            datos_equipo[this.id] = $(this).val();
        });
        datos_equipo["Equipo_IMEI_copia"] = IMEI;
        datos_equipo["Equipo_Simcard_ICC"] = $("#Equipo_Simcard_ICC").text();
        datos_equipo["Equipo_Cliente_identificacion"] = $("#Equipo_Cliente_identificacion").text();
        $.get('/actualizar_equipo_especifico', {dato:datos_equipo}, function(data){
            limpiar_modal();
            if(data == 'EXITOSO'){
                modal.addClass("modal_exito");
                $("#titulo_modal").text("EXITO!!");
                $("#contenido_modal").text("Descripcion de equipo actualizada satisfactoriamente");
                remodal.open();
            }else{
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text(data);
                remodal.open();
            }
        });
    }
}