@extends('base.base')
@section('cssDashboard')
@endsection

@section('text')
<strong>Dashboard</strong>

@endsection

@section('content')

<!-- Solicitudes Pendiente Anexo Archivos -->
<div class="col-xl-2 col-md-6 mb-3">
    <div class="card border-left-paa shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Solicitudes Pendiente Anexo Archivos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sPAA}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Solicitudes Entregadas Pendientes de Autorizar -->
<div class="col-xl-2 col-md-6 mb-3">
    <div class="card border-left-apv shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Solicitudes Autorizada - Pendiente Verificacion</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sAPV }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Solicitudes Autorizada - Pendiente Factura -->
<div class="col-xl-2 col-md-6 mb-3">
    <div class="card border-left-apf shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Solicitudes Autorizada - Pendiente Factura</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$sAPF}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- Solicitudes Rechazada -->
<div class="col-xl-2 col-md-6 mb-3">
    <div class="card border-left-rechazadas shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Solicitudes Rechazada</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sR}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
     
<!-- Solicitudes Finalizadas -->
<div class="col-xl-2 col-md-12 mb-3">
    <div class="card border-left-finalizadas shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Solicitudes Finalizadas</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sF}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Solicitudes Cancelada -->
<div class="col-xl-2 col-md-6 mb-3">
    <div class="card border-left-canceladas shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Solicitudes Cancelada</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sC}}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-fw fa-file-alt fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- Diagrama de solicitudes Mensual -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Solicitudes Mensuales</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="chart-pie pt-4 pb-2">
                <canvas id="myPieChart"></canvas>
            </div>
          
            <div class="mt-4 text-center small">
                <span class="mr-2">
                    <i class="fas fa-circle text-paa"></i> Pendiente Anexo Archivos
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-apv"></i> Autorizada - Pendiente Verificacion
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-apf"></i> Autorizada - Pendiente Factura
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-rechazada"></i> Rechazada
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-cancelada"></i> Cancelada
                </span>
                <span class="mr-2">
                    <i class="fas fa-circle text-finalizada"></i> Finalizadas
                </span>
            </div>
        </div>
    </div>
 <!-- Tipo de solicitud -->
 <div class="col-xl-6 col-lg-6">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tipo de solicitudes Mensual</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="chart-pie pt-4 pb-2">
            <canvas id="myPieChart2"></canvas>
        </div>
        <div class="mt-4 text-center small">
            <span class="mr-2">
                <i class="fas fa-circle text-primary"></i>Trabajo Social
            </span>
            <span class="mr-2">
                <i class="fas fa-circle text-success"></i>Responsiva
            </span>
            <span class="mr-2">
                <i class="fas fa-circle text-warning"></i>Foliado
            </span>
            <span class="mr-2">
                <i class="fas fa-circle text-primary"></i>Solicitud
            </span>
        </div>
    </div>
 </div>

@endsection

@section('jsDashboard')
<script>
    var sPAA = {{$sPAA}};
    var sAPV = {{$sAPV}};
    var sAPF = {{$sAPF}};
    var sR = {{$sR}};
    var sF = {{$sF}};
    var sC = {{$sC}};

    var sT1 = {{$sT1}};
    var sT2 = {{$sT2}};
    var sT3 = {{$sT3}};
    var sT4 = {{$sT4}};
</script>
<script src="../assets/js/Dashboard.js"></script>
@endsection
