@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Productos del proveedor
@endsection

@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="product" data-sortable="true">Nombre</th>
  <th data-field="cost" data-sortable="true">Precio</th>
  <th data-field="status" data-sortable="true">¿Activo?</th>
  <th data-field="created_date" data-sortable="true">Fecha creación</th>
  <th data-field="updated_date" data-sortable="true">Fecha modificación</th>
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
                      <form method="POST" action="{{Request::url()}}" id="frm" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="action" id="action" value=""/>
                        <input type="hidden" name="id" id="id" value="0">
                        <div class="form-group">
                            <label for="products_id">Producto</label>
                            <div class="input-group">
                                <select type="text" class="form-control" id="products_id" name="products_id">
                                    <option value="">seleccione...</option>
                                    @if(isset($products))
                                        @foreach($products as $element)
                                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="input-group-append">
                                <a class="modal-link" id="modal-link">agregar nuevo producto</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Precio:</label>
                            <input type="text" class="form-control" id="price" placeholder="Ingrese el precio del producto" name="price" data-mask="########0.00" required/>
                            <div class="invalid-feedback">
                                Favor de ingresar el precio del producto
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

{{-- Modal para agregar un producto nuevo en caso de que no exista --}}
<div class="row">
    <div class="col-md-12">
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-register-product">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{Request::url()}}" id="frm-product" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="action" id="action2" value=""/>
                            <input type="hidden" name="idProduct" id="idProduct" value="0">
                            <div class="form-group">
                                <label for="supports_id2">Apoyo:</label>
                                <select type="text" class="form-control" id="supports_id2" name="supports_id2">
                                    <option value="">seleccione...</option>
                                    @if(isset($supports))
                                        @foreach($supports as $element)
                                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="categories_id">Categoria:</label>
                                <select type="text" class="form-control" id="categories_id" name="categories_id">
                                    <option value="">seleccione...</option>
                                    @if(isset($categories))
                                        @foreach($categories as $element)
                                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nameProduct">Nombre del Producto:</label>
                                <input type="text" class="form-control" id="nameProduct" placeholder="Ingrese el nombre del producto" name="nameProduct" required/>
                                <div class="invalid-feedback">
                                    Favor de ingresar el nombre del producto
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="saveProduct" class="btn btn-primary">Guardar</button>
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
<script>
    var idProveedor = {{$id}};
</script>
<script src="../assets/js/supplierProduct.js"></script>
@endsection

