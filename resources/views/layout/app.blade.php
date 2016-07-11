<!DOCTYPE html>
<html lang="en" class="no-js">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blocks</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-select.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    @if($Actor->jefe_cedula == null)
    <link href="/css/custom_admin.min.css" rel="stylesheet">
    @else
    <link href="/css/custom.min.css" rel="stylesheet">
    @endif
    <link href="/css/general.css" rel="stylesheet">
    
    <!-- Charts Style -->
    <link href="/css/morris.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    
    <!-- Modal library css -->
    <link rel="stylesheet" href="/css/remodal.css">
    <link rel="stylesheet" href="/css/remodal-default-theme.css">
    <!-- Input File css-->
		<link rel="stylesheet" type="text/css" href="/css/component.css" />
    <!-- remove this if you use Modernizr -->
		<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

    @yield('Custom_css')
    
    
    
  </head>
    <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="/" class="site_title"><i class="fa fa-cubes"></i> <span>Blocks!</span></a>
            </div>

            <div class="clearfix"></div>

            <br />
            @if($Actor->jefe_cedula == null)
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Bienvenido</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-cube"></i> Inventarios <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="link_simcards"><a href="/simcard">Simcards</a></li>
                      <li id="link_equipos"><a href="/equipo">Equipos</a></li>
                      <li><a href="index3.html">Servicios</a></li>
                      <li id="link_reportes_inventario"><a href="/reportes_inventario">Reportes</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-users"></i> Gestión <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="link_clientes"><a href="/cliente">Clientes</a></li>
                      <li id="link_personal"><a href="/personal">Personal</a></li>
                      <li id="link_control_vendedores"><a href="/control_vendedores">Control Vendedores</a></li>
                      <li id="link_reportes_personal"><a href="/reportes_personal">Reportes</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-bank"></i> Finanzas <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li id="link_clientes"><a href="/cliente">Comisiones</a></li>
                      <li id="link_cartera"><a href="/cartera">Cartera</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
            @else
            <!-- sidebar menu -->
              <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                <div class="menu_section">
                  <h3>Bienvenido</h3>
                  <ul class="nav side-menu">
                    <li><a><i class="fa fa-cube"></i> Inventarios <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="link_simcards"><a href="/simcard">Simcards</a></li>
                        <li id="link_equipos"><a href="/equipo">Equipos</a></li>
                        <li><a href="index3.html">Servicios</a></li>
                      </ul>
                    </li>
                    <li><a><i class="fa fa-users"></i> Gestión <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="link_clientes"><a href="/cliente">Clientes</a></li>
                        <li id="link_personal"><a href="/personal">Personal</a></li>
                        <li id="link_control_vendedores"><a href="/control_vendedores">Control Vendedores</a></li>
                      </ul>
                    </li>
                    <li><a><i class="fa fa-bank"></i> Finanzas <span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li id="link_clientes"><a href="/cliente">Comisiones</a></li>
                        <li id="link_cartera"><a href="/cartera">Cartera</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- /sidebar menu -->
            @endif
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
                  <p id="user_nombre" style="display:none">{{$Actor->nombre}}</p>
                  <p id="user_cedula" style="display:none">{{$Actor->cedula}}</p>
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    {{$Actor->nombre}}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="/personal?cedula={{$Actor->cedula}}"> Perfil</a></li>
                    <li><a href="/cartera?nombre={{$Actor->nombre}}"> Cartera</a></li>
                    <li><a href="auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    @if(count($notificaciones) > 0)
                      <span id="numero_notificaciones_container">
                        <span id="numero_notificaciones" class="badge bg-green">{{count($notificaciones)}}</span>
                      </span>
                    @endif
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    @foreach($notificaciones as $notificacion)
                      <li>
                        <a>
                          <p>
                            @if($notificacion->exito)
                              <strong>EXITO</strong>
                            @else
                              <strong>FALLA</strong>
                            @endif
                            <span>
                              <i class="fa fa-close" id="{{$notificacion->ID}}" style="float:right" onclick='borrar_notificacion(this.id)'></i>
                            </span>
                          </p>
                          <span>{{$notificacion->descripcion}}</span>
                        </a>
                      </li>
                    @endforeach
                    <li style="display:none"></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          @yield('Content')
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
    
    <div class="remodal" data-remodal-id="modal">
      <button data-remodal-action="close" class="remodal-close"></button>
      <h1 id="titulo_modal">@yield('Titulo modal')</h1>
      @yield('contenido_modal')
      <div id="botones_modal">
      @yield('botones_modal')
      </div>
    </div>
    
    <!-- jVectorMap -->
    <script src="/js/jquery-jvectormap-2.0.3.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="/js/moment.min.js"></script>
    <script src="/js/daterangepicker.js"></script>

    <!-- Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-select.js"></script>
    <!-- FastClick -->
    <script src="/js/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/js/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/js/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="/js/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="/js/skycons.js"></script>
    <!-- Modal library Script -->
    <script src="/js/remodal.js"></script>
    <script src="/js/jquery.confirm.min.js"></script>
    <!-- Input File Script-->
    <script src="js/custom-file-input.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="/js/custom.min.js"></script>
    <script src="/js/general.js"></script>
    <!-- Number format Script -->
    <script src="/js/accounting.min.js"></script>
    <!-- Charts Script -->
    <script src="/js/Raphael.min.js"></script>
    <script src="/js/morris.min.js"></script>
    <!-- Background Image Script -->
    <script src="/js/backstretch.min.js"></script>
    <!-- Datatables Script -->
    <script src="/js/jquery.dataTables.min.js"></script>
    <script src="/js/dataTables.bootstrap.min.js"></script>
    
    <script type="text/javascript">
      $.confirm.options = {
          title: "",
          confirmButton: "Si",
          cancelButton: "No",
          post: false,
          submitForm: false,
          confirmButtonClass: "verde sin_margen",
          cancelButtonClass: "rojo sin_margen",
          dialogClass: "modal-dialog"
      } 
    </script>
    @yield('Custom_js')
  </body>
</html>