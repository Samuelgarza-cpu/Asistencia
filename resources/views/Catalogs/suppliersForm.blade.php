@extends('base.base')
@section('cssDashboard')
@endsection

@section('text')
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary title-table">{{$title}}</span>
      </div>
    <div class="card-body">
        <form method="POST" action="{{Request::url()}}" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="action" id="action" value="{{$action}}"/>
            @if(isset($supplier))
              <input type="hidden" name="id" id="id" value="{{$supplier['id']}}">
            @else
              <input type="hidden" name="id" id="id" value="0">
            @endif
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="companyname">Nombre o razón social</label>
                @if(isset($supplier))
                  <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Ingrese el nombre del proveedor" required value="{{$supplier['companyname']}}">
                @else
                  <input type="text" class="form-control" id="companyname" name="companyname" placeholder="Ingrese el nombre del proveedor" required>
                @endif
                <div class="invalid-feedback">
                    Favor de ingresar el nombre del proveedor
                </div>
              </div>
              <div class="form-group col-md-2">
                <label for="typeRFC">¿Es persona fisica?</label>
                <div class="custom-control custom-switch">
                  @if(isset($supplier))
                    <input type="checkbox" class="custom-control-input" name="typeRFC" id="typeRFC" {{$supplier['ismoral'] == 1 ? 'checked' : ''}}>
                  @else
                    <input type="checkbox" class="custom-control-input" name="typeRFC" id="typeRFC">
                  @endif
                  <label class="custom-control-label" for="typeRFC">No/Si</label>
                </div>
              </div>
              <div class="form-group col-md-3">
                <label for="RFC">RFC</label>
                @if(isset($supplier))
                  <input type="text" class="form-control" id="RFC" name="RFC" placeholder="Ingrese el RFC" required data-mask="{{$supplier['ismoral'] == 0 ? 'SSS000000AAA' : 'SSSS000000AAA'}}" value="{{$supplier['RFC']}}">
                @else
                  <input type="text" class="form-control" id="RFC" name="RFC" placeholder="Ingrese el RFC" required data-mask="SSS000000AAA">
                @endif
                <div class="invalid-feedback">
                    Favor de ingresar el RFC del proveedor
                </div>
              </div>
              <div class="form-group col-md-2">
                <label for="active">¿Activo?</label>
                <div class="custom-control custom-switch">
                  @if(isset($supplier))
                    <input type="checkbox" class="custom-control-input" name="active" id="active" {{$supplier["active"] == 1 ? 'checked' : ''}}>
                  @else
                    <input type="checkbox" class="custom-control-input" name="active" id="active">
                  @endif
                  <label class="custom-control-label" for="active">No/Si</label>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="email">Correo electrónico</label>
                @if(isset($supplier))
                  <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar correo electrónico" required value="{{$supplier['email']}}">
                @else
                  <input type="text" class="form-control" id="email" name="email" placeholder="Ingresar correo electrónico" required>
                @endif
                <div class="invalid-feedback">
                    Favor de ingresar el correo electrónico del proveedor
                </div>
              </div>
              <div class="form-group col-md-8">
                <label for="description">Descripción</label>
                @if(isset($supplier))
                  <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar el giro y descripción del proveedor" required value="{{$supplier['description']}}"/>
                @else
                  <input type="text" class="form-control" id="description" name="description" placeholder="Ingresar el giro y descripción del proveedor" required/>
                @endif
                <div class="invalid-feedback">
                  Favor de ingresar la descripción del negocio del proveedor
                </div>
              </div>
            </div>
            <hr>
            <div>
              <span class="m-0 font-weight-bold text-primary title-table">Dirección(es)
                  <button type="button" id="addAddress" class="btn btn-primary float-right">Agregar</button>
              </span>
              @if(isset($supplier))
                <input type="hidden" name="countAddress" id="countAddress" value="{{$supplier['countAddress']}}">
                <input type="hidden" name="countTotalA" id="countTotalA" value="{{$supplier['countAddress']}}">
              @else
                <input type="hidden" name="countAddress" id="countAddress" value="1">
                <input type="hidden" name="countTotalA" id="countTotalA" value="1">
              @endif
            </div>
            <hr>
            <div class="headerAppend">Dirección Principal</div>
              @if(isset($supplier))
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="street1">Calle</label>
                    <input type="text" class="form-control" id="street1" name="street1" placeholder="Ingresar la calle" required value="{{$supplier['addresses']['street1']}}">
                    <div class="invalid-feedback">
                      Favor de ingresar la calle de la dirección del proveedor
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="externalNumber1">Número externo</label>
                    <input type="text" class="form-control" id="externalNumber1" name="externalNumber1" placeholder="Ingresar el número externo" required value="{{$supplier['addresses']['externalNumber1']}}">
                    <div class="invalid-feedback">
                      Favor de ingresar el número externo de la dirección del proveedor
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="internalNumber1">Número interno</label>
                    <input type="text" class="form-control" id="internalNumber1" name="internalNumber1" placeholder="Ingresar el número interno" value="{{$supplier['addresses']['internalNumber1']}}">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="postalCode1">Código Postal</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="postalCode1" name="postalCode1" placeholder="Ingresa tú numero postal" required data-mask="00000" value="{{$supplier['addresses']['postalCode1']}}">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="filterCP(this)" id="filter1">Filtrar</button>
                      </div>
                      <div class="invalid-feedback">
                        Favor de ingresar el código postal de la dirección del proveedor
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="communities_id1">Colonia</label>
                    <select id="communities_id1" name="communities_id1" class="form-control" required>
                      @if(isset($supplier['addresses']['communities1']))
                        @foreach($supplier['addresses']['communities1'] as $element)
                          <option value="{{$element['id']}}" {{$element['id'] == $supplier['addresses']['communities_id1'] ? 'selected' : '' }}>{{$element['name']}}</option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="municipalities_id1">Municipio</label>
                    <select id="municipalities_id1" name="municipalities_id1" class="form-control" disabled required>
                      @if(isset($supplier))
                          <option value="{{$supplier['addresses']['municipalities_id1']}}">{{$supplier['addresses']['municipalities_name1']}}</option>
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="states_id1">Estado</label>
                    <select id="states_id1" name="states_id1" class="form-control" disabled required>
                      @if(isset($supplier))
                          <option value="{{$supplier['addresses']['states_id1']}}">{{$supplier['addresses']['states_name1']}}</option>
                      @endif
                    </select>
                  </div>
                </div>
                @for($i = 2 ; $i <= $supplier['countAddress'];$i++)
                  <div id="{{'fDA-'.$i}}">
                    <hr>
                    <div class="headerAppend">Dirección {{$i}}
                      <button type="button" id="{{'deleteAddress-'.$i}}" class="btn float-right" onclick="deleteAddress(this)">
                        <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                      </button>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-3">
                        <label for="{{'street'.$i}}">Calle</label>
                        <input type="text" class="form-control" id="{{'street'.$i}}" name="{{'street'.$i}}" placeholder="Ingresar la calle" required value="{{$supplier['addresses']['street'.$i]}}">
                        <div class="invalid-feedback">
                          Favor de ingresar la calle de la dirección del proveedor
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="{{'externalNumber'.$i}}">Número externo</label>
                        <input type="text" class="form-control" id="{{'externalNumber'.$i}}" name="{{'externalNumber'.$i}}" placeholder="Ingresar el número externo" required value="{{$supplier['addresses']['externalNumber'.$i]}}">
                        <div class="invalid-feedback">
                          Favor de ingresar el número externo de la dirección del proveedor
                        </div>
                      </div>
                      <div class="form-group col-md-3">
                        <label for="{{'internalNumber'.$i}}">Número interno</label>
                        <input type="text" class="form-control" id="{{'internalNumber'.$i}}" name="{{'internalNumber'.$i}}" placeholder="Ingresar el número interno" value="{{$supplier['addresses']['internalNumber'.$i]}}">
                      </div>
                      <div class="form-group col-md-3">
                        <label for="{{'postalCode'.$i}}">Código Postal</label>
                        <div class="input-group">
                          <input type="text" class="form-control" id="{{'postalCode'.$i}}" name="{{'postalCode'.$i}}" placeholder="Ingresa tú numero postal" required data-mask="00000" value="{{$supplier['addresses']['postalCode'.$i]}}">
                          <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="filterCP(this)" id="{{'filter'.$i}}">Filtrar</button>
                          </div>
                          <div class="invalid-feedback">
                            Favor de ingresar el código postal de la dirección del proveedor
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="{{'communities_id'.$i}}">Colonia</label>
                        <select id="{{'communities_id'.$i}}" name="{{'communities_id'.$i}}" class="form-control" required>
                          @if(isset($supplier))
                            @foreach($supplier['addresses']['communities'.$i] as $element)
                              <option value="{{$element['id']}}" {{ ( $element['id'] == $supplier['addresses']['communities_id'.$i]) ? 'selected' : '' }}>{{$element['name']}}</option>
                            @endforeach
                          @endif
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="{{'municipalities_id'.$i}}">Municipio</label>
                        <select id="{{'municipalities_id'.$i}}" name="{{'municipalities_id'.$i}}" class="form-control" disabled required>
                          @if(isset($supplier))
                            <option value="{{$supplier['addresses']['municipalities_id'.$i]}}" selected>{{$supplier['addresses']['municipalities_name'.$i]}}</option>
                          @endif
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="{{'states_id'.$i}}">Estado</label>
                        <select id="{{'states_id'.$i}}" name="{{'states_id'.$i}}" class="form-control" disabled required>
                          @if(isset($supplier))
                            <option value="{{$supplier['addresses']['states_id'.$i]}}" selected>{{$supplier['addresses']['states_name'.$i]}}</option>
                          @endif
                        </select>
                      </div>
                    </div>
                  </div>
                @endfor
                <div id="addresses"></div>
              @else
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="street1">Calle</label>
                    <input type="text" class="form-control" id="street1" name="street1" placeholder="Ingresar la calle" required>
                    <div class="invalid-feedback">
                      Favor de ingresar la calle de la dirección del proveedor
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="externalNumber1">Número externo</label>
                    <input type="text" class="form-control" id="externalNumber1" name="externalNumber1" placeholder="Ingresar el número externo" required>
                    <div class="invalid-feedback">
                      Favor de ingresar el número externo de la dirección del proveedor
                    </div>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="internalNumber1">Número interno</label>
                    <input type="text" class="form-control" id="internalNumber1" name="internalNumber1" placeholder="Ingresar el número interno">
                  </div>
                  <div class="form-group col-md-3">
                    <label for="postalCode1">Código Postal</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="postalCode1" name="postalCode1" placeholder="Ingresa tú numero postal" required data-mask="00000">
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="filterCP(this)" id="filter-1">Filtrar</button>
                      </div>
                      <div class="invalid-feedback">
                        Favor de ingresar el código postal de la dirección del proveedor
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="communities_id1">Colonia</label>
                    <select id="communities_id1" name="communities_id1" class="form-control" disabled required>
                        <option value="">Seleccione...</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="municipalities_id1">Municipio</label>
                    <select id="municipalities_id1" name="municipalities_id1" class="form-control" disabled required>
                      <option value="">Seleccione...</option>
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="states_id1">Estado</label>
                    <select id="states_id1" name="states_id1" class="form-control" disabled required>
                      <option value="">Seleccione...</option>
                    </select>
                  </div>
                </div>
                <div id="addresses"></div>
              @endif
            <hr>
            <div>
              <span class="m-0 font-weight-bold text-primary title-table">Teléfono(s)<span class="table-add float-right">
                <button id="addPhoneNumber" type="button" class="btn btn-primary float-right">Agregar</button>
              </span>
              @if(isset($supplier))
                <input type="hidden" name="countPhoneNumber" id="countPhoneNumber" value="{{$supplier['countPhoneNumber']}}">
                <input type="hidden" name="countTotalPN" id="countTotalPN" value="{{$supplier['countPhoneNumber']}}">
              @else
                <input type="hidden" name="countPhoneNumber" id="countPhoneNumber" value="1">
                <input type="hidden" name="countTotalPN" id="countTotalPN" value="1">
              @endif
            </span>
            </div>
            <hr>
            <div class="headerAppend">Teléfono Principal</div>
            @if(isset($supplier))
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="phonenumber1">Número telefónico</label>
                  <input type="text" class="form-control" id="phonenumber1" name="phonenumber1" placeholder="Ingresar número telefónico" required data-mask="000-000-0000" value="{{$supplier['phonesNumbers']['phoneNumber1']}}">
                  <div class="invalid-feedback">
                    Favor de ingresar el número telefónico del proveedor
                  </div>
                </div>
                <div class="form-group col-md-2">
                  <label for="ext">Extension (opcional)</label>
                  <input type="text" class="form-control" id="ext1" name="ext1" placeholder="Ingresar la extensión (opcional)" data-mask="Ext: 0000" value="{{$supplier['phonesNumbers']['ext1']}}">
                </div>
                <div class="form-group col-md-6">
                  <label for="ext">Descripción</label>
                  <input type="text" class="form-control" id="description1" name="description1" placeholder="Ingresar departamento de la línea" value="{{$supplier['phonesNumbers']['description1']}}" required>
                  <div class="invalid-feedback">
                    Favor de ingresar el departamento de la línea
                  </div>
                </div>
              </div>
              @for($a = 2 ; $a <= $supplier['countPhoneNumber'];$a++)
                <div id="{{'fD-'.$a}}">
                  <hr>
                  <div class="headerAppend">Número Telefónico {{$a}}
                    <button type="button" id="{{'deletePhoneNumber-'.$a}}" class="btn float-right" onclick="deletePhoneNumber(this)">
                      <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                    </button>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="{{'phonenumber'.$a}}">Número telefónico</label>
                      <input type="text" class="form-control" id="{{'phonenumber'.$a}}" name="{{'phonenumber'.$a}}" placeholder="Ingresar número telefónico" required data-mask="000-000-0000" value="{{$supplier['phonesNumbers']['phoneNumber'.$a]}}">
                      <div class="invalid-feedback">
                        Favor de ingresar el número telefónico del proveedor
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="{{'ext'.$a}}">Extension (opcional)</label>
                      <input type="text" class="form-control" id="{{'ext'.$a}}" name="{{'ext'.$a}}" placeholder="Ingresar la extensión (opcional)" data-mask="Ext: 0000" value="{{$supplier['phonesNumbers']['ext'.$a]}}">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="{{'description'.$a}}">Descripción</label>
                      <input type="text" class="form-control" id="{{'description'.$a}}" name="{{'description'.$a}}" placeholder="Ingresar departamento de la línea" value="{{$supplier['phonesNumbers']['description'.$a]}}" required>
                      <div class="invalid-feedback">
                        Favor de ingresar el departamento de la línea
                      </div>
                    </div>
                  </div>
                </div>
              @endfor
              <div id="phoneNumbers"></div>
            @else
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="phonenumber1">Número telefónico</label>
                  <input type="text" class="form-control" id="phonenumber1" name="phonenumber1" placeholder="Ingresar número telefónico" required data-mask="000-000-0000">
                  <div class="invalid-feedback">
                    Favor de ingresar el número telefónico del proveedor
                  </div>
                </div>
                <div class="form-group col-md-2">
                  <label for="ext">Extension (opcional)</label>
                  <input type="text" class="form-control" id="ext1" name="ext1" placeholder="Ingresar la extensión (opcional)" data-mask="Ext: 0000">
                </div>
                <div class="form-group col-md-6">
                  <label for="ext">Descripción</label>
                  <input type="text" class="form-control" id="description1" name="description1" placeholder="Ingresar departamento de la línea" required>
                  <div class="invalid-feedback">
                    Favor de ingresar el departamento de la línea
                  </div>
                </div>
              </div>
              <div id="phoneNumbers"></div>
            @endif
            <a href="proveedores"  class="btn btn-primary float-right">Cancelar</a>
            <button type="submit" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar</button>
          </form>
    </div>
</div>

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
  <script src="../assets/js/mainForm.js"></script>
  <script src="../assets/js/SupplierForm.js"></script>
@endsection
