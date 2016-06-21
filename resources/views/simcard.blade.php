@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/simcard.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<!-- Información general -->
<p>Recuerda que <span class="red">Rojo</span> es Vencida, <span class="blue">Azul</span> es Disponible y <span class="green">Verde</span> es Activada.</p>
<!-- Información general -->
<div class="row">
  <!-- Seccion administrar simcard -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración simcards</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_simcard">  
        <div class="formulario_busqueda">
          <div>
            <h4>Busque una simcard, actualicela modificando los valores blancos en los bloques y oprimiendo "Actualizar", asignela oprimiendo "Asignar" o eliminela oprimiendo "Eliminar".</h4>
          </div>
          <div class="contenedor_pista">
              <input type="number" placeholder="ICC / número linea" id="Simcard_pista">
              <button style="width:20%" class="btn azul" onClick = "buscar_simcard()" type="number" id="Simcard_buscar">Buscar</button>
          </div>
          <div class="form">
              <div class="container">
                <div class="text_container"><span>Responsable</span></div><p id="Simcard_responsable">Responsable</p>
              </div>
              <div class="container">
                <div class="text_container"><span>Cliente</span></div><a id ="Simcard_cliente" class="btn transparente">Cliente</a>
              </div>
              <div class="container">
                  <div class="text_container"><span>ICC</span></div><p id ="Simcard_ICC">ICC</p>
              </div>
              <div class="container">
                  <div class="text_container"><span>Línea</span></div><input type="text" placeholder="Número" id ="Simcard_numero_linea">
              </div>
              <div class="container">
                  <div class="text_container"><span>Categoría</span></div><p id ="Simcard_categoria">Categoría</p>
              </div>
              <div class="container">
                  <div class="text_container"><span>Paquete</span></div><p id ="Simcard_paquete">Paquete</p>
              </div>
              <div class="container">
                  <div class="text_container"><span>Plan</span></div><button class="btn transparente" id ="Simcard_plan" onClick="seleccionar_plan()">Plan</button>
              </div>
              <div class="container">
                  <div class="text_container"><span>Adjudicada</span></div><input type="text" placeholder="Adjudicación" id ="Simcard_fecha_adjudicacion">
              </div>
              <div class="container">
                  <div class="text_container"><span>Activada</span></div><input type="text" placeholder="Activación" id ="Simcard_fecha_activacion">
              </div>
              <div class="container">
                  <div class="text_container"><span>Asignada</span></div><p id ="Simcard_fecha_asignacion">Asignación</p>
              </div>
              <div class="container">
                  <div class="text_container"><span>Vence</span></div><input type="text" placeholder="Vencimiento" id ="Simcard_fecha_vencimiento">
              </div>
            </div> 
          <div class="contenedor_acciones">
              <button class="btn azul" onClick="actualizar_simcard()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_simcard()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion administrar simcard -->
  
</div>
<div class="row">
  <!-- Seccion administrar paquetes -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración paquetes</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_paquete"  style="display:none">
        <div class="formulario_busqueda">
          <div>
            <h4>Busque el contenido de un paquete, seleccione una simcard para ver su información, asigne todo el paquete a un responsable oprimiendo "Asignar", eliminelo oprimiendo "Eliminar" o cree un nuevo paquete oprimiendo "Crear".</h4>
          </div>
          <div class="flex_filas">
            <input type="number" placeholder="ICC / número linea" id="Paquete_pista">
            <button class="btn azul" onClick = "buscar_paquete()" type="number" id="Simcard_buscar">Buscar</button>
          </div>
          <h2 id ="titulo_paquete" style="display:none">Paquete #<span id ="numero_paquete"></span></h2>
          <div id="simcards_paquete">
            
          </div> 
          <div class="contenedor_acciones" id="acciones_buscar_paquete" style="display:none">
              <button class="btn verde" onClick = "empaquetar_simcard()" type="number">Empaquetar</button>
              <button class="btn azul" id="boton_seleccionar_responsable_simcard" onClick="seleccionar_responsable_paquete()">Asignar</button>
              <button class="btn rojo" onClick="eliminar_paquete()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion administrar paquetes -->
  
  <!-- Seccion administrar planes -->
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración planes</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_plan" style="display:none">
        <div class="formulario_busqueda">
          <div>
            <h4>Busque la información de un plan digitando su código, modifiquelo oprimiendo "Actualizar", eliminelo oprimiendo "Eliminar" o cree un nuevo plan digitando su información y oprimiendo "Crear".</h4>
          </div>
          <div>
              <input type="text" placeholder="Cod_scl" id ="codigo_plan">
              <button class="btn azul" onClick = "buscar_plan()" type="number" id="Plan_buscar">Buscar</button>
          </div>
          <div class="form">
            <p style="width:100%;text-align:center">Plan: <span id ="Plan_codigo_lbl"></span></p>
            <div class="container">
                <div class="text_container"><span>Minutos</span></div><input type="text" placeholder="Código" id ="Plan_codigo">
            </div>
            <div class="container">
                <div class="text_container"><span>Minutos</span></div><input type="text" placeholder="Minutos" id ="Plan_minutos">
            </div>
            <div class="container">
                <div class="text_container"><span>Datos</span></div><input type="text" placeholder="Datos" id ="Plan_datos">
            </div>
            <div class="container">
                <div class="text_container"><span>Valor</span></div><input type="text" placeholder="Valor" id ="Plan_valor">
            </div>
          </div> 
          
          <div class="contenedor_acciones" id="acciones_buscar_plan">
              <button class="btn verde" onClick="crear_plan()">Crear</button>
              <button class="btn azul" onClick="actualizar_plan()">Actualizar</button>
              <button class="btn rojo" onClick="eliminar_plan()">Eliminar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion administrar paquetes -->
</div>
<!-- /page content -->
@endsection

<!-- Modal -->
@section('contenido_modal')
<p id ="contenido_modal"></p>
<div id="responsables_simcards" style="display:none">
  @foreach ($responsables as $responsable)
    <button class="btn transparente" id='{{$responsable["cedula"]}}' onClick="asignar_responsable_paquete(this.id)">{{$responsable["nombre"]}}</button>
  @endforeach
</div>
<div id="responsables_simcards_crear_paquete" style="display:none">
  @foreach ($responsables as $responsable)
    <button class="btn transparente" id='{{$responsable["cedula"]}}' onClick="crear_paquete(this.id)">{{$responsable["nombre"]}}</button>
  @endforeach
</div>
<div id="planes_simcard_buscar_simcard" style="display:none">
  @foreach ($planes as $plan)
    <button class="btn transparente" id='{{$plan["codigo"]}}' onClick="cambiar_plan_buscar_simcard(this.id)">{{$plan["codigo"]}}</button>
  @endforeach
    <button class="btn transparente" id='SIN PLAN' onClick="cambiar_plan_buscar_simcard(this.id)">SIN PLAN</button>
</div>
@endsection

@section('botones_modal')
<button class="btn transparente" onClick="abrir_modal_responsables()">SI</button>
<button class="btn transparente" onClick="remodal.close();">NO</button>
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/simcard.js"></script>
  <!-- Si es peticion de una simcard desde una peticion GET -->
  @if($simcard!=null)
  <script>
    buscar_simcard({{$simcard}});
  </script>
  @endif
  <!-- Si es peticion de una simcard desde una peticion GET -->
@endsection
