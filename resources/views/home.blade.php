@extends('layout.app')

@section('Custom_css')
<!-- iCheck -->
<link href="/css/green.css" rel="stylesheet">

<!-- jVectorMap -->
<link href="/css/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
@endsection

@section('Content')
<!-- Información general -->
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
<!-- Información general -->
@endsection