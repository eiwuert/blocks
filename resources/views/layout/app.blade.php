<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blocks</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/css/custom.min.css" rel="stylesheet">
    <link href="/css/general.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="/js/jquery.min.js"></script>
    
    <!-- Modal library css -->
    <link rel="stylesheet" href="/css/remodal.css">
    <link rel="stylesheet" href="/css/remodal-default-theme.css">
    @yield('Custom_css')
    
    
    
  </head>

    @yield('Content')
    
    <div class="remodal" data-remodal-id="modal">
      <button data-remodal-action="close" class="remodal-close"></button>
      <h1 id="titulo_modal">@yield('Titulo modal')</h1>
      @yield('contenido_modal')

      @yield('botones_modal')
    </div>
    <!-- Bootstrap -->
    <script src="/js/bootstrap.min.js"></script>
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
    <!-- Custom Theme Scripts -->
    <script src="/js/custom.min.js"></script>
    <!-- Modal library Script -->
    <script src="/js/remodal.js"></script>
    @yield('Custom_js')
</html>