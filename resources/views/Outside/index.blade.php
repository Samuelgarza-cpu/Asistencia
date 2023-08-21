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

        <title>SISTEMA DE APOYOS</title>
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
                          <h1 class="h2 text-gray-900 mb-4">Sistema de Apoyos</h1>
                        </div>
                      <form class="user" method="POST" action="/loggingIn">
                        @csrf
                        <div class="form-group">
                            @if(isset($CName))
                              <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Ingresa tu usuario" value="{{$CName}}">
                          @else
                            <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Ingresa tu usuario">
                          @endif
                          </div>
                          <div class="form-group">
                            @if(isset($CPass))
                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Ingresa tu contraseña" value="{{$CPass}}">
                            @else
                            <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Ingresa tu contraseña">
                            @endif
                          </div>
                          {{-- <div class="form-group">
                            <div class="custom-control custom-checkbox small">
                                @if((isset($CName) || isset($CPass)) && !(($CName) == null || $CPass==null) )
                                <input type="checkbox" class="custom-control-input" id="customCheck" name='customCheck' checked>
                              @else
                                <input type="checkbox" class="custom-control-input" id="customCheck" name='customCheck'>
                              @endif
                              <label class="custom-control-label" for="customCheck">Recordarme</label>
                            </div>
                          </div> --}}
                          <button type="submit" class="btn btn-primary btn-user btn-block">
                            Login
                          </button>
                          @if(session('success'))
                             {{session('success')}}
                          @endif
                        </form>
                        <hr>
                        {{--<div class="text-center">
                          <a class="small" href="/reset">¿Olvidaste tu contraseña?</a>
                        </div>--}}
                      </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block" align="center"><img class="redimension" src="../assets/img/Logo-GP2225.png"></div>
                    <!-- <div class="col-lg-6 d-none d-lg-block" align="center"><img class="redimension" src="../assets/img/Logo_Dif.png"></div>-->
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
