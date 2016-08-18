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

<div class="row">
  <!-- Seccion administrar descripcion general equipo -->
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Notificacion</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      
      <div class="x_content" id="buscar_equipo_general">  
        <div class="formulario_busqueda">
            @if($notificacion->exito)
              <h4>EXITO</h4>            
              <p>{{$notificacion->descripcion}}</p>
            @else
              <h4>FALLO</h4>            
              <p>{{$notificacion->descripcion}}</p>  
              @foreach($errores as $error)
                <p>{{$error->descripcion}}</p>
              @endforeach
            @endif
        </div>
      </div>
    </div>
  </div>
  <!-- Seccion descripcion general equipo -->
  
</div>
<!-- /page content -->
@endsection

