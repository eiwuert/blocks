$( document ).ready(function() {
   $("#link_personal").closest("ul").closest("li").attr('class', 'active');
   $("#link_personal").closest("ul").fadeIn();
   $("#link_personal").addClass("current-page"); 
});

function seleccionar_jefe(){
   limpiar_modal();
   modal.addClass("modal_info");
   $("#jefes").show();
   $("#titulo_modal").text("SELECCIONAR JEFE");
   $("#contenido_modal").text("");
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
                  $("#btn_eliminar_empleado").prop('disabled', true);
                  $("#Actor_sueldo").prop('disabled', true);
                  $("#Actor_cedula").prop('disabled', true);
                  $("#region").prop('disabled', true);
                  $("#ciudad").prop('disabled', true);
               }else{
                  $("#Actor_porcentaje_prepago").prop('disabled', false);
                  $("#Actor_porcentaje_postpago").prop('disabled', false);
                  $("#Actor_porcentaje_libre").prop('disabled', false);
                  $("#Actor_porcentaje_servicio").prop('disabled', false);
                  $("#Actor_porcentaje_equipo").prop('disabled', false);
                  $("#Actor_jefe_nombre").prop('disabled', false);
                  $("#btn_eliminar_empleado").prop('disabled', false);
                  $("#Actor_sueldo").prop('disabled', false);
                  $("#Actor_cedula").prop('disabled', false);
                  $("#region").prop('disabled', false);
                  $("#ciudad").prop('disabled', false);
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

function crear_empleado(){
   if($("#Actor_jefe_cedula").text() == "" || $("#region").text() == "Región"){
      limpiar_modal();
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR!!");
      $("#contenido_modal").text("Debe especificar un jefe y una ubicación");
      remodal.open();
   }else if($("#Actor_jefe_nombre").is(':disabled')){
      limpiar_modal();
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR!!");
      $("#contenido_modal").text("No se puede seleccionar un jefe suyo");
      remodal.open();
   }else{
      var inputs = $('#buscar_empleado .form :input');
      var datos_empleado = {};
      inputs.each(function() {
         datos_empleado[this.id] = $(this).val();
      });
      datos_empleado["Actor_jefe_cedula"] = $("#Actor_jefe_cedula").text();
      datos_empleado["Actor_region"] = $("#region").text();
      datos_empleado["Actor_ciudad"] = $("#ciudad").text();
      $.get('/crear_actor', {dato:datos_empleado}, function(data){
            limpiar_modal();
            if(data == 'EXITOSO'){
               //MODAL INFORMANDO EXITO
               modal.addClass("modal_exito");
               $("#titulo_modal").text("EXITO!!");
               $("#contenido_modal").text("Empleado creado satisfactoriamente");
            }else{
               //MODAL INFORMANDO ERROR
               modal.addClass("modal_error");
               $("#titulo_modal").text("ERROR!!");
               $("#contenido_modal").text(data);
            }
            remodal.open();
      });
   }
}

function actualizar_empleado(){
   var cedula = $("#Actor_cedula_copia").text();
   if(cedula == ""){
      //MODAL INFORMANDO ERROR
      limpiar_modal();
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR!!");
      $("#contenido_modal").text("Debe buscar un empleado antes de actualizarlo");
      remodal.open();
   }else if($("#Actor_jefe_cedula").text() == "" || $("#region").text() == "Región"){
      limpiar_modal();
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR!!");
      $("#contenido_modal").text("Debe especificar un jefe y una ubicación");
      remodal.open();
   }else{
      var inputs = $('#buscar_empleado .form :input');
      var datos_empleado = {};
      inputs.each(function() {
         datos_empleado[this.id] = $(this).val();
      });
      datos_empleado["Actor_cedula_copia"] =$("#Actor_cedula_copia").text(); 
      if($("#Actor_jefe_cedula").text() != "GERENTE"){
         datos_empleado["Actor_jefe_cedula"] = $("#Actor_jefe_cedula").text();
      }else{
         datos_empleado["Actor_jefe_cedula"] = null;
      }
      datos_empleado["Actor_region"] = $("#region").text();
      datos_empleado["Actor_ciudad"] = $("#ciudad").text();
      $.get('/actualizar_actor', {dato:datos_empleado}, function(data){
            limpiar_modal();
            if(data == 'EXITOSO'){
               $("#Actor_cedula_copia").text($("#Actor_jefe_cedula").text());
               //MODAL INFORMANDO EXITO
               modal.addClass("modal_exito");
               $("#titulo_modal").text("EXITO!!");
               $("#contenido_modal").text("Empleado actualizado satisfactoriamente");
            }else{
               //MODAL INFORMANDO ERROR
               modal.addClass("modal_error");
               $("#titulo_modal").text("ERROR!!");
               $("#contenido_modal").text(data);
            }
            remodal.open();
      });
   }
}

function eliminar_empleado(){
   var cedula = $("#Actor_cedula_copia").text();
   if(cedula == ""){
      //MODAL INFORMANDO ERROR
      modal.addClass("modal_error");
      $("#titulo_modal").text("ERROR!!");
      $("#contenido_modal").text("Debe buscar un empleado antes de eliminarlo");
      remodal.open();
   }else{
      $.get('/eliminar_actor', {dato:cedula}, function(data){
            limpiar_modal();
            if(data == 'EXITOSO'){
               //MODAL INFORMANDO EXITO
               modal.addClass("modal_exito");
               $("#titulo_modal").text("EXITO!!");
               $("#contenido_modal").text("Empleado eliminado satisfactoriamente");
               limpiar_empleado();
            }else{
               //MODAL INFORMANDO ERROR
               modal.addClass("modal_error");
               $("#titulo_modal").text("ERROR!!");
               $("#contenido_modal").text(data);
            }
            remodal.open();
      });
   }
}

function limpiar_empleado(){
   $("#Actor_pista").val("");
   $('#buscar_empleado .form :input').val("");
   $("#Actor_jefe_cedula").text("");
   $("#Actor_jefe_nombre").text("Jefe");
   $("#region").text("Región");
   $("#ciudad").text("Ciudad");
   $("#Actor_cedula_copia").text("");
   $("#Actor_cedula").val("");
   $("#buscar_empleado").find(".text_container").hide();
   $("#Actor_porcentaje_prepago").prop('disabled', false);
   $("#Actor_porcentaje_postpago").prop('disabled', false);
   $("#Actor_porcentaje_libre").prop('disabled', false);
   $("#Actor_porcentaje_servicio").prop('disabled', false);
   $("#Actor_porcentaje_equipo").prop('disabled', false);
   $("#Actor_jefe_nombre").prop('disabled', false);
   $("#Actor_sueldo").prop('disabled', false);
   $("#region").prop('disabled', false);
   $("#ciudad").prop('disabled', false);
}

