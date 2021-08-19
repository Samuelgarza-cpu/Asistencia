<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Imagen del sistema --}}
        <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
        {{-- Fonts --}}
        <link href="../assets/css/font-awesome.min.css" type="text/css"/>
        {{-- CSS --}}
        <link href="../assets/css/alertify.min.css" rel="stylesheet"/>
        <link href="../assets/css/alertify.rtl.min.css" rel="stylesheet"/>
        <link href="../assets/css/mainstyles.css" rel="stylesheet"/>

        <title>RECUPERAR CONTRASEÑA</title>
    </head>
    <body class="bg-gradient-primary">
      <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
              <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="p-5">
                        <div class="text-center">
                          <h1 class="h2 text-gray-900 mb-4">Recuperar Contraseña</h1>
                        </div>

                        @if(count($errors)>0)
                       <div class="alert alert-danger" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                                 @endforeach
                            </ul>
                        </div>
                        @endif

                      <form class="user" method="POST" action="/reset">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Ingresa tu Email">
                          </div>
                          <button type="submit" class="btn btn-primary btn-user btn-block">
                            Recuperar
                          </button>

                          <hr>
                        </form>
                        @if (session('success'))

                          <p>{{session('success')}}</p>


                        @endif
                        <hr>
                      </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block"><img class="main-logo-image" src="../assets/img/logotipo.png"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/jquery.easing.min.js"></script>
        <script src="../assets/js/alertify.min.js"></script>
        <script src="../assets/js/main.js"></script>
      </body>
      </html>
