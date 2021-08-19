@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Productos
@endsection

@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="name" data-sortable="true">Nombre</th>
  <th data-field="category" data-sortable="true">Categoria</th>
  <th data-field="actions" data-events="operateEvents" data-width="80"></th>
@endsection

@section('contentForm')
    {{-- Modal Para Agregar/Modificar uno nuevo --}}
<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1"  data-backdrop="static"  role="dialog" id="modal-register">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title"></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                      <form method="POST" action="{{Request::url()}}" id="frm" class="needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                          <input type="hidden" name="action" id="action" value=""/>
                          <input type="hidden" name="id" id="id" value="0">
                          <div class="form-group">
                              <label for="name">Nombre:</label>                                                               
                              <input type="text" class="form-control" id="name" placeholder="Ingrese el nombre del producto" name="name" required/>
                              <div class="invalid-feedback">
                                Favor de ingresar el nombre del producto
                              </div>
                          </div>
                          <div class="form-group">
                            <label for="categories_id">Categoria de apoyo:</label>
                            <select type="text" class="form-control" id="categories_id" name="categories_id">
                                <option value="">seleccione...</option>
                                @if(isset($categories))
                                    @foreach($categories as $element)
                                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                                    @endforeach
                                @endif
                            </select>
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
  <script src="../assets/js/Product.js"></script>
@endsection