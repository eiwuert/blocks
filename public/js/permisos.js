$( document ).ready(function() {
   $("#link_permisos").closest("ul").closest("li").attr('class', 'active');
   $("#link_permisos").closest("ul").fadeIn();
   $("#link_permisos").addClass("current-page"); 
});

function guardar_permisos(){
   var inputs = $("#principal_table").find("input:checked");
   var inventarios = [];
   var archivos = [];
   inputs.each(function() {
      var cedula = $( this ).closest("tr").attr("id");
      var permiso = $( this ).val();
      if(permiso == "INVENTARIOS"){
         inventarios.push(cedula);
      }else if(permiso == "ARCHIVOS"){
         archivos.push(cedula);
      }
   });
   var data = {"INVENTARIOS":inventarios, "ARCHIVOS":archivos};
   $.get('/guardar_permisos', {data:data}, function(data){
      limpiar_modal();
      if(data == 'EXITOSO'){
         modal.addClass("modal_exito");
         $("#titulo_modal").text("EXITO!!");
         $("#contenido_modal").text("Permisos actualizados satisfactoriamente");    
      }else{
         modal.addClass("modal_error");
         $("#titulo_modal").text("ERROR!!");
         $("#contenido_modal").text(data);    
      }
      remodal.open();
   });
}