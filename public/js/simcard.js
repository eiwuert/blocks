function buscar_simcard(ICC){
    if(ICC == null){
        var pista = $("#Simcard_pista").val();
    }else{
        var pista = ICC;
    }
    $.get('/buscar_simcard', {dato:pista}, function(data){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        if(data != ''){
            $("#buscar_simcard").find(".text_container").show();
            $('#Simcard_ICC').text(data.ICC);
            $('#Simcard_responsable').text(data.responsable_simcard);
            $('#Simcard_numero_linea').val(data.numero_linea);
            $('#Simcard_categoria').text(data.categoria);
            $('#Simcard_paquete').text(data.paquete);
            $('#Simcard_plan').text(data.plan);
            if(data.fecha_asignacion == null){
                $('#Simcard_fecha_asignacion').text("NO ASIGNADA");
            }else{
                $('#Simcard_fecha_asignacion').text(data.fecha_asignacion);
            }
            if(data.fecha_adjudicacion == null){
                $('#Simcard_fecha_adjudicacion').val("SIN ADJUDICAR");
            }else{
                $('#Simcard_fecha_adjudicacion').val(data.fecha_adjudicacion);
            }
            if(data.fecha_activacion == null){
                $('#Simcard_fecha_activacion').val("SIN ACTIVAR");
            }else{
                $('#Simcard_fecha_activacion').val(data.fecha_activacion);
            }
            $('#Simcard_fecha_vencimiento').val(data.fecha_vencimiento);
            $("#buscar_simcard").find(".container").attr('class', 'container');
            $("#buscar_simcard").find(".container").addClass(data.color);
            if(data.paquete != "SIN PAQUETE"){
                buscar_paquete(pista);
            }else{
                $("#simcards_paquete").html("");
                $("#numero_paquete").text("");
                $("#titulo_paquete").hide();
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();
                $("#responsables_simcards").hide();
                $("#acciones_buscar_paquete").hide();    
            }
            if(data.plan != "SIN PLAN"){
                buscar_plan(data.plan, data.color);
            }else{
                $("#Plan_codigo").val("");
                $("#Plan_minutos").val("");
                $("#Plan_datos").val("");
                $("#Plan_valor").val("");
                $("#Plan_codigo").closest("div").attr('class', 'container');
                $("#Plan_minutos").closest("div").attr('class', 'container');
                $("#Plan_datos").closest("div").attr('class', 'container');
                $("#Plan_valor").closest("div").attr('class', 'container');
            }
        }else{
            $("#buscar_simcard").find(".text_container").hide();
            $('#buscar_simcard form :input').val("");
            $('#Simcard_ICC').text("ICC");
            $('#Simcard_paquete').text("Paquete");
            $('#Simcard_responsable').text("Responsable");
            $('#Simcard_categoria').text("Categoría");
            $('#Simcard_plan').text("Plan");
            $("#buscar_simcard").find(".container").attr('class', 'container');
            modal.removeClass("modal_info");
            modal.removeClass("modal_exito");
            modal.addClass("modal_error");
            $("#responsables_simcards_crear_paquete").hide();
            $("#planes_simcard_buscar_simcard").hide();
            $("#responsables_simcards").hide();
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text("Simcard no encontrada");
            remodal.open();
        }
    });
}

function actualizar_simcard(){
    
    var inputs = $('#buscar_simcard form :input');
    var datos_simcard = {};
    datos_simcard["ICC"] = $('#Simcard_ICC').text();
    datos_simcard["plan"] = $("#Simcard_plan").text();
    if($('#Simcard_ICC').text() == "ICC"){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        modal.removeClass("modal_info");
        modal.removeClass("modal_exito");
        modal.addClass("modal_error");
        $("#responsables_simcards_crear_paquete").hide();
        $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Busque una simcard antes de actualizar");
        remodal.open();
    }else{
        inputs.each(function() {
            datos_simcard[this.id] = $(this).val();
        });
        $.get('/actualizar_simcard', {dato:datos_simcard}, function(resultado){
            var modal = $('[data-remodal-id=modal]');
            var remodal = modal.remodal();
            if(resultado == "EXITOSO" ){
                modal.removeClass("modal_info");
                modal.removeClass("modal_error");
                modal.addClass("modal_exito");
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
                $("#titulo_modal").text("EXITO!!");
                $("#contenido_modal").text("Simcard actualizada satisfactoriamente");
                buscar_simcard($('#Simcard_ICC').text());
            }else{
                modal.removeClass("modal_info");
                modal.removeClass("modal_exito");
                modal.addClass("modal_error");
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text(resultado);
            }
            remodal.open();
        }); 
    }
}

function eliminar_simcard(){
    var ICC = $('#Simcard_ICC').text();
    if(ICC == "ICC"){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        modal.removeClass("modal_info");
        modal.removeClass("modal_exito");
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#responsables_simcards_crear_paquete").hide();
        $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
        $("#contenido_modal").text("Busque una simcard antes de eliminar");  
        remodal.open();
    }else{
        $.get('/eliminar_simcard', {dato:ICC}, function(resultado){
            var modal = $('[data-remodal-id=modal]');
            var remodal = modal.remodal();
            if(resultado == "EXITOSO" ){
                $("#buscar_simcard").find(".text_container").hide();
                $('#buscar_simcard form :input').val("");
                $('#Simcard_ICC').text("ICC");
                $('#Simcard_responsable').text("Responsable");
                $('#Simcard_categoria').text("Categoría");
                $("#buscar_simcard").find(".container").attr('class', 'container');
                modal.removeClass("modal_info");
                modal.removeClass("modal_error");
                modal.addClass("modal_exito");
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
                $("#titulo_modal").text("EXITO!!");
                $("#contenido_modal").text("Simcard eliminada satisfactoriamente");
                $("#Simcard_pista").val("");
            }else{
                modal.removeClass("modal_info");
                modal.removeClass("modal_exito");
                modal.addClass("modal_error");
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Ocurrió un error");
            }
            remodal.open();
        }); 
    }
}

function seleccionar_responsable_paquete(){
    var element = $('#buscar_paquete div.responsables_simcard');
    var modal = $('[data-remodal-id=modal]');
    var remodal = modal.remodal();
    if($("#numero_paquete").text() == ""){
        modal.removeClass("modal_exito");
        modal.removeClass("modal_info");
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#responsables_simcards_crear_paquete").hide();
        $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
        $("#contenido_modal").text("Debe buscar un paquete primero");
    }else{
        modal.removeClass("modal_exito");
        modal.removeClass("modal_error");
        modal.addClass("modal_info");
        $("#titulo_modal").text("ASIGNAR RESPONSABLE");
        $("#contenido_modal").text("");
        $("#responsables_simcards_crear_paquete").hide();
        $("#responsables_simcards").show();
    }
    remodal.open();
}

function asignar_responsable_paquete(id){
    var paquete = $("#numero_paquete").text();
    if(paquete == ""){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        modal.removeClass("modal_info");
        modal.removeClass("modal_exito");
        modal.addClass("modal_error");
        $("#responsables_simcards_crear_paquete").hide();
        $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un paquete primero");
        remodal.open();
    }else{
        var datos_simcard = {};
        datos_simcard["paquete"] = paquete;
        datos_simcard["responsable_paquete"] = id;
        $.get('/asignar_responsable_paquete', {dato:datos_simcard}, function(resultado){
            var modal = $('[data-remodal-id=modal]');
            var remodal = modal.remodal();
            if(resultado == "EXITOSO" ){
                $("#buscar_paquete").find(".text_container").hide();
                $('#buscar_paquete form :input').val("");
                $('#Simcard_ICC').text("ICC");
                $('#Simcard_paquete').text("Paquete");
                $('#Simcard_plan').text("Plan");
                $('#Simcard_responsable').text("Responsable");
                $('#Simcard_fecha_asignacion').text("Asignación");
                $('#Simcard_categoria').text("Categoría");
                $('#buscar_simcard form :input').val("");
                $("#buscar_paquete").find(".container").attr('class', 'container');
                $("#buscar_simcard").find(".container").attr('class', 'container');
                modal.removeClass("modal_info");
                modal.removeClass("modal_error");
                modal.addClass("modal_exito");
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();
                $("#responsables_simcards").hide();
                $("#titulo_modal").text("EXITO!!");
                $("#contenido_modal").text("Paquete asignado satisfactoriamente");
                $("#Simcard_pista").val("");
                $("#Plan_codigo").val("");
                $("#Plan_minutos").val("");
                $("#Plan_datos").val("");
                $("#Plan_valor").val("");
                $("#Plan_codigo").closest("div").attr('class', 'container');
                $("#Plan_minutos").closest("div").attr('class', 'container');
                $("#Plan_datos").closest("div").attr('class', 'container');
                $("#Plan_valor").closest("div").attr('class', 'container');
            }else{
                modal.removeClass("modal_info");
                modal.removeClass("modal_exito");
                modal.addClass("modal_error");
                $("#responsables_simcards_crear_paquete").hide();
                $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Ocurrió un error");
            }
            remodal.open();
        }); 
    }
}

function buscar_paquete(paquete){
    if(paquete == null){
        var pista = $("#Paquete_pista").val();
    }else{
        var pista = paquete;
    }
    $.get('/buscar_paquete', {dato:pista}, function(data){
        if(data != ''){
            var contenedor = $("#simcards_paquete");
            var simcards = "";
            data.forEach(function( simcard ) {
                $("#numero_paquete").text(simcard["Paquete_ID"]);
                simcards += '<button style="color:white" class="btn ' + simcard["color"] + '" onClick=buscar_simcard("' + simcard["ICC"] + '")>' + simcard["numero_linea"] + '</button>';
            });
            contenedor.html(simcards);
            $("#titulo_paquete").fadeIn();
            $("#acciones_buscar_paquete").fadeIn();
            if($("#Simcard_ICC").text() != pista && $("#Simcard_numero_linea").val() != pista){
                buscar_simcard(pista);
            }
        }else{
            var modal = $('[data-remodal-id=modal]');
            var remodal = modal.remodal();
            modal.removeClass("modal_info");
            modal.removeClass("modal_exito");
            modal.addClass("modal_error");
            remodal.open();
            $("#simcards_paquete").html("");
            $("#numero_paquete").text("");
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text("Paquete no encontrado");
            $("#titulo_paquete").hide();
            $("#responsables_simcards_crear_paquete").hide();
            $("#planes_simcard_buscar_simcard").hide();
            $("#responsables_simcards").hide();
            $("#acciones_buscar_paquete").hide();
        }
    });
}

function empaquetar_simcard(){
    var pista = $("#Paquete_pista").val();
    var paquete = $("#numero_paquete").text();
    if(paquete == ""){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        modal.removeClass("modal_info");
        modal.removeClass("modal_exito");
        modal.addClass("modal_error");
        $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
        $("#responsables_simcards_crear_paquete").hide();
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe buscar un paquete primero");
        remodal.open(); 
    }else{
        var datos_simcard = {};
        datos_simcard["pista"] = pista;
        datos_simcard["numero_paquete"] = paquete;
        $.get('/empaquetar_simcard', {dato:datos_simcard}, function(data){
            if(data == "EXITOSO"){
                buscar_paquete(pista);
                $("#Paquete_pista").val("");
            }else{
                var modal = $('[data-remodal-id=modal]');
                var remodal = modal.remodal();
                modal.removeClass("modal_info");
                modal.removeClass("modal_exito");
                modal.addClass("modal_error");
                $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
                $("#responsables_simcards_crear_paquete").hide();
                $("#titulo_modal").text("ERROR!!");
                $("#contenido_modal").text("Simcard no encontrada");
                remodal.open();
            }
        });
    }
}
    
function boton_crear_paquete(){
    var modal = $('[data-remodal-id=modal]');
    var remodal = modal.remodal();
    if($("#Paquete_pista").val() == ""){
        modal.removeClass("modal_info");
        modal.removeClass("modal_exito");
        modal.addClass("modal_error");
        $("#planes_simcard_buscar_simcard").hide();
        $("#responsables_simcards").hide();
        $("#responsables_simcards_crear_paquete").hide();
        $("#titulo_modal").text("ERROR!!");
        $("#contenido_modal").text("Debe escrbir el numero de linea o ICC de la primera simcard del paquete");
    }else{
        modal.removeClass("modal_exito");
        modal.removeClass("modal_error");
        modal.addClass("modal_info");
        $("#planes_simcard_buscar_simcard").hide();
        $("#responsables_simcards").hide();
        $("#responsables_simcards_crear_paquete").show();
        $("#titulo_modal").text("ASIGNAR RESPONSABLE");
        $("#contenido_modal").text("");
    }
    remodal.open();
}
    
function crear_paquete(cedula){
    var datos_simcard = {};
    datos_simcard["pista"] = $("#Paquete_pista").val();
    datos_simcard["responsable"] = cedula;
    $.get('/crear_paquete', {dato:datos_simcard}, function(data){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        if(data == "EXITOSO"){
            buscar_paquete($("#Paquete_pista").val());
            buscar_simcard($("#Paquete_pista").val());
            $("#Paquete_pista").val("");
            remodal.close();
        }else{
            modal.removeClass("modal_info");
            modal.removeClass("modal_exito");
            modal.addClass("modal_error");
            $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
            $("#responsables_simcards_crear_paquete").hide();
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text(data);
            remodal.open();
        }
    });
}

function eliminar_paquete(){
    var paquete = $("#numero_paquete").text();
    if(paquete == ""){
        modal.removeClass("modal_exito");
        modal.removeClass("modal_info");
        modal.addClass("modal_error");
        $("#titulo_modal").text("ERROR!!");
        $("#responsables_simcards_crear_paquete").hide();
        $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
        $("#contenido_modal").text("Debe buscar un paquete primero");
    }else{
        $.get('/eliminar_paquete', {dato:paquete}, function(data){
        var modal = $('[data-remodal-id=modal]');
        var remodal = modal.remodal();
        if(data == "EXITOSO"){
            $("#Paquete_pista").val("");
            $("#simcards_paquete").html("");
            modal.removeClass("modal_info");
            modal.addClass("modal_exito");
            modal.removeClass("modal_error");
            $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
            $("#responsables_simcards_crear_paquete").hide();
            $("#titulo_modal").text("EXITO!!");
            $("#contenido_modal").text("Paquete eliminado satisfactoriamente");
            remodal.open();
        }else{
            modal.removeClass("modal_info");
            modal.removeClass("modal_exito");
            modal.addClass("modal_error");
            $("#planes_simcard_buscar_simcard").hide();$("#responsables_simcards").hide();
            $("#responsables_simcards_crear_paquete").hide();
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text(data);
            remodal.open();
        }
    });
    }
}

function buscar_plan(codigo_plan,color){
    var codigo;
    if(codigo_plan != null){
        codigo = codigo_plan;
    }else{
        codigo = $("#codigo_plan").val();
    }
    $.get('/buscar_plan', {dato:codigo}, function(data){
        $("#Plan_codigo").closest("div").attr('class', 'container');
        $("#Plan_minutos").closest("div").attr('class', 'container');
        $("#Plan_datos").closest("div").attr('class', 'container');
        $("#Plan_valor").closest("div").attr('class', 'container');
        if(data != ""){
            $("#Plan_codigo").val(codigo);
            $("#Plan_minutos").val(data.cantidad_minutos);
            $("#Plan_datos").val(data.cantidad_datos);
            $("#Plan_valor").val(data.valor);
            if(color != null){
                $("#Plan_codigo").closest("div").addClass(color);
                $("#Plan_minutos").closest("div").addClass(color);
                $("#Plan_datos").closest("div").addClass(color);
                $("#Plan_valor").closest("div").addClass(color);
            }
        }else{
            $("#Plan_codigo").val("");
            $("#Plan_minutos").val("");
            $("#Plan_datos").val("");
            $("#Plan_valor").val("");
            var modal = $('[data-remodal-id=modal]');
            var remodal = modal.remodal();
            modal.removeClass("modal_info");
            modal.removeClass("modal_exito");
            modal.addClass("modal_error");
            $("#planes_simcard_buscar_simcard").hide();
            $("#responsables_simcards").hide();
            $("#responsables_simcards_crear_paquete").hide();
            $("#titulo_modal").text("ERROR!!");
            $("#contenido_modal").text("Plan no encontrado");
            remodal.open();
        }
    });
}

function seleccionar_plan(){
    var modal = $('[data-remodal-id=modal]');
    var remodal = modal.remodal();
    modal.removeClass("modal_exito");
    modal.removeClass("modal_error");
    modal.addClass("modal_info");
    $("#responsables_simcards").hide();
    $("#responsables_simcards_crear_paquete").hide();
    $("#planes_simcard_buscar_simcard").show();
    $("#titulo_modal").text("SELECCIONAR PLAN");
    $("#contenido_modal").text("");
    remodal.open();
}

function cambiar_plan_buscar_simcard(codigo_plan){
    $("#Simcard_plan").text(codigo_plan);
    var modal = $('[data-remodal-id=modal]');
    var remodal = modal.remodal();
    modal.removeClass("modal_exito");
    modal.removeClass("modal_error");
    modal.removeClass("modal_info");
    $("#responsables_simcards").hide();
    $("#responsables_simcards_crear_paquete").hide();
    $("#planes_simcard_buscar_simcard").hide();
    $("#titulo_modal").text("");
    $("#contenido_modal").text("");
    remodal.close();
}