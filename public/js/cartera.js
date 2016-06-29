$( document ).ready(function() {
   $("#link_cartera").closest("ul").closest("li").attr('class', 'active');
   $("#link_cartera").closest("ul").fadeIn();
   $("#link_cartera").addClass("current-page"); 
});

function buscar_cartera_empleado(nombre){
    if(nombre != null){
        var nombre = nombre;
    }else{
        var nombre = $('[data-id="subPicker_cedula"]').text();
    }
    
    $.ajax({
        url:'/buscar_cartera',
        data:{nombre:nombre},
        type:'get',
        success: function(data){
            $("#nombre_copia").text(nombre);
            var html = "";
            var saldo = 0;
            for(var i = 0; i < data.length; i++){
                saldo += (data[i].cantidad*data[i].valor_unitario);
                if(data[i].valor_unitario < 0){
                    html += '<tr class="rojo_claro" id="' + data[i].ID +'" onClick="obtener_registro(this.id)">';
                }else{
                    html += '<tr class="verde_claro" id="' + data[i].ID +'"onClick="obtener_registro(this.id)">';
                }
                html += '<td>' + data[i].fecha + '</td>';
                html += '<td>' + data[i].descripcion + '</td>';
                html += '<td class="no_visibile_mobile">' + data[i].cantidad + '</td>';
                
                if(data[i].valor_unitario < 0){
                    html += '<td class="no_visibile_mobile">' + (data[i].valor_unitario*(-1)) + '</td>';
                    html += '<td>' + (data[i].cantidad*data[i].valor_unitario*(-1)) + '</td>';
                }else{
                    html += '<td class="no_visibile_mobile">' + data[i].valor_unitario + '</td>';
                    html += '<td>' + (data[i].cantidad*data[i].valor_unitario) + '</td>';
                }
                html += '</tr>';
            }
            $('#cuerpo_cartera').html(html);
            if(data.length > 0){
                $("#saldo_container").show();
                if(saldo < 0){
                    saldo = saldo*(-1);
                    $("#saldo").attr("style","color:#DB5466");
                }else{
                    $("#saldo").attr("style","color:#7FCA9F");
                }
                $("#saldo").text("$" +saldo);
            }else{
                $("#saldo_container").hide();
            }
            // REVISAR SI SOY YO
            if($("#nombre_copia").text().trim() == $("#user_nombre").text().trim()){
                $("#boton_crear_registro").prop("disabled",true);
                $("#cuerpo_cartera").find("tr").attr("onClick","");
            }else{
                $("#boton_crear_registro").prop("disabled",false);
            }
            
            $('html, body').animate({
                scrollTop: $("#saldo_container").offset().top
            }, 2000);
        }
    });
}
function eliminar_registro(){
    remodal.close();
    $.confirm({
        text: "¿Estás seguro que quieres eliminar el registro?",
        confirm: function() {
            $.ajax({
                url:'/eliminar_registro',
                data:{ID:$("#ID_copia").text()},
                type:'get',
                success: function(data){
                    limpiar_modal();
                    $("#titulo_modal").text("EXITO!!");
                    modal.addClass("modal_exito");
                    $("#contenido_modal").text("Registro eliminado satisfactoriamente");
                    remodal.open();
                    buscar_cartera_empleado($("#nombre_copia").text());
                }
            });
        }
    });
}

function obtener_registro(id){
    $.ajax({
        url:'/obtener_registro_cartera',
        data:{ID:id},
        type:'get',
        success: function(data){
            $("#ID_copia").text(data["ID"]);
            limpiar_modal();
            modal.addClass("modal_info");
            $("#contenedor_registro_cartera").find(".text_container").show();
            $("#contenedor_registro_cartera").show();
            $("#Registro_fecha").val(data["fecha"]);
            $("#Registro_descripcion").val(data["descripcion"]);
            $("#Registro_cantidad").val(data["cantidad"]);
            $("#Registro_valor_unitario").val(data["valor_unitario"]);
            $("#titulo_modal").text("MODIFICAR REGISTRO");
            $("#botones_actualizar").show();
            $("#botones_crear").hide();
            $("#contenido_modal").text('Modifica los valores y oprime "Guardar" o elimina el registro oprimiendo "Eliminar"');
            remodal.open();
        }
    });
}

function crear_registro(){
    if($("#nombre_copia").text() == ""){
        limpiar_modal();
        $("#titulo_modal").text("ERROR!!");
        modal.addClass("modal_error");
        $("#contenido_modal").text("Debes buscar la cartera de un empleado primero");
        remodal.open();
    }else{
        $("#ID_copia").text("");
        limpiar_modal();
        modal.addClass("modal_info");
        $("#contenedor_registro_cartera").find(".text_container").hide();
        $("#contenedor_registro_cartera").find("input").val("");
        $("#contenedor_registro_cartera").show();
        $("#botones_actualizar").hide();
        $("#botones_crear").show();
        $("#titulo_modal").text("AGREGAR REGISTRO");
        $("#contenido_modal").text('Para agregar un registro a ' + $("#nombre_copia").text() + 'modifica los valores y oprime "Guardar".');
        remodal.open();
    }
}
function guardar_registro(){
    var inputs = $('#buscar_cartera .form :input');
    var vacio = false;
    var datos_registro = {};
    inputs.each(function() {
        if($(this).val() == ""){
            vacio = true;
        }
        datos_registro[this.id] = $(this).val();
    });
    if(vacio){
        limpiar_modal();
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debes llenar todos los datos");
        remodal.open();
    }else{
        datos_registro["Actor_nombre"] = $("#nombre_copia").text();
        $.ajax({
        url:'/crear_registro',
        data:{datos_registro:datos_registro},
        type:'get',
        success: function(data){
            if(data == "EXITOSO"){
                limpiar_modal();
                $("#titulo_modal").text("EXITO!!");
                modal.addClass("modal_exito");
                $("#contenido_modal").text("Registro creado satisfactoriamente");
                remodal.open();
                buscar_cartera_empleado($("#nombre_copia").text());
            }else{
                limpiar_modal();
                $("#titulo_modal").text("ERROR!!");
                modal.addClass("modal_error");
                $("#contenido_modal").text(data);
                remodal.open();
            }
        }
    });
    }
}

function actualizar_registro(){
    var inputs = $('#buscar_cartera .form :input');
    var vacio = false;
    var datos_registro = {};
    inputs.each(function() {
        if($(this).val() == ""){
            vacio = true;
        }
        datos_registro[this.id] = $(this).val();
    });
    if(vacio){
        limpiar_modal();
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debes llenar todos los datos");
        remodal.open();
    }else{
        datos_registro["ID"] = $("#ID_copia").text();
        $.ajax({
        url:'/actualizar_registro',
        data:{datos_registro:datos_registro},
        type:'get',
        success: function(data){
            if(data == "EXITOSO"){
                limpiar_modal();
                $("#titulo_modal").text("EXITO!!");
                modal.addClass("modal_exito");
                $("#contenido_modal").text("Registro actualizado satisfactoriamente");
                remodal.open();
                buscar_cartera_empleado($("#nombre_copia").text());
            }else{
                limpiar_modal();
                $("#titulo_modal").text("ERROR!!");
                modal.addClass("modal_error");
                $("#contenido_modal").text(data);
                remodal.open();
            }
        }
    });
    }
}