
$( document ).ready(function() {
   $("#link_comision").closest("ul").closest("li").attr('class', 'active');
   $("#link_comision").closest("ul").fadeIn();
   $("#link_comision").addClass("current-page"); 
});

function buscar_comision(type){
    var actor = null;
    var periodo;
    if(type == "admin"){
        actor = $('[data-id="actor_comision"]').text();    
    }
    periodo = $('[data-id="periodo_comision"]').text();
    $.get('/buscar_comision', {actor:actor, periodo:periodo}, function(data){
            $("#periodo_lbl").text(periodo);
            $("#total_simcards_prepago").text("$" + addCommas(Math.floor(data["simcards_prepago"])));
            $("#total_simcards_libre").text("$" + addCommas(Math.floor(data["simcards_libre"])));
            $("#total_simcards_postpago").text("$" + addCommas(Math.floor(data["simcards_postpago"])));
            $("#total_servicios").text("$" + addCommas(Math.floor(data["servicios"])));
            var subtotal = data["simcards_prepago"]+data["simcards_libre"]+data["simcards_postpago"]+data["servicios"];
            $("#subtotal").text("$" + addCommas(Math.floor(subtotal)));
            $("#retencion").text("$" + addCommas(Math.floor(subtotal*0.11)));
            $("#reteica").text("$" + addCommas(Math.floor(subtotal*0.01)));
            $("#total").text("$" + addCommas(Math.floor(subtotal*0.88)));
        }
    );
}

function detalle_comision_prepago(type){
    if($("#periodo_lbl").text() != ""){
        var actor = null;
        var periodo;
        if(type == "admin"){
            actor = $('[data-id="actor_comision"]').text();    
        }
        periodo = $('[data-id="periodo_comision"]').text();
        $.get('/detalle_comision_prepago',{actor:actor,periodo:periodo}, function(data){  
                if(data != null){
                    $("#detalle_comisiones_empleado").html("");
                    $("#detalle_comisiones_empleado").append("<h3>Comisiones Prepago</h3>");
                    $("#detalle_comisiones_empleado").append("<div><div>Fecha</div><div>ICC</div><div>Valor</div></div>");
                    for(var i = 0; i < data["simcards"].length; i++){
                        var row = "<div>";
                        row += "<div>" + data["simcards"][i].fecha +"</div>";
                        row += '<div><a href="/simcard?simcard='+ data["simcards"][i].Simcard_ICC + '">' + data["simcards"][i].Simcard_ICC +"</a></div>";
                        row += "<div>$" + addCommas(Math.floor(data["simcards"][i].valor*data["porcentaje"])) +"</div>";
                        row += "</div>";
                        $("#detalle_comisiones_empleado").append(row);
                    }
                }
            }
        );
    }
}

function detalle_comision_libre(type){
    if($("#periodo_lbl").text() != ""){
        var actor = null;
        var periodo;
        if(type == "admin"){
            actor = $('[data-id="actor_comision"]').text();    
        }
        periodo = $('[data-id="periodo_comision"]').text();
        $.get('/detalle_comision_libre',{actor:actor,periodo:periodo}, function(data){  
                if(data != null){
                    $("#detalle_comisiones_empleado").html("");
                    $("#detalle_comisiones_empleado").append("<h3>Comisiones Libre</h3>");
                    $("#detalle_comisiones_empleado").append("<div><div>Fecha</div><div>ICC</div><div>Valor</div></div>");
                    for(var i = 0; i < data["simcards"].length; i++){
                        var row = "<div>";
                        row += "<div>" + data["simcards"][i].fecha +"</div>";
                        row += '<div><a href="/simcard?simcard='+ data["simcards"][i].Simcard_ICC + '">' + data["simcards"][i].Simcard_ICC +"</a></div>";
                        row += "<div>$" + addCommas(Math.floor(data["simcards"][i].valor*data["porcentaje"])) +"</div>";
                        row += "</div>";
                        $("#detalle_comisiones_empleado").append(row);
                    }
                }
            }
        );
    }
}

function detalle_comision_postpago(type){
    if($("#periodo_lbl").text() != ""){
        var actor = null;
        var periodo;
        if(type == "admin"){
            actor = $('[data-id="actor_comision"]').text();    
        }
        periodo = $('[data-id="periodo_comision"]').text();
        $.get('/detalle_comision_postpago',{actor:actor,periodo:periodo}, function(data){  
            if(data != null){
                $("#detalle_comisiones_empleado").html("");
                $("#detalle_comisiones_empleado").append("<h3>Comisiones Postpago</h3>");
                $("#detalle_comisiones_empleado").append("<div><div>ICC</div><div>Valor</div></div>");
                for(var i = 0; i < data["simcards_postpago_primera"].length; i++){
                    var row = "<div>";
                    row += '<div><a href="/simcard?simcard='+ data["simcards_postpago_primera"][i].Simcard_ICC + '">' + data["simcards_postpago_primera"][i].Simcard_ICC +"</a></div>";
                    row += "<div>$" + addCommas(Math.floor(data["simcards_postpago_primera"][i].valor*data["porcentaje"])) +"</div>";
                    row += "</div>";
                    $("#detalle_comisiones_empleado").append(row);
                }
                for(var i = 0; i < data["simcards_postpago_segunda"].length; i++){
                    var row = "<div>";
                    row += '<div><a href="/simcard?simcard='+ data["simcards_postpago_segunda"][i].Simcard_ICC + '">' + data["simcards_postpago_segunda"][i].Simcard_ICC +"</a></div>";
                    row += "<div>$" + addCommas(Math.floor(data["simcards_postpago_segunda"][i].valor*data["porcentaje"])) +"</div>";
                    row += "</div>";
                    $("#detalle_comisiones_empleado").append(row);
                }
                for(var i = 0; i < data["simcards_postpago_tercera"].length; i++){
                    var row = "<div>";
                    row += '<div><a href="/simcard?simcard='+ data["simcards_postpago_tercera"][i].Simcard_ICC + '">' + data["simcards_postpago_tercera"][i].Simcard_ICC +"</a></div>";
                    row += "<div>$" + addCommas(Math.floor(data["simcards_postpago_tercera"][i].valor*data["porcentaje"])) +"</div>";
                    row += "</div>";
                    $("#detalle_comisiones_empleado").append(row);
                }
                for(var i = 0; i < data["simcards_postpago_sexta"].length; i++){
                    var row = "<div>";
                    row += '<div><a href="/simcard?simcard='+ data["simcards_postpago_sexta"][i].Simcard_ICC + '">' + data["simcards_postpago_sexta"][i].Simcard_ICC +"</a></div>";
                    row += "<div>$" + addCommas(Math.floor(data["simcards_postpago_sexta"][i].valor*data["porcentaje"])) +"</div>";
                    row += "</div>";
                    $("#detalle_comisiones_empleado").append(row);
                }
            }
        });
    }
}

function modal_cargar_comisiones(){
    limpiar_modal();
    modal.addClass("modal_info");
    $("#titulo_modal").text("CARGAR ARCHIVO DE COMISIONES");
    $("#contenido_modal").text('Selecciona el archivo y oprime "subir"');
    $("#cargar_comisiones_modal").show();  
    remodal.open();
}

function addCommas(nStr)
{
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}