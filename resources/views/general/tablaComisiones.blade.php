@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- Custom_css -->
<link href="/css/tabla_comision.css" rel="stylesheet">

<link href="/css/table.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>

@endsection

@section('Content')

@if($Actor->jefe == null)
<!-- Seccion tabla valores -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Tabla Valores</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content" id="comisiones_empleado">  
          
      </div>
    </div>
  </div>
<!-- Seccion tabla valores -->
</div>  
@endif

<!-- Seccion tabla comisiones -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
        <h2>Tabla Comisiones</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content" id="comisiones_empleado">  
        <select class="selectpicker" data-width="50%" data-style="data" id ="tipo_comision" style="min-width:220px">
          <option>Natural</option>
          <option>Empresa</option>
        </select>
        <div class="panel panel-primary filterable" id ="tabla_natural">
            <div class="panel-heading">
                <h3 class="panel-title">Persona Natural</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Tipo" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Banda Ancha" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Linea Basica" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Televisión" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Total" disabled></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($BA_Natural as $BA)
                  <tr>
                    <td>{{$BA->descripcion}}</td>
                    <td>${{number_format($BA->valor)}}</td>
                    <td>${{number_format($LB_Natural->valor)}}</td>
                    <td>${{number_format($TV_Natural->valor)}}</td>
                    <td>${{number_format($BA->valor + $LB_Natural->valor + $TV_Natural->valor)}}</td>
                  </tr>
                  @endforeach 
                  @foreach($TV_Otros_Natural as $TV)
                  <tr>
                    <td>{{$TV->descripcion}}</td>
                    <td></td>
                    <td></td>
                    <td>${{number_format($TV->valor)}}</td>
                    <td>${{number_format($TV->valor)}}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  @foreach($LB_Otros_Natural as $LB)
                  <tr>
                    <td>{{$LB->descripcion}}</td>
                    <td></td>
                    <td>${{number_format($LB->valor)}}</td>
                    <td></td>
                    <td>${{number_format($LB->valor)}}</td>
                    <td></td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="panel panel-primary filterable" id ="tabla_empresa">
            <div class="panel-heading">
                <h3 class="panel-title">Pymes</h3>
                <div class="pull-right">
                    <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr class="filters">
                        <th><input type="text" class="form-control" placeholder="Tipo" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Banda Ancha" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Linea Basica" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Televisión" disabled></th>
                        <th><input type="text" class="form-control" placeholder="Total" disabled></th>
                    </tr>
                </thead>
                <tbody>
                  @foreach($BA_Empresa as $BA)
                  <tr>
                    <td>{{$BA->descripcion}}</td>
                    <td>${{number_format($BA->valor)}}</td>
                    <td>${{number_format($LB_Empresa->valor)}}</td>
                    <td>${{number_format($TV_Empresa->valor)}}</td>
                    <td>${{number_format($BA->valor + $LB_Empresa->valor + $TV_Empresa->valor)}}</td>
                  </tr>
                  @endforeach 
                  @foreach($TV_Otros_Empresa as $TV)
                  <tr>
                    <td>{{$TV->descripcion}}</td>
                    <td></td>
                    <td></td>
                    <td>${{number_format($TV->valor)}}</td>
                    <td>${{number_format($TV->valor)}}</td>
                    <td></td>
                  </tr>
                  @endforeach
                  @foreach($LB_Otros_Empresa as $LB)
                  <tr>
                    <td>{{$LB->descripcion}}</td>
                    <td></td>
                    <td>${{number_format($LB->valor)}}</td>
                    <td></td>
                    <td>${{number_format($LB->valor)}}</td>
                    <td></td>
                  </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
      
        <div class="panel panel-primary filterable" id ="tabla_play">
          <div class="panel-heading">
              <h3 class="panel-title">Movistar Play</h3>
              <div class="pull-right">
                  <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filter</button>
              </div>
          </div>
          <table class="table">
              <thead>
                  <tr class="filters">
                      <th><input type="text" class="form-control" placeholder="Tipo" disabled></th>
                      <th><input type="text" class="form-control" placeholder="Comisión" disabled></th>
                  </tr>
              </thead>
              <tbody>
                @foreach($MP_Natural as $MP)
                <tr>
                  <td>{{$MP->descripcion}}</td>
                  <td>${{number_format($MP->valor)}}</td>
                </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>    
<!-- Seccion tabla comisiones -->

<!-- /page content -->
@endsection

<!-- Modal -->
@section('contenido_modal')
<p id ="contenido_modal"></p>

<div class="flex_filas" id="cargar_comisiones_modal">
  {!! Form::open(
      array(
          'route' => 'subirComisiones', 
          'class' => 'flex_filas', 
          'novalidate' => 'novalidate', 
          'files' => true,
          'style' => 'text-align:center; justify-content:center')) !!}
  	
		<input type="file" accept=".xlsx,.csv,.xls" name="archivo_comision" id="file-3" class="inputfile inputfile-2"/>
  	<label class="transparente" for="file-3"><span>Escoje un archivo&hellip;</span></label>
  	<input type="submit" class="btn transparente" value="Subir">
	{!! Form::close() !!}     
</div>
@endsection

@section('botones_modal')
@endsection
<!-- Modal -->

@section('Custom_js')
  <script src="/js/tabla_comision.js"></script>
  <script src="/js/table.js"></script>
  @if(Session::get('subiendo_archivo') == true)
    <script>
      limpiar_modal();
      modal.addClass("modal_info");
      $("#titulo_modal").text("CARGANDO ARCHIVO COMISIONES");
      $("#contenido_modal").text("Se le notificará cuando haya un resultado");
      remodal.open();
    </script>
  @endif
@endsection
