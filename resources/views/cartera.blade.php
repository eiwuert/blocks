@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/cartera.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>

@endsection

@section('Content')
<!-- Información general -->
<p>Recuerda que una simcard <span class="red">Roja</span> esta Vencida, <span class="blue">Azul</span> esta Disponible y <span class="green">Verde</span> fue Activada.</p>
<!-- Información general -->
<div class="row">
  <!-- Seccion administrar descripcion general equipo -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Cartera</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a onClick="modal_cargar_descripcion_equipos()"><i class="fa fa-cloud-upload"></i></a></li>
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="cartera_empleado">  
        <div class="formulario_busqueda">
          <h4>Revisa tu estado financieron o el de uno de tus empleados. Oprime una fila para actualizarla o agrega registros oprimiendo "Agregar".</h4>
          <div class="contenedor_pista">
              <p style="display:none" id="nombre_copia"></p>
              <select class="selectpicker" data-width="75%" data-style="data" id="subPicker_cedula">
                @foreach ($actores as $actor)
                <option value='{{$actor["cedula"]}}'>{{$actor["nombre"]}}</option>
                @endforeach
              </select>
              <button style="width:20%" class="btn azul" onClick = "buscar_cartera_empleado()" type="number" id="Empleado_buscar">Buscar</button>
          </div>
          <div style="width:100%; max-height:500px; overflow:auto;">
            <table id="datatable-responsive" class="table table-bordered" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Fecha</th>
                  <th>Descripción</th>
                  <th class="no_visibile_mobile">Cantidad</th>
                  <th class="no_visibile_mobile">Valor Unitario</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody id="cuerpo_cartera">
              </tbody>
            </table>
          </div>
          <h3 id="saldo_container" style="display:none">SALDO A LA FECHA: <span id="saldo"></span></h3>
          <div class="contenedor_acciones">
            <button id="boton_crear_registro" class="btn verde" onClick="crear_registro()">Agregar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion descripcion general equipo -->
</div>
<!-- /page content -->
@endsection

<!-- Modal -->
@section('contenido_modal')
<p id ="contenido_modal"></p>
<div class="x_content" id="contenedor_registro_cartera">
  <div id="buscar_cartera" class="formulario_busqueda">
    <div>
    </div>
    <div class="form">
      <p style="display:none" id ="ID_copia"></p>
      <div class="container">
          <div class="text_container"><span>Fecha</span></div><input type="text" placeholder="Fecha YYYY-MM-DD" id ="Registro_fecha">
      </div>
      <div class="container">
          <div class="text_container"><span>Descripción</span></div><input type="text" placeholder="Descripción" id ="Registro_descripcion">
      </div>
      <div class="container">
          <div class="text_container"><span>Cantidad</span></div><input type="text" placeholder="Cantidad" id ="Registro_cantidad">
      </div>
      <div class="container">
          <div class="text_container"><span>Valor Unitario</span></div><input type="text" placeholder="Valor Unitario" id ="Registro_valor_unitario">
      </div>
    </div> 
    
    <div id="botones_actualizar" class="contenedor_acciones">
        <button class="btn verde" onClick="actualizar_registro()">Guardar</button>
        <button class="btn rojo" onClick="eliminar_registro()">Eliminar</button>
    </div>
    <div id="botones_crear" class="contenedor_acciones">
        <button class="btn verde" onClick="guardar_registro()">Guardar</button>
    </div>
  </div>
</div>
@endsection

@section('botones_modal')
<button class="btn transparente" onClick="abrir_modal_responsables()">SI</button>
<button class="btn transparente" onClick="remodal.close();">NO</button>
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/cartera.js"></script>
  
  <!-- Si es peticion de un equipo desde una peticion GET -->
  @if($cedula != null)
  <script>
    
  </script>
  @endif
  <!-- Si es peticion de un equipo desde una peticion GET -->
  
  @if(Session::get('subiendo_archivo') == true)
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("CARGANDO ARCHIVO EQUIPOS");
      $("#contenido_modal").text("Se le enviará un correo con el resultado");
      remodal.open();
    </script>
  @endif
  
  @if(Session('error_archivo'))
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("ERROR CARGANDO ARCHIVO EQUIPOS");
      $("#contenido_modal").text("{{Session('error_archivo')}}");
      remodal.open();
      
    </script>
  @endif
@endsection
