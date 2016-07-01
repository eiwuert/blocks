@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">
<!-- Custom css -->
<link href="/css/home.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<!-- Información general -->
<p>Recuerda que una simcard <span class="red">Roja</span> esta Vencida, <span class="blue">Azul</span> esta Disponible y <span class="green">Verde</span> fue Activada.</p>
<!-- top tiles -->
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
          <h2>Estado financiero</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
      <div class="x_content" id="buscar_simcard">
        @if($estado_financiero >= 0)
          <h2 class="green" style="margin:0">Tienes un saldo a favor de <a href="/cartera?nombre={{$Actor->nombre}}" class="green">${{number_format($estado_financiero)}}</a></h2>
        @else
          <h2 class="red" style="margin:0">Tienes un saldo en contra de <a href="/cartera?nombre={{$Actor->nombre}}" class="red">- ${{number_format($estado_financiero*-1)}}</a></h2>
        @endif
      </div> 
    </div> 
  </div> 
</div>
<div class="row">
  <div class="col-md-8 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
          <h2>Historico Comisiones</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
      <div class="x_content" id="buscar_simcard">
        <div style="min-height:490px;" id="grafico_comisiones"></div>
      </div> 
    </div> 
  </div> 
  <div class="col-md-4 col-sm-12 col-xs-12">
    <div class="row">
      <div class="x_panel tile">
        <div class="x_title">
            <h2>Estado Simcards Prepago</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
        <div class="x_content">
            <div style="max-height:200px;" id="grafico_estado_prepago"></div>
        </div> 
      </div> 
      <div class="x_panel tile">
        <div class="x_title">
            <h2>Estado Simcards Libre</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
          </div>
        <div class="x_content">
            <div style="max-height:200px;" id="grafico_estado_libre"></div>
        </div> 
      </div> 
    </div>
  </div>
</div>




          
<!-- Información general -->
@endsection

@section('Custom_js')
<script>
  @if($comisiones != null)
    var data = <?php echo json_encode($comisiones); ?>;
    console.log(data);
    Morris.Bar({
      element: 'grafico_comisiones',
      data: data,
      xkey: 'y',
      ykeys: ['prepago', 'libre','postpago'],
      labels: ['Prepago', 'Libres', 'Postpago'],
      hideHover:"auto",
      resize:true,
      ymax: {{$max_comision}},
    });
  @endif
  Morris.Donut({
    element: 'grafico_estado_prepago',
    data: [
      {label: "Vencidas", value: {{$Total_prepago_vencidas}}},
      {label: "Activas", value: {{$Total_prepago_activas}}},
      {label: "Disponibles", value: {{$Total_prepago}}}
    ],
    colors: ["#DB5466","#7FCA9F", "#85C1F5"],
    resize:true
  });
  Morris.Donut({
    element: 'grafico_estado_libre',
    data: [
      {label: "Vencidas", value: {{$Total_libres_vencidas}}},
      {label: "Activas", value: {{$Total_libres_activas}}},
      {label: "Disponibles", value: {{$Total_libres}}}
    ],
    colors: ["#DB5466","#7FCA9F", "#85C1F5"],
    resize:true
  });

</script>
@endsection