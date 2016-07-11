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
        limpiar_modal();
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
                $("#equipo_chevron").addClass("fa-chevron-down");
                $("#equipo_chevron").removeClass("fa-chevron-up");
                $('#buscar_equipo_especifico .form :input').val("");
                $('#Equipo_IMEI_copia').text("");
                $('#Equipo_simcard').text("Simcard");
                $('#Equipo_simcard').attr("href","#");
                $('#simcard_container').attr("class","container");
                $('#Equipo_cliente').text("Cliente");
                $('#Equipo_cliente').attr("href","#");
                $("#acciones_equipo_especifico").hide();
            }
            
            //LIMPIAR LISTADO DE EQUIPOS
            $("#listado_equipos").html("");
            if(data != ''){
                $("#buscar_equipo_general").find(".text_container").show();
                $('#Equipo_cod_scl_copia').text(data.cod_scl);
                $('#Equipo_cod_scl').val(data.cod_scl);
                $('#Equipo_tecnologia').val(data.tecnologia);
                $('#Equipo_modelo').val(data.modelo);
                if(data.precio_prepago != 0){
                    $('#Equipo_precio_prepago').val(accounting.formatMoney(data.precio_prepago,"$",0));
                }else{
                    $('#Equipo_precio_prepago').val("ND");
                }
                if(data.precio_contado != 0){
                    $('#Equipo_precio_contado').val(accounting.formatMoney(data.precio_contado,"$",0));
                }else{
                    $('#Equipo_precio_contado').val("ND");
                }
                if(data.precio_3_cuotas != 0){
                    $('#Equipo_precio_3_cuotas').val(accounting.formatMoney(data.precio_3_cuotas,"$",0));
                }else{
                    $('#Equipo_precio_3_cuotas').val("ND");
                }
                if(data.precio_6_cuotas != 0){
                    $('#Equipo_precio_6_cuotas').val(accounting.formatMoney(data.precio_6_cuotas,"$",0));
                }else{
                    $('#Equipo_precio_6_cuotas').val("ND");
                }
                if(data.precio_12_cuotas != 0){
                    $('#Equipo_precio_12_cuotas').val(accounting.formatMoney(data.precio_12_cuotas,"$",0));
                }else{
                    $('#Equipo_precio_12_cuotas').val("ND");
                }
                if(data.precio_24_cuotas != 0){
                    $('#Equipo_precio_24_cuotas').val(accounting.formatMoney(data.precio_24_cuotas,"$",0));
                }else{
                    $('#Equipo_precio_24_cuotas').val("ND");
                }
                //LISTAR EQUIPOS ESPECIFICOS
                if(data.equipos != ""){
                    $("#listado_equipos_container").show();
                    $("#equipos_chevron").addClass("fa-chevron-up");
                    $("#equipos_chevron").removeClass("fa-chevron-down");
                    $.each(data.equipos, function( index, equipo ) {
                        $("#listado_equipos").append('<button class="btn" id="' + equipo.IMEI + '" onClick="buscar_equipo_especifico(this.id)">' + equipo.IMEI + '</button>');       
                    });
                }else{
                    $("#listado_equipos_container").hide();
                    $("#equipos_chevron").addClass("fa-chevron-down");
                    $("#equipos_chevron").removeClass("fa-chevron-up");
                }
            }else{
                $('#buscar_equipo_general .form :input').val("");
                $("#buscar_equipo_general").find(".text_container").hide();
                $('#Equipo_gama').val("");
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
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe especificar un IMEI para buscar");
        remodal.open();
    }else{
        $.get('/buscar_equipo_especifico', {dato:pista}, function(data){
            limpiar_modal();
            if(data != ''){
                $("#buscar_equipo_especifico").show();
                $("#equipo_chevron").addClass("fa-chevron-up");
                $("#equipo_chevron").removeClass("fa-chevron-down");
                $("#buscar_equipo_general").show();
                $("#equipos_chevron").addClass("fa-chevron-up");
                $("#equipos_chevron").removeClass("fa-chevron-down");
                $("#buscar_equipo_especifico").find(".text_container").show();
                $('#Equipo_IMEI_copia').text(data.IMEI);
                $('#Equipo_IMEI').val(data.IMEI);
                if(data.responsable != null){
                    $('#Equipo_responsable').val(data.responsable.nombre);
                }else{
                    $('#Equipo_responsable').val("Sin Responsable");
                }
                if(data.fecha_asignacion != null){
                    $('#Equipo_fecha_asignacion').val(data.fecha_asignacion);
                }else{
                    $('#Equipo_fecha_asignacion').val("No Asignada");
                }
                if(data.simcard != null){
                    $('#simcard_container').addClass(data.color);
                    $('#Equipo_simcard').text(data.simcard.numero_linea);
                    $('#Equipo_simcard').attr("href","/simcard?simcard=" + data.simcard.ICC);
                }else{
                    $('#Equipo_simcard').text("Sin Simcard");
                    $('#Equipo_simcard').attr("href","#");
                    $('#simcard_container').attr("class","container");
                }
                if(data.Cliente_identificacion != null){
                    $('#Equipo_cliente').text(data.cliente.nombre);
                    $('#Equipo_cliente').attr("href","/cliente?cliente=" + data.cliente.identificacion);
                }else{
                    $('#Equipo_cliente').text("Sin Cliente");
                    $('#Equipo_cliente').attr("href","#");
                }
                $('#Equipo_modelo').val(data.modelo);
                if(data.descripcion_precio != null){
                    $('#Equipo_descripcion_precio').val(data.descripcion_precio);
                }else{
                    $('#Equipo_descripcion_precio').val("NO VENDIDO");
                }
                buscar_equipo_general(data.descripcion_equipo.cod_scl);
                $("#acciones_equipo_especifico").show();
            }else{
                $("#Equipo_general_pista").val("");
                //BORRAR DATOS DE SECCION EQUIPO ESPECIFICO
                $('#buscar_equipo_especifico .form :input').val("");
                $('#Equipo_IMEI_copia').text("");
                $('#Equipo_simcard').text("Simcard");
                $('#Equipo_simcard').attr("href","#");
                $('#simcard_container').attr("class","container");
                $('#Equipo_cliente').text("Cliente");
                $('#Equipo_cliente').attr("href","#");
                $('#buscar_equipo_general .form :input').val("");
                $("#buscar_equipo_general").find(".text_container").hide();
                $('#Equipo_gama').val("");
                //LIMPIAR LISTADO DE EQUIPOS
                $("#listado_equipos").html("");
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Equipo no encontrado");
                remodal.open();
                $("#acciones_equipo_especifico").hide();
            }
        });
    }
}

function asignar_equipo(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("ASIGNAR RESPONSABLE");
    $("#responsables_equipo").show();
    remodal.open();    
}

function asignar_responsable_equipo(cedula){
    var datos_equipo = {};
    datos_equipo["imei"] = $("#Equipo_IMEI").val();
    datos_equipo["responsable"] = cedula;
    $.get('/asignar_responsable_equipo', {dato:datos_equipo}, function(resultado){
        if(resultado == "EXITOSO" ){
            remodal.close();
            buscar_equipo_especifico($("#Equipo_IMEI").val());
        }else{
            limpiar_modal();
            modal.addClass("modal_error");
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text(resultado);
            remodal.open();
        }
    }); 
}

function actualizar_descripcion_equipo(){
    var cod_scl = $("#Equipo_cod_scl_copia").text();
    if(cod_scl == ""){
        limpiar_modal();
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
        datos_descripcion_equipo["Equipo_gama"] = $("#Equipo_gama").val();
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
        limpiar_modal();
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

function eliminar_equipo(){
    var IMEI = $("#Equipo_IMEI_copia").text();
    if(IMEI == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un equipo antes de eliminarlo");
        remodal.open();
    }else{
        $.confirm({
            text: "¿Está seguro que quiere eliminar el equipo?",
            confirm: function() {
                $.get('/eliminar_equipo_especifico', {dato:IMEI}, function(data){
                    limpiar_modal();
                    if(data == 'EXITOSO'){
                        modal.addClass("modal_exito");
                        $("#titulo_modal").text("EXITO!!");
                        $("#contenido_modal").text("Equipo eliminado satisfactoriamente");
                        remodal.open();
                        //BORRAR DATOS DE SECCION EQUIPO ESPECIFICO
                        $("#Equipo_general_pista").val("");
                        $('#buscar_equipo_especifico .form :input').val("");
                        $('#Equipo_IMEI_copia').text("");
                        $('#Equipo_simcard').text("Simcard");
                        $('#Equipo_simcard').attr("href","#");
                        $('#simcard_container').attr("class","container");
                        $('#Equipo_cliente').text("Cliente");
                        $('#Equipo_cliente').attr("href","#");
                        $('#buscar_equipo_general .form :input').val("");
                        $("#buscar_equipo_general").find(".text_container").hide();
                        $('#Equipo_gama').val("");
                        $("#" + IMEI).remove();
                    }else{
                        //MODAL INFORMANDO ERROR
                        modal.addClass("modal_error");
                        $("#titulo_modal").text("ERROR!!");
                        $("#contenido_modal").text(data);
                        remodal.open();
                    }
                });
            }
        });
    }
}

function eliminar_descripcion_equipo(){
    var cod_scl = $("#Equipo_cod_scl_copia").text();
    if(cod_scl == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un equipo antes de eliminarlo");
        remodal.open();
    }else{
        $.confirm({
            text: "¿Está seguro que quiere eliminar el equipo?",
            confirm: function() {
                $.get('/eliminar_equipo_general', {dato:cod_scl}, function(data){
                    limpiar_modal();
                    if(data == 'EXITOSO'){
                        modal.addClass("modal_exito");
                        $("#titulo_modal").text("EXITO!!");
                        $("#contenido_modal").text("Equipo eliminado satisfactoriamente");
                        remodal.open();
                        //BORRAR DATOS DE SECCION EQUIPO ESPECIFICO
                        $("#Equipo_general_pista").val("");
                        $('#buscar_equipo_especifico .form :input').val("");
                        $('#Equipo_IMEI_copia').text("");
                        $('#Equipo_simcard').text("Simcard");
                        $('#Equipo_simcard').attr("href","#");
                        $('#simcard_container').attr("class","container");
                        $('#Equipo_cliente').text("Cliente");
                        $('#Equipo_cliente').attr("href","#");
                        $('#buscar_equipo_general .form :input').val("");
                        $("#buscar_equipo_general").find(".text_container").hide();
                        $('#Equipo_gama').val("");
                        $("#listado_equipos").html("");
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
        });
    }
}

function modal_cargar_descripcion_equipos(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("CARGAR ARCHIVO DE DESCRIPCION EQUIPOS");
    $("#contenido_modal").text('Selecciona el archivo y oprime "subir"');
    $("#cargar_descripcion_equipo_modal").show();  
    remodal.open();
}

function modal_cargar_equipos(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("CARGAR ARCHIVO DE EQUIPOS");
    $("#contenido_modal").text('Selecciona el archivo y oprime "subir"');
    $("#cargar_equipo_modal").show();  
    remodal.open();
}

$("#Equipo_general_pista").keyup(function (e) {
    if (e.keyCode == 13) {
        buscar_equipo_general();
    }
});