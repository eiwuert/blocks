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
            <p>Recuerda que <span class="red">Rojo</span> es Vencida, <span class="blue">Azul</span> es Disponible y <span class="green">Verde</span> es Activada.</p>
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top">Total Prepago</span>
              <div>
                  <span class="count blue">{{$Total_prepago}}</span>
                  <span class="count green">{{$Total_prepago_activas}}</span>
                  <span class="count red">{{$Total_prepago_vencidas}}</span>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top">Total Libres</span>
              <div>
                  <span class="count blue">{{$Total_libres}}</span>
                  <span class="count green">{{$Total_libres_activas}}</span>
                  <span class="count red">{{$Total_libres_vencidas}}</span>
              </div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top">Total Postpago</span>
              <div>
                  <span class="count">{{$Total_postpago}}</span>
              </div>
            </div>
          </div>
          <!-- /top tiles -->
          <!-- Seccion buscar simcard -->
            <div class="buscar_simcard">
              <div class="responsables_simcard">
                <h1>Posibles Responsables</h1>
                @foreach ($responsables as $responsable)
                    <button class="btn">{{$responsable["nombre"]}}</button>
                @endforeach
              </div>
              <div class="formulario_busqueda">
                <h1>Administración simcards</h1>
                <div>
                  <p>Busque una simcard, actualicela modificando los valores blancos en los bloques y oprimiendo "Actualizar", asignela oprimiendo "Asignar" o eliminela oprimiendo "Eliminar".</p>
                </div>
                <div>
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
                        <div class="text_container"><span>Adjudicada</span></div><input type="text" placeholder="Adjudicada" id ="Simcard_fecha_adjudicacion">
                    </div>
                    <div class="container">
                        <div class="text_container"><span>Activada</span></div><input type="text" placeholder="Activada" id ="Simcard_fecha_activacion">
                    </div>
                    <div class="container">
                        <div class="text_container"><span>Vence</span></div><input type="text" placeholder="Vence" id ="Simcard_fecha_vencimiento">
                    </div>
                  </form> 
                <div>
                    <button class="btn btn-primary" onClick="actualizar_simcard()">Actualizar</button>
                    <button class="btn btn-danger" onClick="eliminar_simcard()">Eliminar</button>
                    <button class="btn btn-success" onClick="seleccionar_responsable_simcard()">Asignar</button>
                </div>
              </div>
            </div>
          <!-- Seccion buscar simcard -->
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