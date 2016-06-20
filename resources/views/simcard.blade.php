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
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/" class="site_title"><i class="fa fa-cubes"></i> <span>Blocks!</span></a>
            </div>

            <div class="clearfix"></div>

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-tablet"></i> Inventarios <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="/simcard">Simcards</a></li>
                      <li><a href="index2.html">Equipos</a></li>
                      <li><a href="index3.html">Servicios</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{$Actor_nombre}}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profile</a></li>
                    <li>
                      <a href="javascript:;">
                        <span class="badge bg-red pull-right">50%</span>
                        <span>Settings</span>
                      </a>
                    </li>
                    <li><a href="javascript:;">Help</a></li>
                    <li><a href="auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    @if($Cantidad_notificaciones > 0)
                    <span class="badge bg-green">{{$Cantidad_notificaciones}}</span>
                    @endif
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
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
                
                <div class="x_content" id="buscar_simcard" style="display:none">  
                  <div class="formulario_busqueda">
                    <div>
                      <h4>Busque una simcard, actualicela modificando los valores blancos en los bloques y oprimiendo "Actualizar", asignela oprimiendo "Asignar" o eliminela oprimiendo "Eliminar".</h4>
                    </div>
                    <div class="contenedor_pista">
                        <input type="number" placeholder="ICC / número linea" id="Simcard_pista">
                        <button class="btn btn-primary busqueda" onClick = "buscar_simcard()" type="number" id="Simcard_buscar">Buscar</button>
                    </div>
                    <form>
                        <div class="container">
                          <div class="text_container"><span>Responsable</span></div><p id="Simcard_responsable">Responsable</p>
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
                            <div class="text_container"><span>Plan</span></div><button id ="Simcard_plan" onClick="seleccionar_plan()">Plan</button>
                        </div>
                        <div class="container">
                            <div class="text_container"><span>Adjudicada</span></div><input type="text" placeholder="Adjudicación" id ="Simcard_fecha_adjudicacion">
                        </div>
                        <div class="container">
                            <div class="text_container"><span>Activada</span></div><input type="text" placeholder="Activación" id ="Simcard_fecha_activacion">
                        </div>
                        <div class="container">
                            <div class="text_container"><span>Entrega</span></div><p id ="Simcard_fecha_asignacion">Asignación</p>
                        </div>
                        <div class="container">
                            <div class="text_container"><span>Vence</span></div><input type="text" placeholder="Vencimiento" id ="Simcard_fecha_vencimiento">
                        </div>
                      </form> 
                    <div class="contenedor_acciones">
                        <button class="btn btn-primary" onClick="actualizar_simcard()">Actualizar</button>
                        <button class="btn btn-danger" onClick="eliminar_simcard()">Eliminar</button>
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
                    <div>
                        <input type="number" placeholder="ICC / número linea" id="Paquete_pista">
                        <button class="btn btn-primary busqueda" onClick = "buscar_paquete()" type="number" id="Simcard_buscar">Buscar</button>
                        <button class="btn btn-primary busqueda" onClick = "empaquetar_simcard()" type="number">Empaquetar</button>
                        <button class="btn btn-primary busqueda" onClick = "boton_crear_paquete()" type="number">Crear</button>
                    </div>
                    <h2 id ="titulo_paquete" style="display:none">Paquete #<span id ="numero_paquete"></span></h2>
                    <div class="contenedor_simcards_paquete" id="simcards_paquete">
                      
                    </div> 
                    <div class="contenedor_acciones" id="acciones_buscar_paquete" style="display:none">
                        <button class="btn btn-success" id="boton_seleccionar_responsable_simcard" onClick="seleccionar_responsable_paquete()">Asignar</button>
                        <button class="btn btn-danger" onClick="eliminar_paquete()">Eliminar</button>
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
                      <h4>Busque la información de un plan.</h4>
                    </div>
                    <div>
                        <input type="text" placeholder="Cod_scl" id ="codigo_plan">
                        <button class="btn btn-primary busqueda" onClick = "buscar_plan()" type="number" id="Simcard_buscar">Buscar</button>
                    </div>
                    <form>
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
                    </form> 
                    
                    <div class="contenedor_acciones" id="acciones_buscar_plan">
                        <button class="btn btn-success" onClick="crear_plan()">Crear</button>
                        <button class="btn btn-primary" onClick="actualizar_plan()">Actualizar</button>
                        <button class="btn btn-danger" onClick="eliminar_plan()">Eliminar</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Seccion administrar paquetes -->
          </div>
          <!-- Modal -->
          @section('contenido_modal')
          <p id ="contenido_modal"></p>
          <div id="responsables_simcards" style="display:none">
            @foreach ($responsables as $responsable)
              <button class="btn boton_responsable" id='{{$responsable["cedula"]}}' onClick="asignar_responsable_paquete(this.id)">{{$responsable["nombre"]}}</button>
            @endforeach
          </div>
          <div id="responsables_simcards_crear_paquete" style="display:none">
            @foreach ($responsables as $responsable)
              <button class="btn boton_responsable" id='{{$responsable["cedula"]}}' onClick="crear_paquete(this.id)">{{$responsable["nombre"]}}</button>
            @endforeach
          </div>
          <div id="planes_simcard_buscar_simcard" style="display:none">
            @foreach ($planes as $plan)
              <button class="btn boton_responsable" id='{{$plan["codigo"]}}' onClick="cambiar_plan_buscar_simcard(this.id)">{{$plan["codigo"]}}</button>
            @endforeach
              <button class="btn boton_responsable" id='SIN PLAN' onClick="cambiar_plan_buscar_simcard(this.id)">SIN PLAN</button>
          </div>
          @endsection
          <!-- Modal -->
        </div>
        <!-- /page content -->
      </div>
    </div>

    <!-- jVectorMap -->
    <script src="/js/jquery-jvectormap-2.0.3.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="/js/moment.min.js"></script>
    <script src="/js/daterangepicker.js"></script>

    @section('Custom_js')
      <script src="/js/simcard.js"></script>
    @endsection
  </body>
@endsection