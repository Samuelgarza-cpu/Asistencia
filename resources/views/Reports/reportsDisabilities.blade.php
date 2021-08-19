@extends('base.base')
@section('cssDashboard')
<link href="../assets/css/bootstrap-table.min.css" rel="stylesheet">
@endsection

@section('text')
@endsection

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <form method="POST" action="{{Request::url()}}" id="frm-filter" class="needs-validation" novalidate>
      @csrf
      <div class="form-row align-items-center">
        <h1>
          Reporte de Discapacidades
        </h1>
      </div>
      <div class="form-row">
        <div class="form-group col-md-2">
          <label for="from">Desde:</label>
          <input class="form-control" type="date" name="from" id="from" required/>
        </div>
        <div class="form-group col-md-2">
          <label for="until">Hasta:</label>
          <input class="form-control" type="date" name="until" id="until" required/>
        </div>
        <div class="form-group col-md-3">
          <label for="catdisabilities_id">Categoría de la Discapacidad:</label>
          <select type="text" class="form-control" id="catdisabilities_id" name="catdisabilities_id">
              <option value="0">Todos</option>
              @if(isset($disabilitiescategory))
                  @foreach($disabilitiescategory as $element)
                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                  @endforeach
              @endif
          </select>
        </div>
        <div class="form-group col-md-3">
          <label for="disability_id">Discapacidad:</label>
          <select type="text" class="form-control" id="disability_id" name="disability_id">
              <option value="0">Todos</option>
              @if(isset($disabilities))
                @foreach($disabilities as $element)
                  <option value="{{$element['id']}}">{{$element['name']}}</option>
                @endforeach
              @endif
          </select>
        </div>
        <div class="form-group col-md-2">
          <label for="area">Area:</label>
          <input class="form-control" type="text" name="area" id="area"/>
        </div>
      </div>
      <div class="form-row">
          <div class="form-group col-md-12">
            <button type="button" class="btn btn-secondary btn-rounded btn-busca-inf float-right" id="btnBuscar"  onclick="buscarInf()" title="Buscar">
              <i class="fas fa-search"></i> Buscar
              </button>    
            <button type="submit" class="btn btn-primary btn-filter-zone btn-excel float-right" id="btnExcel" style="margin-right: .5rem;" name="btn" title="Exportar a Excel" value ="excel">
              <i class="fas fa-file-excel"></i> Exportar a Excel
            </button>
             <button type="submit" class="btn btn-primary btn-filter-zone btn-pdfm float-right" style="margin-right: .5rem;" id="btnPDF" name="btn" title="Exportar a PDF" value="PDF">
            <i class="fas fa-file-pdf"></i>Exportar a PDF
          </button>
        </div>
      </div>
    </form>

    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="dataTable" data-search="true" data-pagination="true" data-show-toggle="true" data-click-to-select="true" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th data-field="number" data-sortable="true">#</th>
              <th data-field="folio" data-sortable="true">Folio</th>
              <th data-field="date" data-sortable="true">Fecha</th>
              <th data-field="personalData" data-sortable="true">Nombre</th>
              <th data-field="fulladdress" data-sortable="true">Dirección</th>
              <th data-field="curp" data-sortable="true">CURP</th>
              <th data-field="disabilityCategory">Categoria Discapacidad</th>
              <th data-field="disability">Discapacidad</th>
              <th data-field="area">Área</th>
              <th data-field="actions" data-events="operateEvents" data-width="80"></th>
            </tr>
          </thead>
        </table>
      </div>
  </div>
</div>
</div>
<!-- Diagrama de solicitudes Mensual -->
<div class="col-xl-4 col-lg-4">
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header text-center">
      <h6 class="m-0 font-weight-bold text-primary text-center">Gráfica por Categoría de Discapacidad</h6>
    </div>
  </div>
  <div class="card-body">
    <div class="chart-pie pt-4 pb-2">
      <canvas id="myPieChart1"></canvas>
    </div>
    <div id="legend1" name="legend1" class="mt-4 text-center small">      
      @foreach($defaultLegend1 as $value)        
        <span class='mr-2'><i class='fas fa-circle' style="color:{{$value['color']}}"> </i>{{$value['name']}} </span>         
      @endforeach
    </div>  
  </div>
</div>

<div class="col-xl-4 col-lg-4">
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header text-center">
      <h6 class="m-0 font-weight-bold text-primary">Gráfica por Discapacidad</h6>
    </div>
  </div>
  <div class="card-body">
    <div class="chart-pie pt-4 pb-2">
      <canvas id="myPieChart2"></canvas>
    </div>
    <div id="legend2" name="legend2" class="mt-4 text-center small">
      @foreach($defaultLegend2 as $value)        
        <span class='mr-2'><i class='fas fa-circle' style="color:{{$value['color']}}"> </i> {{$value['name']}}</span>         
      @endforeach 
    </div>  
  </div>
</div>

<div class="col-xl-4 col-lg-4">
  <div class="card shadow mb-4">
    <!-- Card Header - Dropdown -->
    <div class="card-header text-center">
      <h6 class="m-0 font-weight-bold text-primary">Gráfica por Area</h6>
    </div>
  </div>
  <div class="card-body">
    <div class="chart-pie pt-4 pb-2">
      <canvas id="myPieChart3"></canvas>
    </div>
    <div id="legend3" name="legend3" class="mt-4 text-center small">
      @foreach($defaultLegend3 as $value)        
        <span class='mr-2'><i class='fas fa-circle' style="color:{{$value['color']}}"> </i>{{$value['name']}} </span>         
      @endforeach      
    </div>  
  </div>
</div>
@endsection


@section('jsDashboard')
  {{-- Bootstrap table --}}
  <script src="../assets/js/bootstrap-table.min.js"></script>
  <script src="../assets/js/bootstrap-table-locale-all.min.js"></script>
  <script>   
    var names1 = [];    
    @foreach($defaultNames1 as $value)
      names1.push('{{$value}}');
    @endforeach

    var data1 = [];
    @foreach($defaultData1 as $value)
      data1.push('{{$value}}');
    @endforeach

    var bgcolor1 = [];
    @foreach($defaultbgColor1 as $value)
      bgcolor1.push('{{$value}}');
    @endforeach

    var hbgcolor1 = [];
    @foreach($defaulthbgColor1 as $value)
      hbgcolor1.push('{{$value}}');
    @endforeach

    var names2 = [];
    @foreach($defaultNames2 as $value)
      names2.push('{{$value}}');
    @endforeach
    var data2 = [];
    @foreach($defaultData2 as $value)
      data2.push('{{$value}}');
    @endforeach

    var bgcolor2 = [];
    @foreach($defaultbgColor2 as $value)
      bgcolor2.push('{{$value}}');
    @endforeach

    var hbgcolor2 = [];
    @foreach($defaulthbgColor2 as $value)
      hbgcolor2.push('{{$value}}');
    @endforeach

    var names3 = [];
    @foreach($defaultNames3 as $value)
      names3.push('{{$value}}');
    @endforeach
    var data3 = [];
    @foreach($defaultData3 as $value)
      data3.push('{{$value}}');
    @endforeach

    var bgcolor3 = [];
    @foreach($defaultbgColor3 as $value)
      bgcolor3.push('{{$value}}');
    @endforeach

    var hbgcolor3 = [];
    @foreach($defaulthbgColor3 as $value)
      hbgcolor3.push('{{$value}}');
    @endforeach
  </script>
  <script src="../assets/js/Reports.js"></script>
@endsection
