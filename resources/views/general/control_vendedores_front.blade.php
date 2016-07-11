<!DOCTYPE html>
<html lang="en" style="height:100%">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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

    <!-- Custom Theme Style -->
    <link href="/css/custom.min.css" rel="stylesheet">
    <link href="/css/general.css" rel="stylesheet">
    <link href="/css/control_vendedores.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    
    <!-- Modal library css -->
    <link rel="stylesheet" href="/css/remodal.css">
    <link rel="stylesheet" href="/css/remodal-default-theme.css">
    <!-- Input File css-->
		<link rel="stylesheet" type="text/css" href="/css/component.css" />

    <!-- GOOGLE LOCATION API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
</head>

<body id="page-top" class="index" style="background:#85C1F5;height:100%">
    
    <div id="container_control">
        <div style="width:100%">
          <h3 style="text-align:center">Digita tu cedula y presiona ENVIAR</h3>
          <div style="width:100%">
            <input id ="cedula" class ="data" type="number" style="background:none; border: 1px solid #FFF; color:white;font-size:20px;text-align:center"></input>
          </div>
          <button class ="btn verde" style="margin-top:10px" onClick ="enviar_ubicacion()">Enviar</button>
        </div>
    </div>
    <div id ="demo"></div>
    
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
    <!-- Background Image Script -->
    <script src="/js/backstretch.min.js"></script>
    <!-- CUSTOM JS -->
    <script src="js/control_vendedores_front.js"></script>

</body>

</html>