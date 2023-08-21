@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Solicitudes
@endsection
@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="folio" data-sortable="true">Folio</th>
  <th data-field="typerequest" data-sortable="true">Tipo</th>
  <th data-field="beneficiaries" data-sortable="true">Beneficiarios</th>
  <th data-field="beneficiariesCurp" data-sortable="true">CURP</th>
  <th data-field="beneficiariesNumber">Teléfono</th>
  <th data-field="address">Domicilio</th>
  <th data-field="products">Productos</th>
  <th data-field="status">Estado</th>
  <th data-field="actions" data-events="operateEvents" data-width="80"></th>
@endsection

@section('contentForm')
{{-- Modal de autorización o rechazo --}}
<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1" role="dialog" id="modal-confirmation-request">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 id="title-modal-confirmation"></h4>
                      <button type="button" class="close" data-dismiss="modal-confirmation" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body" id="mensaje-modal-body">
                      <form method="POST" action="{{Request::url()}}" id="frm-confirmation">
                        @csrf
                          <input type="hidden" name="action" id="action4" value=""/>
                          <input type="hidden" name="registerId" id="registerRId" value="0">
                          ¿Está usted seguro de querer realizar esta acción?
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

<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1" role="dialog" id="modal-addDocument">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 id="title-modal">Anexar Documento</h4>
                      <button type="button" class="close" data-dismiss="modal-confirmation" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body" id="mensaje-modal-body">
                      <form method="POST" action="{{Request::url()}}" id="frm-addDocument" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                          <input type="hidden" name="action" id="action5" value="addDocument"/>
                          <input type="hidden" name="registerId" id="registerDId" value="0">
                          <div class="form-group files-div">
                            <span class="file document">
                                <input type="file" multiple name="document[]" accept="application/pdf,img/*" id="document" class="form-control" required>
                                <!--<input type="file" name="document" accept="application/pdf" id="document" class="form-control" required>-->
                                <div class="invalid-feedback">
                                    Favor de ingresar el documento de la solicitud
                                </div>
                            </span>
                            <label for="document" class="label-button">
                                <span id="title-dept">Subir el documento de la solicitud</span>
                            </label>
                          </div>
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
<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1" role="dialog" id="modal-addDeliveryPicture">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 id="title-modal">Anexar Imagen de Entrega</h4>
                      <button type="button" class="close" data-dismiss="modal-confirmation" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body" id="mensaje-modal-body">
                      <form method="POST" action="{{Request::url()}}" id="frm-addDeliveryPicture" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                          <input type="hidden" name="action" id="action6" value="addDeliveryPicture"/>
                          <input type="hidden" name="registerId" id="registerIId" value="0">
                          <div class="form-group files-div">
                            <span class="file document">
                              <input hidden type="file" name="addDelivery" accept="image/*" id="addDelivery" class="form-control" required>
                              <!--<input type="file" multiple name="document[]" accept="application/pdf,img/*" id="document" class="form-control" required>-->
                              <div class="invalid-feedback">
                                 Favor de ingresar la imagen de entrega
                              </div>
                            </span>
                            <label for="addDelivery" class="label-button">
                                <span id="title-image">Subir la imagen de entrega</span>
                            </label>
                          </div>
                          <!--{-- <div class="form-group" id="activeMain">
                            <label for="active1">¿Se entrego el producto?</label>
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" name="active1" id="active1" >
                              <label class="custom-control-label" for="active1">Deslice a la derecha para activar</label>
                            </div>
                          </div> --}}-->
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
<div class="row">
  <div class="col-md-12">
      <div class="modal fade" tabindex="-1" role="dialog" id="modal-showDocument">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 id="title-modal">Solicitud</h4>
                      <button type="button" class="close" data-dismiss="modal-confirmation" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  </div>
                  <div class="modal-body">
                    <label>PRODUCTO</label>
                    <button type="submit" class="btn btn-primary" id="confirmation">Confirmar</button>
                      <!--<embed src= 'https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885_1280.jpg' id="embedx" type="application/pdf" width="30%" height="600px"/>-->
                      <embed src= "/document-0R4CO2FNO351.pdf" id="embedx" type="application/pdf"/>
                      <!--<embed src="" id="embedx" type="application/pdf"/> -->
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

@section('jsForm')
  <!-- <script src="https://cdn.jsdelivr.net/npm/pdf-merger-js@3.0.5/"></script>-->
  <script src="../assets/js/Request.js"></script>
@endsection
