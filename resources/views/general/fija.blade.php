@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/equipo.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<div class="row">
  <!-- Seccion administrar descripcion general equipo -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración fija</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a onClick="modal_cargar_descripcion_equipos()"><i class="fa fa-cloud-upload"></i></a></li>
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_equipo_general">  
        <div class="formulario_busqueda">
          <h4></h4>
          <div class="contenedor_pista">
              <input type="text" placeholder="Pista" id="Equipo_general_pista">
              <button style="width:20%" class="btn azul" onClick = "buscar_equipo_general()" type="number" id="Descripcion_Equipo_buscar">Buscar</button>
          </div>
          <div class="form">
              
          <div class="contenedor_acciones" style="display:none">
              <button class="btn azul" onClick="actualizar_descripcion_equipo()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_descripcion_equipo()">Eliminar</button>
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


@endsection

@section('botones_modal')
<button class="btn transparente" onClick="abrir_modal_responsables()">SI</button>
<button class="btn transparente" onClick="remodal.close();">NO</button>
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/fija.js"></script>
  <!-- Si es peticion de un equipo desde una peticion GET -->
  @if($peticion!=null)
  <script>
    
  </script>
  @endif
  <!-- Si es peticion de un equipo desde una peticion GET -->
  
  @if(Session::get('subiendo_archivo') == true)
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("CARGANDO ARCHIVO FIJA");
      $("#contenido_modal").text("Se le notificará cuando haya un resultado");
      remodal.open();
    </script>
  @endif
  
  @if(Session('error_archivo'))
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("ERROR CARGANDO ARCHIVO FIJA");
      $("#contenido_modal").text("{{Session('error_archivo')}}");
      remodal.open();
      
    </script>
  @endif
@endsection
