$( document ).ready(function() {
   $("#link_reportes_inventario").closest("ul").closest("li").attr('class', 'active');
   $("#link_reportes_inventario").closest("ul").fadeIn();
   $("#link_reportes_inventario").addClass("current-page"); 
});