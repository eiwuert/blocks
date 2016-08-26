@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/comision.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>

@endsection

@section('Content')
<div class="row">
  <!-- Seccion reporte general comisiones -->
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Comisiones</h2>
        <ul class="nav navbar-right panel_toolbox">
          @if($Actor->jefe == null)
          <li><a onClick="modal_cargar_comisiones()"><i class="fa fa-cloud-upload"></i></a></li>
          @endif
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="comisiones_empleado">  
        <div class="contenedor_pista">
          @if($Actor->jefe == null)
          <select class="selectpicker" data-width="71%" data-style="data" id ="actor_comision" style="min-width:320px;">
              @foreach ($actores as $actor)
                  <option>{{$actor->nombre}}</option>
              @endforeach
          </select>
          @endif
          <select class="selectpicker" data-width="50%" data-style="data" id ="periodo_comision" style="min-width:220px">
              @foreach ($periodos as $periodo)
                  <option>{{$periodo->periodo}}</option>
              @endforeach
          </select>
          @if($Actor->jefe == null)
            <button style="width:20%;margin:0;padding:0;" class="btn azul" onClick = "buscar_comision('admin')" type="number" id="Comision_buscar">Ver</button>
          @else
            <button style="width:20%;margin:0;padding:0;" class="btn azul" onClick = "buscar_comision('employee')" type="number" id="Comision_buscar">Ver</button>
          @endif
        </div>
        <div id="contenedor_reporte">
          <h2>GANANCIAS <span id="periodo_lbl"></span></h2>
          <hr>
          <div id ="contenedor_factura">
            <div style="background:#C1DAD6">
              <h3>Simcards Prepago </h3>
              @if($Actor->jefe != null)
                <button onClick="detalle_comision_prepago('employee')" id="total_simcards_prepago"></button>
              @else
                <button onClick="detalle_comision_prepago('admin')" id="total_simcards_prepago"></button>
              @endif
            </div>
            <div style="background:#C1DAD6">
              <h3>Simcards Libre</h3>
              @if($Actor->jefe != null)
                <button onClick="detalle_comision_libre('employee')" id="total_simcards_libre"></button>
              @else
                <button onClick="detalle_comision_libre('admin')" id="total_simcards_libre"></button>
              @endif
            </div>
            <div style="background:#C1DAD6">
              <h3>Simcards Postpago</h3>
              @if($Actor->jefe != null)
                <button onClick="detalle_comision_postpago('employee)" id="total_simcards_postpago"></button>
              @else
                <button onClick="detalle_comision_postpago('admin')" id="total_simcards_postpago"></button>
              @endif
            </div>
            <div style="background:#89E894">
              <h3>Equipos</h3>
              <button id="total_equipos"></button>
            </div>
            <div style="background:#FDFD96">
              <h3>Servicios</h3>
              <button id="total_servicios"></button>
            </div>
          </div>
          <h2>SUBTOTAL</h2>
          <hr>
          <p id="subtotal"></p>
          <h2>RETENCION</h2>
          <hr>
          <p id="retencion"></p>
          <h2>RETEICA</h2>
          <hr>
          <p id="reteica"></p>
          <h2 style="font-size:25px">TOTAL</h2>
          <hr>
          <p id="total"></p>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion reporte general comisiones -->
  
  <!-- Seccion reporte especifico comisiones -->
  <div class="col-md-6 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Detalle Comisiones</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="detalle_comisiones_empleado">  
        
      </div>
    </div>
  </div>
  <!-- Seccion reporte especifico comisiones -->
</div>
<!-- /page content -->
@endsection

<!-- Modal -->
@section('contenido_modal')
<p id ="contenido_modal"></p>

<div class="flex_filas" id="cargar_comisiones_modal">
  {!! Form::open(
      array(
          'route' => 'subirComisiones', 
          'class' => 'flex_filas', 
          'novalidate' => 'novalidate', 
          'files' => true,
          'style' => 'text-align:center; justify-content:center')) !!}
  	
		<input type="file" accept=".xlsx,.csv,.xls" name="archivo_comision" id="file-3" class="inputfile inputfile-2"/>
  	<label class="transparente" for="file-3"><span>Escoje un archivo&hellip;</span></label>
  	<input type="submit" class="btn transparente" value="Subir">
	{!! Form::close() !!}     
</div>
@endsection

@section('botones_modal')
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/comision.js"></script>
  @if(Session::get('subiendo_archivo') == true)
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("CARGANDO ARCHIVO COMISIONES");
      $("#contenido_modal").text("Se le notificará cuando haya un resultado");
      remodal.open();
    </script>
  @endif
@endsection
