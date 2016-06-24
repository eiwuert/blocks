$( document ).ready(function() {
   $("#link_personal").closest("ul").closest("li").attr('class', 'active');
   $("#link_personal").closest("ul").fadeIn();
   $("#link_personal").addClass("current-page"); 
});

function seleccionar_jefe(){
   limpiar_modal();
   var empleado = $("#Actor_cedula_copia").text();
   if( empleado == ""){
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR");
      $("#contenido_modal").text("Debe buscar un empleado primero");  
   }else{
      modal.addClass("modal_info");
      $("#jefes").show();
      $("#titulo_modal").text("SELECCIONAR JEFE");
      $("#contenido_modal").text("");
      $("#"+empleado).hide();
   }
   remodal.open();
}

function cambiar_jefe(cedula){
   $("#Actor_jefe_container").show();
   $("#Actor_jefe_cedula").text(cedula);
   var nombre_jefe = $("#"+cedula).text();
   $("#Actor_jefe_nombre").text(nombre_jefe);
   remodal.close();
}

function buscar_empleado(cedula){
   if(cedula != null){
      var pista = cedula;
   }else{
      var pista = $("#Actor_pista").val();
   }
   if(pista == ""){
      limpiar_modal();
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR!!");
      $("#contenido_modal").text("Debe especificar una pista para buscar");
      remodal.open();
   }else{
      $.get('/buscar_actor', {dato:pista}, function(data){
            limpiar_modal();
            if(data == 'NO AUTORIZADO'){
               $('#buscar_empleado .form :input').val("");
               $("#Actor_jefe_cedula").text("");
               $("#Actor_jefe_nombre").text("Jefe");
               $("#region").text("Región");
               $("#ciudad").text("Ciudad");
               $("#buscar_empleado").find(".text_container").hide();
               //MODAL INFORMANDO ERROR
               modal.addClass("modal_error");
               $("#titulo_modal").text("ERROR!!");
               $("#contenido_modal").text("No tiene los privilegios para observar el empleado solicitado");
               remodal.open();
            }else if(data != ''){
               if(data.jefe == null){
                  $("#Actor_jefe_nombre").text("GERENTE");
                  $("#Actor_jefe_cedula").text("GERENTE");
               }else{
                  $("#Actor_jefe_nombre").text(data.jefe.nombre);
                  $("#Actor_jefe_cedula").text(data.jefe.cedula);
               }
               $("#Actor_cedula_copia").text(data.cedula);
               $("#Actor_cedula").val(data.cedula);
               $("#region").text(data.ubicacion.region);
               $("#ciudad").text(data.ubicacion.ciudad);
               $("#Actor_nombre").val(data.nombre);
               $("#Actor_telefono").val(data.telefono);
               $("#Actor_correo").val(data.correo);
               $("#Actor_sueldo").val(data.sueldo);
               $("#Actor_porcentaje_prepago").val(data.porcentaje_prepago);
               $("#Actor_porcentaje_postpago").val(data.porcentaje_postpago);
               $("#Actor_porcentaje_libre").val(data.porcentaje_libre);
               $("#Actor_porcentaje_servicio").val(data.porcentaje_servicio);
               $("#Actor_porcentaje_equipo").val(data.porcentaje_equipo);
               $("#buscar_empleado").find(".text_container").show();
               //REVISAR SI SOY YO MISMO
               if($("#user_cedula").text() == data.cedula){
                  $("#Actor_porcentaje_prepago").prop('disabled', true);
                  $("#Actor_porcentaje_postpago").prop('disabled', true);
                  $("#Actor_porcentaje_libre").prop('disabled', true);
                  $("#Actor_porcentaje_servicio").prop('disabled', true);
                  $("#Actor_porcentaje_equipo").prop('disabled', true);
                  $("#Actor_jefe_nombre").prop('disabled', true);
               }else{
                  $("#Actor_porcentaje_prepago").prop('disabled', false);
                  $("#Actor_porcentaje_postpago").prop('disabled', false);
                  $("#Actor_porcentaje_libre").prop('disabled', false);
                  $("#Actor_porcentaje_servicio").prop('disabled', false);
                  $("#Actor_porcentaje_equipo").prop('disabled', false);
                  $("#Actor_jefe_nombre").prop('disabled', false);
               }
            }else{
               $('#buscar_empleado .form :input').val("");
               $("#Actor_jefe_cedula").text("");
               $("#Actor_jefe_nombre").text("Jefe");
               $("#region").text("Región");
               $("#ciudad").text("Ciudad");
               $("#buscar_empleado").find(".text_container").hide();
               //MODAL INFORMANDO ERROR
               modal.addClass("modal_error");
               $("#titulo_modal").text("ERROR!!");
               $("#contenido_modal").text("Empleado no encontrado");
               remodal.open();
            }
      });
   }
}