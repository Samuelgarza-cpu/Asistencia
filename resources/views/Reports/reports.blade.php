@extends('base.base')
@section('cssDashboard')
@yield('cssForm')
@endsection

@section('text')
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <form method="POST" action="{{Request::url()}}" id="frm-filter">
        @csrf
        <div class="form-row">
          <div class="form-group col-md-2">
            <label for="from">Desde:</label>
            <input class="form-control" type="date" name="from" id="from"/>
          </div>
          <div class="form-group col-md-2">
            <label for="until">Hasta:</label>
            <input class="form-control" type="date" name="until" id="until"/>
          </div>
          <div class="form-group col-md-3">
            <label for="supports_id">Categoria de producto:</label>
            <select type="text" class="form-control" id="supports_id" name="supports_id">
                <option value="0">Todos</option>
                @if(isset($supports))
                    @foreach($supports as $element)
                      <option value="{{$element['id']}}">{{$element['name']}}</option>
                    @endforeach
                @endif
            </select>
          </div>
          <div class="form-group col-md-3">
            <label for="products_id">Producto:</label>
            <select type="text" class="form-control" disabled id="products_id" name="products_id">
                <option value="0">Todos</option>
            </select>
          </div>
          <div class="form-group col-md-2">
            <label for="area">Área:</label>
            <input type="text" class="form-control" id="area" name="name"/>
          </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-primary float-right" id="btnExcel" onclick="exportExcel()" title="Exportar a Excel">
                Exportar a Excel
              </button> 
            {{-- <button type="button" class="btn btn-primary btn-filter-zone btn-pdf" id="btnPDF"  onclick="exportPDF()" title="Exportar a PDF">
                Exportar Por PDF
            </button> --}}
          </div>
        </div>
      </form>    
    </div>
    {{-- <div class="card-body">
        {!!$chart->container()!!} --}}
          <!-- Pie Chart -->
          {{-- <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4"> --}}
              {{-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Solicitudes</h6>
                <div class="dropdown no-arrow">
                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Acciones:</div>
            <a class="dropdown-item" href="#"></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </div>
                </div>
              </div> --}}
              <!-- Card Body -->
              {{-- <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                  <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fas fa-circle text-primary"></i> Direct
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle text-success"></i> Social
                  </span>
                  <span class="mr-2">
                    <i class="fas fa-circle text-info"></i> Referral
                  </span>
                </div>
              </div>
            </div>
          </div> --}}
    {{-- </div> --}}
</div>
@yield('contentForm')
@endsection
@section('jsDashboard')
{{-- {!! $chart->script() !!} --}}
{{-- {{-- <!-- Page level custom scripts --> --}}
{{-- <script src="../assets/js/chart-area-demo.js"></script> --}}
<script src="../assets/js/Reports.js"></script>
{{-- <script src="../assets/js/chart-pie-demo.js"></script> --}}
@endsection