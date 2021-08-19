@extends('base.base')
@section('cssDashboard')
<link href="../assets/css/bootstrap-table.min.css" rel="stylesheet">
<link href="../assets/css/bootstrap.colorpickersliders.css" rel="stylesheet">
@yield('cssForm')
@endsection

@section('text')
@if (session('message'))
    <div class="alert alert-warning">
        {{ session('message') }}
    </div>
@endif
{{-- @if($errors->any())
  <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div><br />
  @endif --}}
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
      <a id="return" class="text-success" data-toggle="tooltip" data-placement="left" title="Regresar" >
        <i class="fas fa-arrow-left fa-2x" aria-hidden="true"></i>
      </a>
      <span class="m-0 font-weight-bold text-primary title-table">@yield('titleTable')</span>
      <span class="table-add float-right">
        <a id="add" class="text-success" data-toggle="tooltip" data-placement="left" title="Registrar Nuevo">
          <i class="fas fa-plus fa-2x" aria-hidden="true"></i>
        </a>
      </span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" data-toggle="dropdown" id="dataTable" data-search="true" data-pagination="true" data-show-fullscreen="true" data-show-columns="true" data-show-columns-toggle-all="true" data-show-toggle="true" data-click-to-select="true" width="100%" cellspacing="0">
          <thead>
            <tr>
              @yield('headerTable')
            </tr>
          </thead>
        </table>
      </div>
    </div>
</div>
@yield('contentForm')
{{-- Modal de confirmación de eliminación --}}
<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1" role="dialog" id="modal-confirmation">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4>Eliminar Registro</h4>
                      <button type="button" class="close" data-dismiss="modal-confirmation" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="{{Request::url()}}" id="frm-delete">
                        @csrf
                          <input type="hidden" name="action" id="action3" value="delete"/>
                          <input type="hidden" name="registerId" id="registerId" value="0">
                          ¿Está usted seguro de querer eliminar este registro?
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" id="confirmation">Confirmar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  </div>
                </form>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('jsDashboard')
  {{-- Bootstrap table --}}
  <script src="../assets/js/bootstrap-table.min.js"></script>
  <script src="../assets/js/bootstrap-table-locale-all.min.js"></script>
  <script src="../assets/js/tinycolor-min.js"></script>
  
  <script src="../assets/js/bootstrap.colorpickersliders.js"></script>
  {{-- Principal --}}
  <script src="../assets/js/mainForm.js"></script>
  @if (session('success'))
  <script>
    success();
  </script>
  @endif

@yield('jsForm')
@endsection
