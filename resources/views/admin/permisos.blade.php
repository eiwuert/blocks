@extends('layout.app')

@section('Custom_css')

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Permisos de usuarios</h2>
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
              <th>Usuario</th>
              <th>Inventarios</th>
              <th>Archivos</th>
            </tr>
          </thead>

          <tbody id="principal_table">
            @foreach($actores as $actor)
            <tr id="{{$actor->user->email}}">
              <td><a href="/personal?cedula={{$actor->cedula}}">{{$actor->nombre}}</a></td>
              <td>{{$actor->user->email}}</td>
              @if(in_array("INVENTARIOS", $actor->permisos))
              <td><input type="checkbox" name="Inventarios" value="INVENTARIOS" checked></td>
              @else
              <td><input type="checkbox" name="Inventarios" value="INVENTARIOS"></td>
              @endif
              
              @if(in_array("ARCHIVOS", $actor->permisos))
              <td><input type="checkbox" name="Archivos" value="ARCHIVOS" checked></td>
              @else
              <td><input type="checkbox" name="Archivos" value="ARCHIVOS"></td>
              @endif
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="contenedor_acciones" style="width:100%;text-align:center;">
          <button id="boton_guardar" class="btn verde" onClick="guardar_permisos()">Guardar</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

<!-- Modal -->
@section('contenido_modal')
<p id ="contenido_modal"></p>
@endsection

@section('Custom_js')
<script src="/js/permisos.js"></script>
<!-- Datatables -->
<script>
  
</script>
<!-- /Datatables -->
@endsection