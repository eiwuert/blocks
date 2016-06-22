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
<!-- Información general -->
<p>Recuerda que <span class="red">Rojo</span> es Vencida, <span class="blue">Azul</span> es Disponible y <span class="green">Verde</span> es Activada.</p>
<!-- Información general -->
<div class="row">
  <!-- Seccion administrar descripcion general equipo -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Descripción General Equipo</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_equipo_general">  
        <div class="formulario_busqueda">
          <h4>Busque los equipos por cod_scl o marca, Actualice los datos de todos los equipos modificando los valores blancos en los bloques y oprimiendo "Actualizar" o elimine todos los equipo oprimiendo "Eliminar".</h4>
          <div class="contenedor_pista">
              <input type="text" placeholder="Pista" id="Equipo_general_pista">
              <button style="width:20%" class="btn azul" onClick = "buscar_equipo_general()" type="number" id="Equipo_buscar">Buscar</button>
          </div>
          <div class="form">
              <p id="Equipo_cod_scl_copia" style="display:none"></p>
              <div class="container">
                 <div class="text_container"><span>Cod_scl</span></div><input type="text" placeholder="Cod_scl" id ="Equipo_cod_scl">
               </div>
              <div class="container">
                  <div class="text_container"><span>Gama</span></div><button class="btn transparente" id ="Equipo_gama" onClick="seleccionar_gama()">Gama</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Marca</span></div><input type="text" placeholder="Marca" id ="Equipo_marca">
              </div>
              <div class="container">
                  <div class="text_container"><span>Modelo</span></div><input type="text" placeholder="Modelo" id ="Equipo_modelo">
              </div>
              <div class="container">
                  <div class="text_container"><span>Precio Prepago</span></div><input type="text" placeholder="Precio Prepago" id ="Equipo_precio_prepago">
              </div>
              <div class="container">
                  <div class="text_container"><span>Precio Postpago</span></div><input type="text" placeholder="Precio Postpago" id ="Equipo_precio_postpago">
              </div>
              <div class="container">
                  <div class="text_container"><span>Precio 3 Cuotas</span></div><input type="text" placeholder="Precio 3 Cuotas" id ="Equipo_precio_3_cuotas">
              </div>
              <div class="container">
                  <div class="text_container"><span>Precio 6 Cuotas</span></div><input type="text" placeholder="Precio 6 Cuotas" id ="Equipo_precio_6_cuotas">
              </div>
              <div class="container">
                  <div class="text_container"><span>Precio 9 Cuotas</span></div><input type="text" placeholder="Precio 9 Cuotas" id ="Equipo_precio_9_cuotas">
              </div>
              <div class="container">
                  <div class="text_container"><span>Precio 12 Cuotas</span></div><input type="text" placeholder="Precio 12 Cuotas" id ="Equipo_precio_12_cuotas">
              </div>
            </div> 
          <div class="contenedor_acciones">
              <button class="btn azul" onClick="actualizar_descripcion_equipo()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_descripcion_equipo()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion descripcion general equipo -->
  
  <!-- Seccion administrar descripcion especifica equipo -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Descripción Específica Equipo</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_equipo_especifico">  
        <div class="formulario_busqueda">
          <h4>Busque un equipo por IMEI, Actualice sus datos modificando los valores blancos en los bloques y oprimiendo "Actualizar" o eliminelo oprimiendo "Eliminar".</h4>
          <div class="contenedor_pista">
              <input type="number" placeholder="Pista" id="Equipo_especifico_pista">
              <button style="width:20%" class="btn azul" onClick = "buscar_equipo_especifico()" type="number" id="Equipo_buscar">Buscar</button>
          </div>
          <div class="form">
              <p id="Equipo_IMEI_copia" style="display:none"></p>
              <div class="container">
                 <div class="text_container"><span>IMEI</span></div><input type="text" placeholder="IMEI" id ="Equipo_IMEI">
              </div>
              <div class="container" id ="simcard_container">
                <div class="text_container"><span>Simcard</span></div><a id ="Equipo_simcard" class="btn transparente">Simcard</a>
              </div>
              <div class="container">
                <div class="text_container"><span>Cliente</span></div><a id ="Equipo_cliente" class="btn transparente">Cliente</a>
              </div>
              <div class="container">
                  <div class="text_container"><span>Fecha Venta</span></div><input type="text" placeholder="Fecha Venta" id ="Equipo_fecha_venta">
              </div>
              <div class="container">
                  <div class="text_container"><span>Valor Pagado</span></div><input type="text" placeholder="Valor Pagado" id ="Equipo_descripcion_precio">
              </div>
            </div> 
          <div class="contenedor_acciones">
              <button class="btn azul" onClick="actualizar_descripcion_equipo()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_descripcion_equipo()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion descripcion especifica equipo -->
  
  <!-- Seccion listado equipos de un cod_scl -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Descripción Específica Equipo</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="listado_equipos_contaier">  
        <div class="formulario_busqueda">
          <h4>Listado de equipos con el codigo scl buscado</h4>
          <div class="flex_filas" id="listado_equipos">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion listado equipos de un cod_scl -->
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
  <script src="/js/equipo.js"></script>
  <!-- Si es peticion de un equipo desde una peticion GET -->
  @if($equipo!=null)
  <script>
    buscar_equipo({{$equipo}});
  </script>
  @endif
  <!-- Si es peticion de un equipo desde una peticion GET -->
@endsection
