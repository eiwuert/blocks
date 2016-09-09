$( document ).ready(function() {
   $(".side-menu li").attr('class', '');
   $(".child_menu").hide();
});

var modal = $('[data-remodal-id=modal]');
var remodal = modal.remodal();
        
function limpiar_modal(){
   var modal = $('[data-remodal-id=modal]');
   var remodal = modal.remodal();
   modal.removeClass("modal_info");
   modal.removeClass("modal_exito");
   modal.removeClass("modal_error");
   $("#responsables_simcards_crear_paquete").hide();
   $("#planes_simcard_buscar_simcard").hide();
   $("#tipos_cliente").hide();
   $("#responsables_simcards").hide();
   $("#responsables_equipo").hide();
   $("#regiones").hide();
   $("#jefes").hide();
   $("#ciudades").hide();
   $("#botones_modal").hide();   
   $("#cargar_simcard_modal").hide();
   $("#cargar_plan_modal").hide();   
   $("#cargar_descripcion_equipo_modal").hide();   
   $("#cargar_equipo_modal").hide(); 
   $("#cargar_comisiones_modal").hide(); 
   $("#contenedor_registro_cartera").hide();   
   $("#titulo_modal").text("");
   $("#contenido_modal").text("");
}

function cambiar_region(region){
    $("#region").text(region);
    $("#ciudad").text($("#"+region+"_container").children().first().text());
    $("#ciudades").find("div").hide();
    $("#"+region+"_container").show();
    remodal.close();
}
function seleccionar_region(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("SELECCIONAR REGIÓN");
    $("#contenido_modal").text("");
    $("#regiones").show();
    remodal.open();
}

function cambiar_ciudad(ciudad){
    $("#ciudad").text(ciudad);
    remodal.close();
}
function seleccionar_ciudad(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("SELECCIONAR CIUDAD");
    $("#contenido_modal").text("");
    $("#ciudades").show();
    remodal.open();
}

function borrar_notificaciones(){
    $.get('/borrar_notificaciones',{}, function(data){  
    });
}