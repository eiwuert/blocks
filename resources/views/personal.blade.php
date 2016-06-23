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
<p id="cedula_rol" style="display:none">{{$Actor->cedula}}</p>
<div class="row">  
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Selección de rol - Viendo como: <span id="nombre_rol">{{$Actor->nombre}}</span></h2>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_empleados">  
        <div class="formulario_busqueda">
          <div>
            <h4>Seleccione un usuario, revise/actualice su información y administre sus empleados.</h4>
          </div>
          <div class="flex_filas">
            @foreach ($actores as $actor)
            <button onClick="cambiar_rol(this.id)" style="margin-bottom:5px" class="btn azul" id ='{{$actor["cedula"]}}'>{{$actor["nombre"]}}</button>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <!-- Seccion administrar cliente -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración empleados</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_empleados">  
        <div class="formulario_busqueda">
          <div>
            <h4>Busque un empleado, actualicelo/añadalo modificando los valores blancos en los bloques y oprimiendo "Actualizar"/"Crear" o eliminelo oprimiendo "Eliminar".</h4>
          </div>
          <div class="contenedor_pista">
              <input type="text" placeholder="Cedula / Nombre" id="Cliente_pista">
              <button class="btn azul" onClick = "buscar_empleado()" id="Actor_buscar">Buscar</button>
          </div>
          <div class="form">
              <p style="display:none" id="Actor_cedula_copia"></p>
              <div class="container">
                  <div class="text_container"><span id="Actor_cedula_lbl"></span></div><input type="text" placeholder="ID" id ="Actor_cedula">
              </div>
              <div class="container">
                  <div class="text_container"><span>Región</span></div><button class="btn transparente" id ="Cliente_region" onClick="seleccionar_region()">Región</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Ciudad</span></div><button class="btn transparente" id ="Cliente_ciudad" onClick="seleccionar_ciudad()">Ciudad</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Nombre</span></div><input type="text" placeholder="Nombre" id ="Actor_nombre">
              </div>
              <div class="container">
                  <div class="text_container"><span>Teléfono</span></div><input type="text" placeholder="Teléfono" id ="Actor_telefono">
              </div>
              <div class="container">
                  <div class="text_container"><span>Correo</span></div><input type="text" placeholder="Correo" id ="Actor_correo">
              </div>
              <div class="container">
                  <div class="text_container"><span>Sueldo</span></div><input type="text" placeholder="Sueldo" id ="Actor_sueldo">
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
  <script src="/js/personal.js"></script>
@endsection
