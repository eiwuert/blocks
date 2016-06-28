@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/control_vendedores.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<div class="row">
  <!-- Seccion listado ubicaciones -->
  <div class="col-md-5 col-sm-5 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Ubicaciones Empleados</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_vendedor">  
        <div>
          <h4>Escoje el empleado y oprime buscar, luego selecciona la fecha de la cual requieres saber la ubicación.</h4>
          <div class="flex_filas" style="width:100%">
            <select class="selectpicker" data-width="75%" data-style="data" id="subPicker_cedula">
              @foreach ($actores as $actor)
              <option value='{{$actor["cedula"]}}'>{{$actor["nombre"]}}</option>
              @endforeach
            </select>
            <button class="btn verde" onClick="buscar()" style="height:40px;width:20%;margin:0 5px;">Buscar</button>
          </div>
          <div style="height:500px;margin-top:10px;" id="listado_ubicaciones">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion listado ubicaciones -->
  
  <!-- Seccion mapa ubicacion -->
  <div class="col-md-7 col-sm-7 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Ubicación</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="ubicacion" style="height:500px;">  
        
      </div>
    </div>
  </div>
  <!-- Seccion mapa ubicacion -->
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
  <script src="/js/control_vendedores.js"></script>
@endsection
