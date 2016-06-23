$( document ).ready(function() {
   $("#link_personal").closest("ul").closest("li").attr('class', 'active');
   $("#link_personal").closest("ul").fadeIn();
   $("#link_personal").addClass("current-page"); 
});

function cambiar_rol(cedula){
   $("#nombre_rol").text($("#"+cedula).text());
   $("#cedula_rol").text(cedula);
}