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
<p>Recuerda que una simcard <span class="red">Roja</span> esta Vencida, <span class="blue">Azul</span> esta Disponible y <span class="green">Verde</span> fue Activada.</p>
<!-- Información general -->
<div class="row">
  <!-- Seccion administrar simcard -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Administración simcards</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a onClick="modal_cargar_simcards()"><i class="fa fa-cloud-upload"></i></a></li>
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
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
              <button style="width:20%;margin:0;padding:0;" class="btn azul" onClick = "buscar_simcard()" type="number" id="Simcard_buscar">Buscar</button>
          </div>
          <div class="form">
              <div class="container">
                <div class="text_container"><span>Responsable</span></div><input disabled="true" id="Simcard_responsable" placeholder="Responsable">
              </div>
              <div class="container">
                <div class="text_container"><span>Cliente</span></div><a id ="Simcard_cliente" class="btn transparente">Cliente</a>
              </div>
              <div class="container">
                  <div class="text_container"><span>ICC</span></div><input disabled="true" id ="Simcard_ICC" placeholder="ICC">
              </div>
              <div class="container">
                  <div class="text_container"><span>Línea</span></div><input disabled="true" type="text" placeholder="Número" id ="Simcard_numero_linea">
              </div>
              <div class="container">
                  <div class="text_container"><span>Categoría</span></div><input disabled="true" id ="Simcard_categoria" placeholder="Categoría">
              </div>
              <div class="container">
                <div class="text_container"><span>Equipo</span></div><a id ="Simcard_equipo" class="btn transparente">Equipo</a>
              </div>
              <div class="container">
                  <div class="text_container"><span>Paquete</span></div><input disabled="true" id ="Simcard_paquete" placeholder="Paquete">
              </div>
              <div class="container">
                  <div class="text_container"><span>Plan</span></div><input disabled="true" id ="Simcard_plan"placeholder="Plan">
              </div>
              <div class="container">
                  <div class="text_container"><span>Adjudicada</span></div><input disabled="true" type="text" placeholder="Adjudicación" id ="Simcard_fecha_adjudicacion">
              </div>
              <div class="container">
                  <div class="text_container"><span>Activada</span></div><input disabled="true" type="text" placeholder="Activación" id ="Simcard_fecha_activacion">
              </div>
              <div class="container">
                  <div class="text_container"><span>Asignada</span></div><input disabled="true" id ="Simcard_fecha_asignacion" placeholder="Asignación">
              </div>
              <div class="container">
                  <div class="text_container"><span>Vence</span></div><input disabled="true" type="text" placeholder="Vencimiento" id ="Simcard_fecha_vencimiento">
              </div>
            </div> 
          <div class="contenedor_acciones" style="display:none">
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
          <li><a class="collapse-link"><i id="paquete_chevron" class="fa fa-chevron-down"></i></a>
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
          <div>
            <input type="number" placeholder="ICC / número linea" id="Paquete_pista">
            <button style="margin:0;padding:0;" class="btn azul" onClick = "buscar_paquete()" type="number" id="Simcard_buscar">Buscar</button>
          </div>
          <h2 id ="titulo_paquete" style="display:none">Paquete #<span id ="numero_paquete"></span></h2>
          <div id="simcards_paquete"></div> 
          @if(in_array("PAQUETES",$Actor->lista_permisos) || $Actor->jefe_cedula == null)
          <div class="contenedor_acciones" id="acciones_buscar_paquete" style="display:none">
              <button class="btn verde" onClick = "empaquetar_simcard()" type="number">Empaquetar</button>
              <button class="btn azul" id="boton_seleccionar_responsable_simcard" onClick="seleccionar_responsable_paquete()">Asignar</button>
              <button class="btn rojo" onClick="eliminar_paquete()">Eliminar</button>
          </div>
          @ENDIF
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
          <li><a onClick="modal_cargar_planes()"><i class="fa fa-cloud-upload"></i></a></li>
          <li><a class="collapse-link"><i id="plan_chevron" class="fa fa-chevron-down"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_plan" style="display:none">
        <div class="formulario_busqueda">
          <div>
            <h4>Busque la información de un plan digitando su código, modifiquelo oprimiendo "Actualizar", eliminelo oprimiendo "Eliminar" o cree un nuevo plan digitando su información y oprimiendo "Crear".</h4>
          </div>
          <div>
              <input type="text" placeholder="Código" id ="codigo_plan">
              <button style="margin:0;padding:0;"class="btn azul" onClick = "buscar_plan()" type="number" id="Plan_buscar">Buscar</button>
          </div>
          <div class="form">
            <div class="container">
                <div class="text_container"><span>Código</span></div><input disabled="true" type="text" placeholder="Código" id ="Plan_codigo">
            </div>
            <div class="container">
                <div class="text_container"><span>Minutos</span></div><input disabled="true" type="text" placeholder="Minutos" id ="Plan_minutos">
            </div>
            <div class="container">
                <div class="text_container"><span>Datos</span></div><input disabled="true" type="text" placeholder="Datos" id ="Plan_datos">
            </div>
            <div class="container">
                <div class="text_container"><span>Valor</span></div><input disabled="true" type="text" placeholder="Valor" id ="Plan_valor">
            </div>
          </div> 
          
          <div class="contenedor_acciones" id="acciones_buscar_plan" style="display:none">
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
<div class="flex_filas" id="cargar_simcard_modal">
  {!! Form::open(
      array(
          'route' => 'subirArchivoSimcards', 
          'class' => 'flex_filas', 
          'novalidate' => 'novalidate', 
          'files' => true,
          'style' => 'text-align:center')) !!}
  	
		<input type="file" accept=".xlsx,.csv,.xls" name="archivo_simcard" id="file-2" class="inputfile inputfile-2"/>
  	<label class="transparente" for="file-2"><span>Escoje un archivo&hellip;</span></label>
  	<select id="categoria" name="categoria">
      <option value="Prepago">Prepago</option>
      <option value="Postpago">Postpago</option>
      <option value="Libre">Libre</option>
    </select>
  	<input type="submit" class="btn transparente" value="Subir">
	{!! Form::close() !!}     
</div>

<div class="flex_filas" id="cargar_plan_modal">
  {!! Form::open(
      array(
          'route' => 'subirArchivoPlanes', 
          'class' => 'flex_filas', 
          'novalidate' => 'novalidate', 
          'files' => true,
          'style' => 'text-align:center')) !!}
  	<input type="file" accept=".xlsx,.csv,.xls" name="archivo_plan" id="file-3" class="inputfile inputfile-2"/>
  	<label class="transparente" for="file-3"><span>Escoje un archivo&hellip;</span></label>
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
  <script src="/js/simcard.js"></script>
  <!-- Si es peticion de una simcard desde una peticion GET -->
  @if($simcard!=null)
  <script>
    buscar_simcard({{$simcard}});
  </script>
  @endif
  <!-- Si es peticion de una simcard desde una peticion GET -->
  <!-- Si es peticion de subir archivo desde una petición POST -->
  @if(Session::get('subiendo_archivo') == true)
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("CARGANDO ARCHIVO SIMCARDS");
      $("#contenido_modal").text("Se le enviará un correo con el resultado");
      remodal.open();
    </script>
  @endif
  
  @if(Session('error_archivo'))
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("ERROR CARGANDO ARCHIVO SIMCARDS");
      $("#contenido_modal").text("{{Session('error_archivo')}}");
      remodal.open();
    </script>
  @endif
  <!-- Si es peticion de subir archivo desde una petición POST -->
@endsection
