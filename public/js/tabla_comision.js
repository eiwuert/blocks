$( document ).ready(function() {
    $( "#tipo_comision" ).change(function() {
        if($("#tipo_comision").val() == "Natural"){
            $("#tabla_empresa").hide();
            $("#tabla_natural").show();
        }else{
            $("#tabla_empresa").show();
            $("#tabla_natural").hide();
        }
        
    });
});