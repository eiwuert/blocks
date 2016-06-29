
function showPosition(position) {
    var cedula = $('#cedula').val();
    $.ajax({
        url:'/guardar_ubicacion',
        data:{latitud:position.coords.latitude,longitud:position.coords.longitude,cedula:cedula},
        type:'get',
        success: function(data){
            if(data == 1){
                alert('satisfactorio');
                $('#cedula').val("");
            }else{
                alert('Error: cedula no registrada en el sistema');
            }
        }
     }); 
}

function enviar_ubicacion(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}