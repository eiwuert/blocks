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
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="comisiones_empleado">  
        <div class="contenedor_pista">
          <select class="selectpicker" data-width="50%" data-style="data" id ="periodo_comision" style="min-width:220px">
              @foreach ($periodos as $periodo)
                  <option>{{$periodo->periodo}}</option>
              @endforeach
          </select>
          <button style="width:20%;margin:0;padding:0;" class="btn azul" onClick = "buscar_comision()" type="number" id="Comision_buscar">Ver</button>
        </div>
        <div id="contenedor_reporte">
          <h2>GANANCIAS <span id="periodo_lbl"></span></h2>
          <hr>
          <div id ="contenedor_factura">
            <div style="background:#C1DAD6">
              <h3>Simcards Prepago </h3>
              <button onClick="detalle_comision_prepago()" id="total_simcards_prepago"></button>
            </div>
            <div style="background:#C1DAD6">
              <h3>Simcards Libre</h3>
              <button onClick="detalle_comision_libre()" id="total_simcards_libre"></button>
            </div>
            <div style="background:#C1DAD6">
              <h3>Simcards Postpago</h3>
              <button onClick="detalle_comision_postpago()" id="total_simcards_postpago"></button>
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

@endsection

@section('botones_modal')
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/comision.js"></script>
@endsection
