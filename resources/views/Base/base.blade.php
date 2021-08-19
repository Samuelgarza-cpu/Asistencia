<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- Imagen del sistema --}}
  <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicon.png">
  {{-- Fonts --}}
  <link href="../assets/fonts/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"/>
  {{-- CSS --}}
  <link href="../assets/css/alertify.min.css" rel="stylesheet"/>
  <link href="../assets/css/alertify.rtl.min.css" rel="stylesheet"/>

  <link href="../assets/css/mainstyles.css" rel="stylesheet"/>
  <link href="../assets/css/styles.css" rel="stylesheet" />
  @yield('cssDashboard')
  <title>SISTEMA DE ASISTENCIA</title>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <a class="navbar-brand" href="/">Sistema de Asistencia</a>
      <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
      <!-- Navbar-->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group" style="display: none;">
          <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button"><svg class="svg-inline--fa fa-search fa-w-16" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path></svg><!-- <i class="fas fa-search"></i> Font Awesome fontawesome.com --></button>
          </div>
        </div>
      </form>
      <ul class="navbar-nav ml-auto ml-md-0">
        {{-- <!-- Nav Item - User Information -->
        <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Cerrar sesión
        </a> --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{'perfil/'.session('user_id')}}">Perfil</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout">Cerrar Sessión</a>
            </div>
        </li>
      </ul>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
            <div class="nav">

              <div class="sb-sidenav-menu-heading"><i class="fas fa-home fa-fw"></i>Dashboard</div>
              @if (session('user_agent')=='Admin'|| session('user_agent')=='CoordiAsSo'||session('user_agent')=='DirGen'||session('user_agent')=='Cont')
              <a class="nav-link" href="/dashboard">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Dashboard
              </a>
              @endif
              @if (session('user_agent')=='Admin'|| session('user_agent')=='CoordiAsSo'||session('user_agent')=='DirGen'||session('user_agent')=='Cont'||session('user_agent')=='TrSo')
              <a class="nav-link" href="/solicitudes">
                <div class="sb-nav-link-icon"><i class="far fa-id-badge"></i></div>Solicitudes
              </a>
              @endif
              <div class="sb-sidenav-menu-heading"><i class="fas fa-cogs fa-fw"></i>Operacional</div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                Cátalogos
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                 @if (session('user_agent')=='Admin')
                  <a class="nav-link" href="/institutos"><i class="far fa-building icon-margin-right"></i>Instituciones</a>
                  <a class="nav-link" href="/departamentos"><i class="fas fa-warehouse icon-margin-right"></i>Departamentos</a>
                  <a class="nav-link" href="/roles"><i class="fas fa-user-secret icon-margin-right"></i>Roles</a>
                  <a class="nav-link" href="/ocupaciones"><i class="fas fa-user-tie icon-margin-right"></i>Ocupaciones</a>
                  <a class="nav-link" href="/categorias"><i class="fas fa-cash-register icon-margin-right"></i>Categorias</a>
                  <a class="nav-link" href="/materialesConstruccion"><i class="fas fa-ruler-combined icon-margin-right"></i>Materiales de Construccion</a>
                  <a class="nav-link" href="/servicios"><i class="fas fa-faucet icon-margin-right"></i>Servicios</a>
                  <a class="nav-link" href="/muebles"><i class="fas fa-couch icon-margin-right"></i>Muebles</a>
                  <a class="nav-link" href="/categoria-diagnostico"><i class="fab fa-creative-commons-sampling-plus icon-margin-right"></i>Categoria de Diagnostico</a>
                  <a class="nav-link" href="/diagnostico"><i class="fas fa-file-contract icon-margin-right"></i>Diagnostico</a>
                  <a class="nav-link" href="/estados_solicitud"><i class="fas fa-paste icon-margin-right"></i>Estados de Solicitud</a>
                  <a class="nav-link" href="/apoyos"><i class="fas fa-hands icon-margin-right"></i>Apoyos</a>
                  @endif
                  @if (session('user_agent')=='Admin'||session('user_agent')=='TrSo'||session('user_agent')=='Cont'||session('user_agent')=='DirGen')
                  <a class="nav-link" href="/proveedores"><i class="fas fa-truck icon-margin-right"></i>Proveedores</a>
                  <a class="nav-link" href="/productos"><i class="fas fa-box-open icon-margin-right"></i>Productos</a>
                  @endif
                </nav>
              </div>
              @if (session('user_agent')=='Admin')
              <div class="sb-sidenav-menu-heading"><i class="fas fa-tools fa-fw"></i>Configuracion</div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="false" aria-controls="collapseSetting">
                <div class="sb-nav-link-icon"><i class="fas fa-laptop-code"></i></div>
                Sistema
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapseSetting" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="/usuarios"><i class="fas fa-users icon-margin-right"></i>Usuarios</a>
                    </nav>
              </div>
              <div class="sb-sidenav-menu-heading"><i class="far fa-handshake fa-fw"></i>Relaciones</div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRelations" aria-expanded="false" aria-controls="collapseRelations">
                <div class="sb-nav-link-icon"><i class="fas fa-network-wired"></i></div>
                Relacionar
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapseRelations" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                      <a class="nav-link" href="/productos_apoyos"><i class="fas fa-cubes icon-margin-right"></i>Categoría del Apoyo</a>
                      <a class="nav-link" href="/apoyos_departamento"><i class="fas fa-landmark icon-margin-right"></i>Apoyos del Departamento</a>
                      <a class="nav-link" href="/instituto_departamento"><i class="fas fa-sitemap icon-margin-right"></i>Departamento del Instituto</a>
                    </nav>

              </div>
            @endif
              @if (session('user_agent')=='Admin'||session('user_agent')=='Soport')
              <div class="sb-sidenav-menu-heading"><i class="far fa-file-alt fa-fw"></i>Bitacoras</div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                 Bitacoras
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                  <a class="nav-link" href="/bitacora_errores"><i class="fas fa-bug icon-margin-right"></i>Bitácora de errores</a>
                  <a class="nav-link" href="/bitacora_correos"><i class="far fa-envelope icon-margin-right"></i>Bitácora de correos</a>
                </nav>
              </div>
              @endif              
              @if (session('user_agent')=='Admin'||session('user_agent')=='TrSo'||session('user_agent')=='Cont'||session('user_agent')=='DirGen')
              <div class="sb-sidenav-menu-heading"><i class="fas fa-home fa-fw"></i>Reportes</div>
              <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="false" aria-controls="collapsePages">
                <div class="sb-nav-link-icon"><i class="far fa-folder-open"></i></div>
                  Reportes
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
              </a>
              <div class="collapse" id="collapseReports" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                  <a class="nav-link" href="/reporte_solicitudes"><i class="fas fa-clipboard icon-margin-right"></i>Reporte de Solicitudes</a>
                  <a class="nav-link" href="/reporte_discapacidades"><i class="fas fa-clipboard icon-margin-right"></i>Reporte de Discapacidades</a>                  
                </nav>
              </div>             
              @endif
            </div>
          </div>
          <div class="sb-sidenav-footer">
            <div class="small">Ingresado cómo:</div>
            {{session('user')}}
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        <main>
            @yield('text')
          <div class="row">
            @yield('content')
          </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between small">
              <div class="text-muted">Copyright &copy; Presidencia Municipal de Gómez Palacio 2019-2022</div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" id="modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cerrar sesión</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">¿Está usted seguro de querer cerrar la sesión?</div>
          <div class="modal-footer">
            <a class="btn btn-primary" href="/logout">Salir</a>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>

          </div>
        </div>
      </div>
    </div>
    {{-- Jquery //Necesario para usar bootstrap 4 o inferior --}}
    <script src="../assets/js/jquery.min.js"></script>
    {{-- Bootstrap --}}
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    {{-- Externos Plugins --}}
    <script src="../assets/js/jquery.easing.min.js"></script>
    <script src="../assets/js/alertify.min.js"></script>

    <script src="../assets/js/jquery.mask.min.js"></script>
    <script src="../assets/js/Chart.min.js"></script>
    {{-- Base de otras páginas JS --}}
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/mainForm.js"></script>
    @yield('jsDashboard')
    <script src="../assets/js/scripts.js"></script>
  </body>
</html>
