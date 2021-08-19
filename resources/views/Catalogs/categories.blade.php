@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Categorias
@endsection

@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="name" data-sortable="true">Nombre</th>
  <th data-field="status" data-sortable="true">Estado</th>
  <th data-field="actions" data-events="operateEvents" data-width="80"></th>
@endsection

@section('contentForm')
    {{-- Modal Para Agregar/Modificar uno nuevo --}}
<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1" data-backdrop="static"  role="dialog" id="modal-register">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="{{Request::url()}}" id="frm" class="needs-validation" novalidate>
                        @csrf
                          <input type="hidden" name="action" id="action" value=""/>
                          <input type="hidden" name="id" id="id" value="0">
                          <div class="form-group">
                              <label for="name">Nombre:</label>                                                               
                              <input type="text" class="form-control" id="name" placeholder="Ingrese el nombre de la categoria" name="name" required/>
                              <div class="invalid-feedback">
                                Favor de ingresar el nombre de la categoria
                              </div>
                          </div>
                          <div class="form-group" id="activeMain">
                            <label for="active">¿Activo?</label>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" name="active" id="active" checked>
                              <label class="custom-control-label" for="active">Deslice a la derecha para activar</label>
                            </div>                  
                          </div>
                  </div>
                  <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" id="save">Guardar</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button> 
                  </div>
                </form>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('jsForm')
  <script src="../assets/js/Category.js"></script>
@endsection