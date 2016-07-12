@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Asignación inventario</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="datatable" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Prepago</th>
                <th>Libre</th>
                <th>Postpago</th>
                <th>Equipos</th>
              </tr>
            </thead>

            <tbody>
              @foreach($actores as $actor)
              <tr>
                <td><a href="/personal?cedula={{$actor->cedula}}">{{$actor->nombre}}</a></td>
                <td>{{$actor->cantidad_prepago}}</td>
                <td>{{$actor->cantidad_libre}}</td>
                <td>{{$actor->cantidad_postpago}}</td>
                <td>{{$actor->cantidad_equipo}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('Custom_js')
<script src="/js/reportes_inventario.js"></script>
<!-- Datatables -->
<script>
  $(document).ready(function() {
    $('#datatable').dataTable();
  });
</script>
<!-- /Datatables -->
@endsection