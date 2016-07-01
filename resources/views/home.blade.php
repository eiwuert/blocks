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
<!-- top tiles -->
<div class="row">
  <div id="estado_financiero_container" class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel tile">
      <div class="x_title">
          <h2>Estado financiero</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
          </ul>
          <div class="clearfix"></div>
        </div>
      <div class="x_content">
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
        <div id="grafico_comisiones"></div>
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
    if(screen.width < 700){
      data.splice(0,2);
    }
    Morris.Bar({
      element: 'grafico_comisiones',
      data: data,
      xkey: 'y',
      ykeys: ['prepago', 'libre','postpago'],
      labels: ['Prepago', 'Libres', 'Postpago'],
      hideHover:"auto",
      resize:true,
      ymax: {{$max_comision}},
      barColors: ["#897FBA", "#ED5784", "#d3d3d3"],
      hoverCallback: function (index, options, content, row) {
        
        return '<div><p style="margin-bottom:3px"><strong>'+ row.y +'</strong></p><p style="margin:0;" class="prepago">Prepago: <span>'+accounting.formatMoney(row.prepago,"$",0)+'</span></p><p  style="margin:0" class="libre">Libre: <span>'+accounting.formatMoney(row.libre,"$",0)+'</span></p><p  style="margin:0" class="postpago">Postpago: <span>'+accounting.formatMoney(row.postpago,"$",0)+'</span></p></div>';
      }
    });
  @endif
  var paquetes = <?php echo json_encode($Actor->paquetes); ?>;;
    
  if(paquetes.length != 0){
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
  }
</script>
@endsection