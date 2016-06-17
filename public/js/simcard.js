function buscar_simcard(){
    var pista = $("#Simcard_pista").val();
    $.get('/simcard/buscar_simcard', {dato:pista}, function(data){
            if(data != ''){
                $(".buscar_simcard").find(".text_container").show();
                $('#Simcard_ICC').text(data.ICC);
                $('#Simcard_responsable').text(data.responsable_simcard);
                $('#Simcard_numero_linea').val(data.numero_linea);
                $('#Simcard_categoria').text(data.categoria);
                $('#Simcard_fecha_adjudicacion').val(data.fecha_adjudicacion);
                $('#Simcard_fecha_activacion').val(data.fecha_activacion);
                $('#Simcard_fecha_vencimiento').val(data.fecha_vencimiento);
                $(".buscar_simcard").find(".container").attr('class', 'container');;
                $(".buscar_simcard").find(".container").addClass(data.color);
            }else{
                $(".buscar_simcard").find(".text_container").hide();
                $('.buscar_simcard form :input').val("");
                $('#Simcard_ICC').text("ICC");
                $('#Simcard_responsable').text("Responsable");
                $('#Simcard_categoria').text("Categoría");
                $(".buscar_simcard").find(".container").attr('class', 'container');;
            }
        }
    );
}

function actualizar_simcard(){
    
    var inputs = $('.buscar_simcard form :input');
    var datos_simcard = {};
    datos_simcard["ICC"] = $('#Simcard_ICC').text();
    inputs.each(function() {
        datos_simcard[this.id] = $(this).val();
    });
    $.get('/simcard/actualizar_simcard', {dato:datos_simcard}, function(resultado){
            if(resultado == "EXITOSO" ){
                console.log(data);
            }else{
                console.log("mal");
            }
        }
    ); 
}