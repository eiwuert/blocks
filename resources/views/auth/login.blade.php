@extends('layout.app')

@section('Content')
  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="POST" action="/auth/login">
              {!! csrf_field() !!}
              <h1>Ingresar</h1>
              <div>
                <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required="" />
              </div>
              @if (count($errors) > 0)
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
              @endif
              <div>
                <button type="submit" class="btn btn-default submit" href="index.html">Ingresar</button>
                <a class="reset_pass" href="#">¿Olvidó su contraseña?</a>
              </div>
            
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">¿Nuevo en el sitio?
                  <a href="#signup" class="to_register"> Crear Cuenta </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-cubes"></i> Blocks!</h1>
                  <p>©2016 All Rights Reserved. </p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form method="POST" action="/auth/register">
              {!! csrf_field() !!}
              <h1>Registrar Cuenta</h1>
              <div>
                <input type="text" name="Actor_cedula" class="form-control" placeholder="Cedula" required="" />
              </div>
              <div>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button type="submit" class="btn btn-default submit" href="index.html">Crear</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">¿Ya eres miembre?
                  <a href="#signin" class="to_register"> Ingresar </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-cubes"></i> Blocks!</h1>
                  <p>©2016 All Rights Reserved.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
@endsection