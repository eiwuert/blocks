@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/fija.css" rel="stylesheet">

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
          <li><a onClick="modal_cargar_fija()"><i class="fa fa-cloud-upload"></i></a></li>
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_fija">  
        <div class="formulario_busqueda">
          <h4></h4>
          <div class="contenedor_pista">
              <input type="text" placeholder="Pista" id="Fija_pista">
              <button style="width:20%" class="btn azul" onClick = "buscar_fija()" type="number" id="fija_buscar">Buscar</button>
          </div>
          <div class="form">
              <p id="Fija_peticion_copia" style="display:none"></p>
              <div class="container">
                 <div class="text_container"><span>Petición:</span></div><input disabled="true" type="text" placeholder="Peticion" id ="Fija_peticion">
              </div>
              <div class="container">
                 <div class="text_container"><span>Responsable</span></div><a id ="Fija_responsable">Responsable</a>
              </div>
              <div class="container">
                 <div class="text_container"><span>Cliente</span></div><a id ="Fija_cliente">Cliente</a>
              </div>
              <div class="container">
                 <div class="text_container"><span>Tipo:</span></div><input disabled="true" type="text" placeholder="Tipo" id ="Fija_tipo">
              </div>
              <div class="container">
                 <div class="text_container"><span>Producto:</span></div><input disabled="true" type="text" placeholder="Producto" id ="Fija_producto">
              </div>
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

<div class="flex_filas" style="justify-content:center" id="cargar_fija_modal">
  {!! Form::open(
      array(
          'route' => 'subirArchivoFija', 
          'class' => 'flex_filas', 
          'novalidate' => 'novalidate', 
          'files' => true,
          'style' => 'text-align:center; justify-content:center')) !!}
  	
		<input type="file" accept=".xlsx,.csv,.xls" name="archivo_fija" id="file-2" class="inputfile inputfile-2"/>
  	<label class="transparente" for="file-2"><span>Escoje un archivo&hellip;</span></label>
  	<input type="submit" class="btn transparente" value="Subir">
	{!! Form::close() !!}     
</div>
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
