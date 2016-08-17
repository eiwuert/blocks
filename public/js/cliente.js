$( document ).ready(function() {
   $("#link_clientes").closest("ul").closest("li").attr('class', 'active');
   $("#link_clientes").closest("ul").fadeIn();
   $("#link_clientes").addClass("current-page"); 
});

function cambiar_tipo(tipo){
    $("#Cliente_tipo").text(tipo);
    remodal.close();
}
function seleccionar_tipo(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("SELECCIONAR TIPO CLIENTE");
    $("#contenido_modal").text("");
    $("#tipos_cliente").show();
    remodal.open();
}

function buscar_cliente(cliente){
    if(cliente == null){
        var pista = $("#Cliente_pista").val();
    }else{
        var pista = cliente;
    }
    if(pista == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe especificar una pista para buscar");
        remodal.open();
    }else{
        $.get('/buscar_cliente', {dato:pista}, function(data){
            limpiar_modal();
            if(data != ''){
                $("#buscar_cliente").find(".text_container").show();
                $('#Cliente_identificacion').val(data.identificacion);
                $('#Cliente_identificacion_copia').text(data.identificacion);
                $('#Cliente_tipo').text(data.tipo);
                $('#Cliente_nombre').val(data.nombre);
                $('#Cliente_telefono').val(data.telefono);
                $('#Cliente_correo').val(data.correo);
                $('#Cliente_direccion').val(data.direccion);
                if(data.ubicacion != null){
                    $("#region").text(data.ubicacion.region);
                    $("#ciudad").text(data.ubicacion.ciudad);
                }else{
                    $("#region").text("Región");
                    $("#ciudad").text("Ciudad");
                }
                if(data.tipo == "NATURAL"){
                    $('#Cliente_identificacion_lbl').text("CC");
                    $("#buscar_responsable").hide();
                    //BORRAR DATOS DE RESPONSABLE
                    $("#buscar_responsable").find(".text_container").hide();
                    //BORRAR DATOS DE RESPONSABLE   
                    $('#Responsable_cedula').val("");
                    $('#Responsable_cedula_copia').val("");
                    $('#Responsable_tipo').text("Tipo");
                    $('#Responsable_nombre').val("");
                    $('#Responsable_telefono').val("");
                    $('#Responsable_correo').val("");
                    //
                }else{
                    $('#Cliente_identificacion_lbl').text("NIT");
                    $("#region").text("Región");
                    $("#ciudad").text("Ciudad");
                    if(data.responsable != null){
                        $("#buscar_responsable").show();
                        $("#buscar_responsable").find(".text_container").show();
                        $('#Responsable_cedula').val(data.responsable.cedula);
                        $('#Responsable_cedula_copia').val(data.responsable.cedula);
                        $('#Responsable_nombre').val(data.responsable.nombre);
                        $('#Responsable_telefono').val(data.responsable.telefono);
                        $('#Responsable_correo').val(data.responsable.correo);
                    }else{
                        $("#buscar_responsable").hide();
                    }
                }
                //LISTAR SIMCARDS CLIENTE    
                if(data.simcards != ""){
                    $("#listado_simcards").show();
                    $("#listado_simcards>div").html("");
                    $.each(data.simcards, function( index, simcard ) { 
                        $("#listado_simcards>div").append('<a href="/simcard?simcard='+ simcard.ICC +'" style="margin:5px;flex-grow:2" class="btn ' + simcard.color + '">' + simcard.numero_linea + '</a>');  
                    });
                }else{
                    $("#listado_simcards>div").html("");
                    $("#listado_simcards").hide();
                }
                
                //LISTAR EQUIPOS CLIENTE    
                if(data.equipos != ""){
                    $("#listado_equipos").show();
                    $("#listado_equipos>div").html("");
                    $.each(data.equipos, function( index, equipo ) { 
                        $("#listado_equipos>div").append('<a href="/equipo?equipo='+ equipo.IMEI +'" style="margin:5px" class="btn azul">' + equipo.IMEI + '</a>');  
                    });
                }else{
                    $("#listado_equipos>div").html("");
                    $("#listado_equipos").hide();
                }
            }else{
                $("#buscar_responsable").hide();
                $("#listado_simcards").hide();
                $("#listado_simcards>div").html("");
                $("#buscar_cliente").find(".text_container").hide();
                //BORRAR DATOS DE SECCION CLIENTE
                $('#buscar_cliente .form :input').val("");
                $('#Cliente_identificacion_copia').text("");
                $('#Cliente_tipo').text("Tipo");
                
                //BORRAR DATOS DE RESPONSABLE
                $("#buscar_responsable").find(".text_container").hide();
                //BORRAR DATOS DE RESPONSABLE   
                $('#buscar_responsable .form :input').val("");
                //MODAL INFORMANDO ERROR
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Cliente no encontrado");
                remodal.open();
            }
        });
    }
}

function crear_cliente(){
    var datos_cliente = {};
    var inputs = $('#buscar_cliente .form :input');
    if($("#Cliente_identificacion").val() == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe especificar una identificación al cliente");
        remodal.open();
    }else{
        var tipo_cliente = $("#Cliente_tipo").text();
        if(tipo_cliente == "Tipo"){
            limpiar_modal();
            modal.addClass("modal_error");
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text("Debe especificar un tipo de cliente");
            remodal.open();
        }else{
            inputs.each(function() {
                datos_cliente[this.id] = $(this).val();
            }); 
            datos_cliente["Cliente_region"] = $("#region").text();
            datos_cliente["Cliente_ciudad"] = $("#ciudad").text();
            datos_cliente["Cliente_tipo"] = tipo_cliente;
            $.get('/crear_cliente', {dato:datos_cliente}, function(data){
               limpiar_modal();
               if(data == "EXITOSO"){
                    modal.addClass("modal_exito");
                    $("#titulo_modal").text("EXITO!!");
                    $("#contenido_modal").text("Cliente creado satisfactoriamente");
               } else{
                    modal.addClass("modal_error");
                    $("#titulo_modal").text("ERROR!!");
                    $("#contenido_modal").text(data);
               }
               remodal.open();         
            });
        }
    }
}

function actualizar_cliente(){
    var datos_cliente = {};
    var inputs = $('#buscar_cliente .form :input');
    if($("#Cliente_identificacion_copia").text() == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un cliente antes de actualizarlo");
        remodal.open();
    }else{
        datos_cliente["identificacion_copia"] = $("#Cliente_identificacion_copia").text();
        if($("#Cliente_identificacion").val() == ""){
            limpiar_modal();
            modal.addClass("modal_error");
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text("Debe especificar una identificación al cliente");
            remodal.open();
        }else{
            var tipo_cliente = $("#Cliente_tipo").text();
            if(tipo_cliente == "Tipo"){
                limpiar_modal();
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Debe especificar un tipo de cliente");
                remodal.open();
            }else{
                inputs.each(function() {
                    datos_cliente[this.id] = $(this).val();
                }); 
                datos_cliente["Cliente_region"] = $("#region").text();
                datos_cliente["Cliente_ciudad"] = $("#ciudad").text();
                datos_cliente["Cliente_tipo"] = tipo_cliente;
                $.get('/actualizar_cliente', {dato:datos_cliente}, function(data){
                   limpiar_modal();
                   if(data == "EXITOSO"){
                        modal.addClass("modal_exito");
                        $("#titulo_modal").text("EXITO!!");
                        $("#contenido_modal").text("Cliente actualizado satisfactoriamente");
                   } else{
                        modal.addClass("modal_error");
                        $("#titulo_modal").text("ERROR!!");
                        $("#contenido_modal").text(data);
                   }
                   remodal.open();         
                });
            }
        }
    }
}

function eliminar_cliente(){
    var datos_cliente = {};
    var inputs = $('#buscar_cliente .form :input');
    var identificacion = $("#Cliente_identificacion_copia").text();
    if(identificacion == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un cliente antes de eliminarlo");
        remodal.open(); 
    }else{
        $.confirm({
            text: "¿Está seguro que quiere eliminar el cliente?",
            confirm: function() {
                $.get('/eliminar_cliente', {dato:identificacion}, function(data){
                    limpiar_modal();
                    if(data == "EXITOSO"){
                        $("#buscar_responsable").hide();
                        $("#listado_simcards").hide();
                        $("#listado_simcards>div").html("");
                        $("#buscar_cliente").find(".text_container").hide();
                        //BORRAR DATOS DE SECCION CLIENTE
                        $("#Cliente_pista").val("");
                        $('#buscar_cliente .form :input').val("");
                        $('#Cliente_identificacion_copia').text("");
                        $('#Cliente_tipo').text("Tipo");
                        //BORRAR DATOS DE RESPONSABLE
                        $("#buscar_responsable").find(".text_container").hide();
                        $('#buscar_responsable .form :input').val("");
                        //MODAL INFORMANDO EXITO
                        modal.addClass("modal_exito");
                        $("#titulo_modal").text("EXITO!!");
                        $("#contenido_modal").text("Cliente eliminado satisfactoriamente");
                    } else{
                        modal.addClass("modal_error");
                        $("#titulo_modal").text("ERROR!!");
                        $("#contenido_modal").text(data);
                    }
                    remodal.open();         
                });
            }
        });
    }
}

function actualizar_responsable(){
    var datos_responsable = {};
    var Cliente_identificacion = $("#Cliente_identificacion_copia").text();
    if(Cliente_identificacion == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un cliente antes de actualizar el responsable");
        remodal.open(); 
    }else{
        var inputs = $('#buscar_responsable .form :input');
        inputs.each(function() {
            datos_responsable[this.id] = $(this).val();
        }); 
        datos_responsable["Cliente_identificacion"] = Cliente_identificacion;
        $.get('/actualizar_responsable', {dato:datos_responsable}, function(data){
            limpiar_modal();
            if(data == "EXITOSO"){
                //MODAL INFORMANDO EXITO
                modal.addClass("modal_exito");
                $("#titulo_modal").text("EXITO!!");
                $("#contenido_modal").text("Responsable actualizado satisfactoriamente");
            } else{
                modal.addClass("modal_error");
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text(data);
            }
            remodal.open();       
        });
    }
}

function eliminar_responsable(){
    var Responsable_cedula = $("#Responsable_cedula_copia").val();
    if(Responsable_cedula == ""){
        limpiar_modal();
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un cliente antes de eliminar el responsable");
        remodal.open(); 
    }else{
        $.confirm({
            text: "¿Está seguro que quiere eliminar el responsable?",
            confirm: function() {
                $.get('/eliminar_responsable', {dato:Responsable_cedula}, function(data){
                    limpiar_modal();
                    if(data == "EXITOSO"){
                        //MODAL INFORMANDO EXITO
                        modal.addClass("modal_exito");
                        $("#titulo_modal").text("EXITO!!");
                        $("#contenido_modal").text("Responsable eliminado satisfactoriamente");
                        //BORRAR DATOS RESPONSABLE
                        $("#buscar_responsable").find(".text_container").hide();
                        $('#buscar_responsable .form :input').val("");
                    } else{
                        modal.addClass("modal_error");
                        $("#titulo_modal").text("ERROR!!");
                        $("#contenido_modal").text(data);
                    }
                    remodal.open();       
                });
            }
        });
    }
}