@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/cliente.css" rel="stylesheet">
<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<!-- Información general -->
<p>Recuerda que una simcard <span class="red">Roja</span> esta Vencida, <span class="blue">Azul</span> esta Disponible y <span class="green">Verde</span> fue Activada.</p>
<!-- Información general -->
<div class="row">
  <!-- Seccion administrar cliente -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración clientes</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_cliente">  
        <div class="formulario_busqueda">
          <div>
            <h4>Busque un cliente, actualicelo/añadalo modificando los valores blancos en los bloques y oprimiendo "Actualizar"/"Crear" o eliminelo oprimiendo "Eliminar".</h4>
          </div>
          <div class="contenedor_pista">
              <input type="text" placeholder="Cedula / Nombre" id="Cliente_pista">
              <button class="btn azul" onClick = "buscar_cliente()" id="Cliente_buscar">Buscar</button>
          </div>
          <div class="form">
              <p style="display:none" id="Cliente_identificacion_copia"></p>
              <div class="container">
                  <div class="text_container"><span id="Cliente_identificacion_lbl"></span></div><input type="text" placeholder="ID" id ="Cliente_identificacion">
              </div>
              <div class="container">
                  <div class="text_container"><span>Región</span></div><button class="btn transparente" id ="region" onClick="seleccionar_region()">Región</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Ciudad</span></div><button class="btn transparente" id ="ciudad" onClick="seleccionar_ciudad()">Ciudad</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Tipo</span></div><button class="btn transparente" id ="Cliente_tipo" onClick="seleccionar_tipo()">Tipo</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Nombre</span></div><input type="text" placeholder="Nombre" id ="Cliente_nombre">
              </div>
              <div class="container">
                  <div class="text_container"><span>Teléfono</span></div><input type="text" placeholder="Teléfono" id ="Cliente_telefono">
              </div>
              <div class="container">
                  <div class="text_container"><span>Correo</span></div><input type="text" placeholder="Correo" id ="Cliente_correo">
              </div>
              <div class="container">
                  <div class="text_container"><span>Direccion</span></div><input type="text" placeholder="Direccion" id ="Cliente_direccion">
              </div>
            </div> 
          <div class="contenedor_acciones">
              <button class="btn verde" onClick="crear_cliente()">Crear</button>
              <button class="btn azul" onClick="actualizar_cliente()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_cliente()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion administrar cliente -->
  
  <!-- Seccion administrar responsable cliente -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración Responsables</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_responsable" style="display:none">  
        <div class="formulario_busqueda">
          <div>
            <h4>Información del responsable de un cliente empresa, actualice su información modificando los valores blancos en los bloques y oprimiendo "Actualizar" o eliminelo oprimiendo "Eliminar".</h4>
          </div>
          <div class="form">
              <p style="display:none" id="Responsable_cedula_copia"></p>
              <div class="container">
                  <div class="text_container"><span id="Responsable_cedula_lbl">Cedula</span></div><input type="text" placeholder="ID" id ="Responsable_cedula">
              </div>
              <div class="container">
                  <div class="text_container"><span>Nombre</span></div><input type="text" placeholder="Nombre" id ="Responsable_nombre">
              </div>
              <div class="container">
                  <div class="text_container"><span>Teléfono</span></div><input type="text" placeholder="Teléfono" id ="Responsable_telefono">
              </div>
              <div class="container">
                  <div class="text_container"><span>Correo</span></div><input type="text" placeholder="Correo" id ="Responsable_correo">
              </div>
            </div> 
          <div class="contenedor_acciones">
              <button class="btn azul" onClick="actualizar_responsable()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_responsable()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion administrar responsable cliente -->
  
  <!-- Seccion listado simcards cliente -->
  <div class="col-md-6 col-sm-6 col-xs-12" id="container_listado_simcards">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Simcards Cliente</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="listado_simcards" style="display:none">  
        <h4>Listado de simcards pertenecientes al cliente buscado. Oprima una para observar su información.</h4>
        <div class="flex_filas">
          
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion listado simcards cliente -->
  
  <!-- Seccion listado equipos cliente -->
  <div class="col-md-6 col-sm-6 col-xs-12" id="container_listado_equipos">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Equipos Cliente</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="listado_equipos" style="display:none">  
        <h4>Listado de equipos pertenecientes al cliente buscado. Oprima una para observar su información.</h4>
        <div class="flex_filas">
          
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion listado simcards cliente -->
</div>
<!-- /page content -->
@endsection

<!-- Modal -->
@section('contenido_modal')
<p id ="contenido_modal"></p>
<div id="tipos_cliente" style="display:none">
  <button class="btn transparente" id='NATURAL' onClick='cambiar_tipo(this.id)'>NATURAL</button>
  <button class="btn transparente" id='EMPRESA' onClick='cambiar_tipo(this.id)'>EMPRESA</button>
</div>

<div id="regiones" style="display:none">
  @foreach ($regiones as $region)
      <button class="btn transparente" id='{{$region->region}}' onClick='cambiar_region(this.id)'>{{$region->region}}</button>
  @endforeach
</div>

<div id="ciudades" style="display:none">
  @foreach ($regiones as $region)
  <div id ="{{$region->region}}_container" style="display:none;">
    @foreach ($region->ciudades as $ciudad)  
      <button class="btn transparente" id='{{$ciudad->ciudad}}' onClick='cambiar_ciudad(this.id)'>{{$ciudad->ciudad}}</button>
    @endforeach    
  </div>
  @endforeach
</div>
@endsection

@section('botones_modal')
<button class="btn transparente" onClick="abrir_modal_responsables()">SI</button>
<button class="btn transparente" onClick="remodal.close();">NO</button>
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/cliente.js"></script>
  <srcipt>
  @if($cliente != null)
  <script>
    buscar_cliente({{$cliente}});
  </script>
  @endif)
  </srcipt>
@endsection
