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
   $("#botones_modal").hide();   
   $("#titulo_modal").text("");
   $("#contenido_modal").text("");
          
}