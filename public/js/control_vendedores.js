$( document ).ready(function() {
   $("#link_control_vendedores").closest("ul").closest("li").attr('class', 'active');
   $("#link_control_vendedores").closest("ul").fadeIn();
   $("#link_control_vendedores").addClass("current-page"); 
});


function buscar(){
    var nombre = $('[data-id="subPicker_cedula"]').text();
    $.ajax({
        url:'/buscar_ubicaciones',
        data:{nombre:nombre},
        type:'get',
        success: function(data){
            var html = "";
            for(var i = 0; i < data.length; i++){
                html += '<button class ="btn verde ubicacion" onClick="ver_mapa(this.value)" value="'+data[i].latitud+","+data[i].longitud+'">' + data[i].fecha + "</button>";
            }
            $('#listado_ubicaciones').html(html);
        }
    });
}

function ver_mapa(value){
    var html = '<iframe frameborder="0" class ="mapa" style="border:0;margin:0 auto;" src="https://www.google.com/maps/embed/v1/place?q='+value+'&key=AIzaSyDaFmSLTqXnu89e_vBGK9gYF70YW-I1KAM" allowfullscreen></iframe>';
    limpiar_modal();
    $("#titulo_modal").text("EXITO!!");
    $("#contenido_modal").html(html);
    remodal.open();
    //$('#ubicacion').html(html);
}