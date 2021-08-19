@extends('base.base')
@section('cssDashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<style type="text/css">
  img {
  display: block;
  max-width: 100%;
  }
  .preview {
  overflow: hidden;
  width: 160px;
  height: 160px;
  margin: 10px;
  border: 1px solid red;
  }
  .modal-lg{
  max-width: 1000px !important;
  }
  </style>
@endsection
{{-- @section('text')
@if (session('message'))
    <div class="alert alert-warning">
        {{ session('message') }}
    </div>
@endif
@endsection --}}

@section('content')
<div class="card shadow mb-4">
  <div class="card-header py-3 text-align-center">
    <span class="m-0 font-weight-bold text-primary title-table">Solicitud de apoyo</span>
  </div>
  <div class="card-body">
    <form method="POST" id="formRequest" action="{{Request::url()}}" class="needs-validation" novalidate>
      @csrf
      <input type="hidden" name="action" id="action" value="{{$action}}"/>
      <input type="hidden" name="actionUpdateWork" id="actionUpdateWork" value=""/>
      @if(isset($requisition))
        <input type="hidden" name="id" id="id" value="{{$requisition->id}}">
      @else
        <input type="hidden" name="id" id="id" value="0">
      @endif
      @if(isset($requisition))
        <input type="hidden" name="status_Id" id="status_Id" value="{{$requisition->status_id}}">
      @else
        <input type="hidden" name="status_Id" id="status_Id" value="0">
      @endif
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="requestGeneralData-tab" data-toggle="tab" href="#requestGeneralData" role="tab" aria-controls="requestGeneralData" aria-selected="true">Datos generales de solicitud</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="beneficiaryGeneralData-tab" data-toggle="tab" href="#beneficiaryGeneralData" role="tab" aria-controls="beneficiaryGeneralData" aria-selected="false">Datos generales de beneficiario</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="familySituation-tab" data-toggle="tab" href="#familySituation" role="tab" aria-controls="familySituation" aria-selected="false">Situación familiar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="lifeConditions-tab" data-toggle="tab" href="#lifeConditions" role="tab" aria-controls="lifeConditions" aria-selected="false">Condiciones de vida</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="economicData-tab" data-toggle="tab" href="#economicData" role="tab" aria-controls="economicData" aria-selected="false">Ingresos económicos</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        {{-- requestGeneralData --}}
        <div class="tab-pane fade show active" id="requestGeneralData" role="tabpanel" aria-labelledby="requestGeneralData-tab">
          <br>
          <div class="form-row">
            <div class="form-group col-md-4 files-div">
              @if(isset($requisition))
                <span class="file petitionerImage">
                  <input type="file" name=" " id="petitionerImage" class="form-control imagePetitioner" accept="image/*">
                </span>
                <label id="lblpetitionerImage" name="lblpetitionerImage"  value="{{$requisition->image}}" for="petitionerImage" class="label-img">
                  <span>{{$requisition->image}}</span>
                </label>
              @else
                <span class="file petitionerImage">
                  <input type="file" name="petitionerImage" accept="image/*" id="petitionerImage" class="form-control imagePetitioner" required>
                  <div class="invalid-feedback">
                    Favor de ingresar la imagen del solicitante
                  </div>
                </span>
                <label for="petitionerImage" class="label-img">
                  <span>Subir la imagen del solicitante</span>
                </label>
              @endif
            </div>
            <div class="form-group col-md-6 files-div">
              @if(isset($requisition->imageSRC))
                <img id="imagenPrevisualizacion" src="{{$requisition['imageSRC']}}" class="file-img">
              @else
                <img id="imagenPrevisualizacion" class="file-img">
              @endif
            </div>
          </div>          
          <div class="form-row">
            <div class="form-group col-md-2">
              <label for="date">Fecha de solicitud</label>
              @if(isset($requisition->date))
                <input type="date" class="form-control" value="{{$requisition->date}}" id="date" name="date" required>
              @else
                <input type="date" class="form-control" value="{{date("Y-m-d")}}" id="date" name="date" required>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label for="petitioner">Solicitante</label>
              @if(isset($requisition->petitioner))
                <input type="text" class="form-control" id="petitioner" name="petitioner" placeholder="Ingrese el nombre del solicitante" required value="{{$requisition->petitioner}}">
              @else
                <input type="text" class="form-control" id="petitioner" name="petitioner" placeholder="Ingrese el nombre del solicitante" required>
              @endif
              <div class="invalid-feedback">
                  Favor de ingresar el nombre del solicitante
              </div>
            </div>
            <div class="form-group col-md-6">
              <label for="curpPetitioner">Curp del solicitante</label>
              <div class="input-group">
                @if(isset($requisition->curpPetitioner))
                  <input type="text" class="form-control" id="curpPetitioner1" name="curpPetitioner1" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del solicitante" required value="{{$requisition->curpPetitioner}}">
                @else
                  <input type="text" class="form-control" id="curpPetitioner1" name="curpPetitioner1" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del solicitante" required>
                @endif
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="verifyCurpPetitioner(this)" id="check-1">Verificar</button>
                </div>
                <div class="invalid-feedback">
                  Favor de ingresar la CURP del solicitante
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-2">
              <label for="type">Tipo de documento</label>
              <select id="type" name="type" class="form-control" required>
                @if(isset($requisition->type))
                  <option value="" {{"" == $requisition->type ? 'selected' : '' }}>selecciona...</option>
                  <option value="ts" {{"ts" == $requisition->type ? 'selected' : '' }}>Trabajo Social</option>
                  <option value="responsiva" {{"responsiva" == $requisition->type ? 'selected' : '' }}>Responsiva</option>
                  <option value="foliado" {{"foliado" == $requisition->type ? 'selected' : '' }}>Foliado</option>
                @else
                  <option value="">selecciona...</option>
                  <option value="ts">Trabajo Social</option>
                  <option value="responsiva">Responsiva</option>
                  <option value="foliado">Foliado</option>
                @endif
              </select>
            </div>
            <div class="form-group col-md-2">
              <label for="supports_id">Categoría del apoyo</label>
                @if(isset($requisition->supports_id))
                    <select id="supports_id" name="supports_id" class="form-control" required>
                        <option value="">selecciona...</option>
                        @if(isset($supports))
                            @foreach($supports as $element)
                                <option value="{{$element['id']}}" {{$element['id'] == $requisition->supports_id ? 'selected' : ''}}>{{$element['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                @else
                    <select id="supports_id" name="supports_id" class="form-control" disabled required>
                        <option value="">selecciona...</option>
                        @if(isset($supports))
                            @foreach($supports as $element)
                                <option value="{{$element['id']}}">{{$element['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                @endif
            </div>
            <div class="form-group col-md-4">
                <label for="categories_id">Categoría de los productos</label>
                @if(isset($requisition))
                    <select id="categories_id"  name="categories_id" class="form-control" required>
                    @if(isset($categories))
                        <option value="">selecciona...</option>
                        @foreach($categories as $element)
                            <option value="{{$element['id']}}" {{$element['id'] == $requisition->categories_id ? 'selected' : ''}}>{{$element['name']}}</option>
                        @endforeach
                    @endif
                @else
                    <select id="categories_id" disabled name="categories_id" class="form-control" required>
                    <option value="">selecciona...</option>
                @endif
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="reason">Caso</label>
              @if(isset($requisition->description))
                <input type="text" class="form-control" id="reason" name="reason" placeholder="Ingrese la razón de la solicitud" required value="{{$requisition->description}}">
              @else
                <input type="text" class="form-control" id="reason" name="reason" placeholder="Ingrese la razón de la solicitud" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el caso de la solicitud
              </div>
            </div>
          </div>
          <div>
            @if(isset($request))
              <input type="hidden" name="countProduct" id="countProduct" value="{{$request['countProduct']}}">
              <input type="hidden" name="countTotalP" id="countTotalP" value="{{$request['countProduct']}}">
              <input type="hidden" name="fieldsProducts" id="fieldsProducts" value="{{$request['countProduct']}}">
            @else
              <input type="hidden" name="countProduct" id="countProduct" value="1">
              <input type="hidden" name="countTotalP" id="countTotalP" value="1">
              <input type="hidden" name="fieldsProducts" id="fieldsProducts" value="1">
            @endif
          </div>

          {{-- <div class="headerAppend">Producto Principal</div> --}}
          <div class="form-row">
            <div class="form-group col-md-3">
                <label for="suppliers_id1">Proveedor</label>
                @if(isset($requisition))
                    <select id="suppliers_id1" name="suppliers_id1" class="form-control" required>
                        <option value="">Selecciona...</option>
                        @if(isset($suppliers))
                            @foreach($suppliers as $element)
                                <option value="{{$element['id']}}" {{$element['id'] == $requisition->suppliers_id ? 'selected' : '' }}>{{$element['companyname']}}</option>
                            @endforeach
                        @else
                            <option value="0" {{"0" == $requisition->suppliers_id ? 'selected' : '' }}>Sin Proveedor</option>
                        @endif
                    </select>
                @else
                    <select id="suppliers_id1" name="suppliers_id1" disabled class="form-control" required>
                        <option value="">Selecciona...</option>
                    </select>
                @endif
            </div>
            <div class="form-group col-md-3">
                <label for="products_id1">Producto</label>
                @if(isset($requisition))
                    <select id="products_id1" name="products_id1" class="form-control" required>
                        <option value="">seleccione...</option>
                        @if(isset($products))
                            @foreach($products as $element)
                                <option value="{{$element['id']}}" {{$element['id'] == $requisition->products_id ? 'selected' : '' }}>{{$element['name']}}</option>
                            @endforeach
                        @endif
                    </select>
                @else
                    <select id="products_id1" name="products_id1" disabled class="form-control" required>
                        <option value="">seleccione...</option>
                        @foreach($products as $element)
                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="form-group col-md-2">
              <label for="unitPrice1">Precio Unitario</label>
              @if(isset($requisition))
                <input type="text" class="form-control"  id="unitPrice1" readonly name="unitPrice1" placeholder="Ingresar el precio del producto" required value="{{$requisition->price}}">
              @else
                <input type="text" class="form-control" id="unitPrice1" disabled name="unitPrice1" placeholder="Ingresar el precio del producto" required value="0">
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el precio del producto
              </div>
            </div>
            <div class="form-group col-md-2">
              <label for="qty1">Cantidad</label>
              @if(isset($requisition))
                <input type="text" class="form-control"  id="qty1" name="qty1" placeholder="Ingresar la cantidad de productos" required value="{{$requisition->qty}}">
              @else
                <input type="text" class="form-control" id="qty1" disabled name="qty1" placeholder="Ingresar la cantidad de productos" required value="0">
              @endif
              </div>
              <div class="form-group col-md-2">
              <label for="totalPrice1">Costo Total</label>
              <div class="input-group">
                @if(isset($requisition))
                  <input type="text" class="form-control" id="totalPrice1" name="totalPrice1" disabled required value="{{$requisition->total}}">
                @else
                  <input type="text" class="form-control" id="totalPrice1" name="totalPrice1" disabled required value="0">
                @endif
              </div>
            </div>
          </div>
          {{-- @if(isset($request))
            @for($i = 2 ; $i <= $request['countProduct'];$i++)
              <div id="{{'fDP-'.$i}}">
                <hr>
                <div class="headerAppend">Producto {{$i}}
                  <button type="button" id="{{'deleteProduct-'.$i}}" class="btn float-right" onclick="deleteProduct(this)">
                    <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                  </button>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-3">
                    <label for="{{'suppliers_id'.$i}}">Proveedor</label>
                    <select id="{{'suppliers_id'.$i}}" disabled name="{{'suppliers_id'.$i}}" class="form-control" required>
                      <option value="">Selecciona...</option>
                        @if(isset($suppliers))
                          @foreach($suppliers['suppliers'.$i] as $element)
                            <option value="{{$element['id']}}" {{$element['id'] == $requisition['suppliers_id'.$i] ? 'selected' : '' }}>{{$element['companyname']}}</option>
                          @endforeach
                        @else
                          @foreach($suppliers as $element)
                            <option value="{{$element['id']}}">{{$element['companyname']}}</option>
                          @endforeach
                        @endif
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="{{'products_id'.$i}}">Producto</label>
                    <select id="{{'products_id'.$i}}" disabled name="{{'products_id'.$i}}" class="form-control" required>
                      <option value="">seleccione...</option>
                      @if(isset($products))
                          @foreach($products['product'.$i] as $element)
                            <option value="{{$element['id']}}" {{$element['id'] == $requisition['products_id'.$i] ? 'selected' : '' }}>{{$element['name']}}</option>
                          @endforeach
                      @else
                          @foreach($products as $element)
                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                          @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="{{'unitPrice'.$i}}">Precio Unitario</label>
                    @if(isset($requisition->products))
                      <input type="text" class="form-control" id="{{'unitPrice'.$i}}" disabled name="{{'unitPrice'.$i}}" placeholder="Ingresar el precio del producto" required value="{{$requisition['unitPrice'.$i]}}">
                    @else
                      <input type="text" class="form-control" id="{{'unitPrice'.$i}}" disabled name="{{'unitPrice'.$i}}" placeholder="Ingresar el precio del producto" required value="0">
                    @endif
                    <div class="invalid-feedback">
                      Favor de ingresar el precio del producto
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="{{'qty'.$i}}">Cantidad</label>
                    @if(isset($requisition->products))
                      <input type="text" class="form-control" id="{{'qty'.$i}}" disabled name="{{'qty'.$i}}" placeholder="Ingresar la cantidad de productos" required value="{{$requisition['qty'.$i]}}">
                    @else
                      <input type="text" class="form-control" id="{{'qty'.$i}}" disabled name="{{'qty'.$i}}" placeholder="Ingresar la cantidad de productos" required value="0">
                    @endif
                  </div>
                  <div class="form-group col-md-2">
                    <label for="{{'totalPrice'.$i}}">Costo Total</label>
                    @if(isset($requisition->products))
                      <input type="text" class="form-control" id="{{'totalPrice'.$i}}" disabled name="{{'totalPrice'.$i}}" disabled required value="{{$requisition['totalPrice'.$i]}}">
                    @else
                      <input type="text" class="form-control" id="{{'totalPrice'.$i}}" disabled name="{{'totalPrice'.$i}}" disabled required value="0">
                    @endif
                    <div class="invalid-feedback">
                      Favor de ingresar el total del costo
                    </div>
                  </div>
                </div>
              </div>
            @endfor
          @endif
          <div id="products"></div> --}}
          <hr>
          <a href="/solicitudes"  class="btn btn-primary float-right">Cancelar</a>
          <button type="button" id="requestGeneralData-1"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Siguiente</button>
          <button type="button" onclick="saveAfter()" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar para después</button>
        
        </div>
        {{-- beneficiaryGeneralData --}}
        <div class="tab-pane fade" id="beneficiaryGeneralData" role="tabpanel" aria-labelledby="beneficiaryGeneralData-tab">
          <br>
          <div>
            <span class="m-0 font-weight-bold text-primary title-table">Beneficiarios
              <button type="button" id="addBeneficiary" class="btn btn-primary float-right">Agregar</button>
            </span>
            @if(isset($requisition))
              <input type="hidden" name="countBeneficiary" id="countBeneficiary" value="{{$requisition->countPersonalD == 0 || $requisition->countPersonalD == null ? 1 : $requisition->countPersonalD}}">
              <input type="hidden" name="countTotalB" id="countTotalB" value="{{$requisition->countPersonalD == 0 || $requisition->countPersonalD == null ? 1 : $requisition->countPersonalD}}">
            @else
              <input type="hidden" name="countBeneficiary" id="countBeneficiary" value="1">
              <input type="hidden" name="countTotalB" id="countTotalB" value="1">
            @endif            
          </div>
          <hr>
          <div class="headerAppend">Beneficiario Principal</div>
          <div class="form-row" style="display: none;">
            <div class="form-group col-md-12">
              @if(isset($requisition->beneficiary1))
                <input type="hidden" class="form-control" id="addressesid" name="address_id" value="{{$requisition->address['id']}}">
              @else                
                <input type="hidden" class="form-control" id="addressesid" name="address_id" value="">
              @endif
          	</div>
         </div>            
          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="curpbeneficiary1">Curp del beneficiario</label>
              <div class="input-group">
                @if(isset($requisition->beneficiary1))
                  <input type="text" class="form-control" id="curpbeneficiary1" name="curpbeneficiary1" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del beneficiario" required value="{{$requisition->beneficiary1['curp']}}">
                @else
                  <input type="text" class="form-control" id="curpbeneficiary1" name="curpbeneficiary1" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del beneficiario" required>
                @endif
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="verifyCurp(this)" id="check-1">Verificar</button>
                </div>
                <div class="invalid-feedback">
                  Favor de ingresar la CURP del beneficiario
                </div>
              </div>
            </div>
            <div class="form-group col-md-2">
                <label for="agebeneficiary1">Edad</label>
                @if(isset($requisition->beneficiary1))
                  <input type="text" class="form-control" id="agebeneficiary1" data-mask="000" name="agebeneficiary1" placeholder="Ingrese la edad del beneficiario" required value="{{$requisition->beneficiary1['age']}}">
                @else
                  <input type="text" class="form-control" id="agebeneficiary1" data-mask="000" name="agebeneficiary1" placeholder="Ingrese la edad del beneficiario" required>
                @endif
            </div>
            <div class="form-group col-md-3">
              <label for="phonenumber1">Número telefónico</label>
                @if(isset($requisition->beneficiary1))
                  <input type="text" class="form-control" id="phonenumber1" name="phonenumber1" placeholder="Ingresar número telefónico del beneficiario" data-mask="000-000-0000" value="{{$requisition->beneficiary1['ext']['number']}}" required>
                @else
                  <input type="text" class="form-control" id="phonenumber1" name="phonenumber1" placeholder="Ingresar número telefónico del beneficiario" data-mask="000-000-0000" required>
                @endif
                  <div class="invalid-feedback">
                      Favor de ingresar el número telefónico del beneficiario
                  </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="namebeneficiary1">Nombre(s)</label>
              @if(isset($requisition->beneficiary1))
                <input type="text" class="form-control" id="namebeneficiary1" name="namebeneficiary1" value="{{$requisition->beneficiary1['name']}}" placeholder="Ingrese el nombre del beneficiario" required>
              @else
                <input type="text" class="form-control" id="namebeneficiary1" name="namebeneficiary1" placeholder="Ingrese el nombre del beneficiario" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el nombre del beneficiario
              </div>
            </div>
            <div class="form-group col-md-4">
              <label for="lastNamebeneficiary1">Apellido paterno</label>
              @if(isset($requisition->beneficiary1))
                <input type="text" class="form-control" id="lastNamebeneficiary1" name="lastNamebeneficiary1" value="{{$requisition->beneficiary1['lastName']}}" placeholder="Ingrese el apellido paterno del beneficiario" required>
              @else
                <input type="text" class="form-control" id="lastNamebeneficiary1" name="lastNamebeneficiary1" placeholder="Ingrese el apellido paterno del beneficiario" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el apellido paterno del beneficiario
              </div>
            </div>
            <div class="form-group col-md-4">
              <label for="secondLastNamebeneficiary1">Apellido materno</label>
              @if(isset($requisition->beneficiary1))
                <input type="text" class="form-control" id="secondLastNamebeneficiary1" name="secondLastNamebeneficiary1" placeholder="Ingrese el apellido Materno del beneficiario" value="{{$requisition->beneficiary1['secondLastName']}}" required>
              @else
                <input type="text" class="form-control" id="secondLastNamebeneficiary1" name="secondLastNamebeneficiary1" placeholder="Ingrese el apellido Materno del beneficiario" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el apellido materno del beneficiario
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="civilStatusbeneficiary1">Edo. Civil</label>
              <select id="civilStatusbeneficiary1" name="civilStatusbeneficiary1" class="form-control" required>
              @if(isset($requisition->beneficiary1))
                {{-- <option value="" {{$extpersonalData['civilStatus'] == ""}}>Selecciona...</option> --}}
                <option value="soltero(a)" {{$requisition->beneficiary1['ext']['civilStatus'] == "soltero(a)" ? 'selected' : ""}}>Soltero(a)</option>
                <option value="casado(a)" {{$requisition->beneficiary1['ext']['civilStatus'] == "casado(a)" ? 'selected' : ""}}>Casado(a)</option>
                <option value="divorciado(a)" {{$requisition->beneficiary1['ext']['civilStatus'] == "divorciado(a)" ? 'selected' : ""}}>Divorciado(a)</option>
                <option value="viudo(a)" {{$requisition->beneficiary1['ext']['civilStatus'] == "viudo(a)" ? 'selected' : ""}}>Viudo(a)</option>
                <option value="unionLibre" {{$requisition->beneficiary1['ext']['civilStatus'] == "unionLibre" ? 'selected' : ""}}>Unión libre</option>
              @else
                <option value="">Selecciona...</option>
                <option value="soltero(a)">Soltero(a)</option>
                <option value="casado(a)">Casado(a)</option>
                <option value="divorciado(a)">Divorciado(a)</option>
                <option value="viudo(a)">Viudo(a)</option>
                <option value="unionLibre">Unión libre</option>
              @endif
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="scholarShipbeneficiary1">Escolaridad</label>
              <select id="scholarShipbeneficiary1" name="scholarShipbeneficiary1" class="form-control" required>
              @if(isset($requisition->beneficiary1))
                {{-- <option value="sinEstudios" {{$extpersonalData['scholarShip'] == "sinEstudios"}}>Sin estudios</option> --}}
                <option value="primaria" {{$requisition->beneficiary1['ext']['scholarShip'] == "primaria" ? 'selected' : ""}}>Primaria</option>
                <option value="secundaria" {{$requisition->beneficiary1['ext']['scholarShip'] == "secundaria" ? 'selected' : ""}}>Secundaria</option>
                <option value="bachillerato/tecnico" {{$requisition->beneficiary1['ext']['scholarShip'] == "bachillerato/tecnico" ? 'selected' : ""}}>Bachillerato/Técnico</option>
                <option value="licenciatura/profesional" {{$requisition->beneficiary1['ext']['scholarShip'] == "licenciatura/profesional" ? 'selected' : ""}}>Licenciatura/Profesional</option>
                <option value="posgrado" {{$requisition->beneficiary1['ext']['scholarShip'] == "posgrado" ? 'selected' : ""}}>Posgrado</option>
              @else
                <option value="sinEstudios">Sin estudios</option>
                <option value="primaria">Primaria</option>
                <option value="secundaria">Secundaria</option>
                <option value="bachillerato/tecnico">Bachillerato/Técnico</option>
                <option value="licenciatura/profesional">Licenciatura/Profesional</option>
                <option value="posgrado">Posgrado</option>
              @endif
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="employments_idbeneficiary1">Ocupación</label>
              <select id="employments_idbeneficiary1" name="employments_idbeneficiary1" class="form-control" required>
              @if(isset($employments))
                @if(isset($requisition->beneficiary1))
                  @foreach($employments as $element)
                    <option value="{{$element['id']}}" {{$element['id'] == $requisition->beneficiary1['ext']['employments_id'] ? 'selected' : ''}}>{{$element['name']}}</option>
                  @endforeach
                @else
                  @foreach($employments as $element)
                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                  @endforeach
                @endif
              @endif
              </select>
            </div>
          </div>                    
          <span class="m-0 font-weight-bold text-primary headerAppend">Diagnostico de Beneficiario
              <button type="button" id="addDiagnosticBeneficiary1" class="btn btn-primary float-right">Agregar</button>
          </span>
          @if(isset($requisition))
            <input type="hidden" name="countDiagnosticBeneficiary1" id="countDiagnosticBeneficiary1" value="{{$requisition['countDiagnosticBeneficiary1'] == 0 || $requisition['countDiagnosticBeneficiary1'] == null ? 1 : $requisition['countDiagnosticBeneficiary1']}}">                                                                                                              
            <input type="hidden" name="countTotalDB1" id="countTotalDB1" value="{{$requisition['countDiagnosticBeneficiary1'] == 0 || $requisition['countDiagnosticBeneficiary1'] == null ? 1 : $requisition['countDiagnosticBeneficiary1']}}">
          @else
            <input type="hidden" name="countDiagnosticBeneficiary1" id="countDiagnosticBeneficiary1" value="1">
            <input type="hidden" name="countTotalDB1" id="countTotalDB1" value="1">
          @endif
          <div class="form-row" style="display: none;">
            <div class="form-group col-md-12">                    
              @if(isset($requisition['beneficiary1']['Disabilitiesid1']))
                <input type="hidden" class="form-control" id="{{'beneficiaryDisabilitiesid1_1'}}" name="{{'beneficiaryDisabilitiesid1_1'}}" value="{{ $requisition['beneficiary'.$i.'Disabilitiesid'.$x] == 0 || $requisition['beneficiary'.$i.'Disabilitiesid'.$x] == null ? 1 : $requisition['beneficiary'.$i.'Disabilitiesid'.$x]}}">
              @else
                <input type="hidden" class="form-control" id="{{'beneficiaryDisabilitiesid1_1'}}" name="{{'beneficiaryDisabilitiesid1_1'}} value="">
              @endif
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="disabilitycategories1_1">Categoria del Diagnostico</label>
              <select id="disabilitycategories1_1" name="disabilitycategories1_1" class="form-control" required>
                <option value="">selecciona...</option>
                @if(isset($catDisabilities))
                  @if(isset($requisition['beneficiary1']))
                    @foreach($catDisabilities as $element)
                      <option value="{{$element['id']}}" {{$element['id'] == $requisition->beneficiary1['catDisabilities_id1'] ? 'selected' : '' }}>{{$element['name']}}</option>
                    @endforeach
                  @else
                    @foreach($catDisabilities as $element)
                      <option value="{{$element['id']}}">{{$element['name']}}</option>
                    @endforeach
                  @endif
                @else
                  @foreach($categotydisability as $element)
                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                  @endforeach
                @endif
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="disability1_1">Diagnostico</label>
              @if(isset($requisition->beneficiary1))
                <select id="disability1_1" name="disability1_1"  class="form-control" required>
                  <option value="">Selecciona...</option>
                  @if(isset($requisition->beneficiary1Disabilities1))
                    @foreach($requisition->beneficiary1Disabilities1 as $element)
                      <option value="{{$element['id']}}" {{$element->id == $requisition->beneficiary1['disabilities_id1'] ? 'selected' : ''}}>{{$element['name']}}</option>
                    @endforeach
                  @endif
                </select>
              @else
                <select id="disability1_1" name="disability1_1" disabled class="form-control" required>
                  <option value="">Selecciona...</option>
                </select>
              @endif
            </div>
          </div>
          @if(isset($requisition))
            <div id="{{'requestDiagnostic1'}}">
              @for($i = 2; $i <= $requisition->countDiagnosticBeneficiary1; $i++)
                <div id="{{'fDDB1_'.$i}}">
                  <hr>
                  <div id="{{'requestHeader'.$i}}" class="headerAppend">Categoria de Diagnostico {{$i}}
                    <button type="button" id="{{'deleteDB1_'.$i}}" class="btn float-right" onclick="deleteBeneficiaryDiag(this)">
                      <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                    </button>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="{{'disabilitycategories1_'.$i}}">Categoria del Diagnostico</label>
                      <select id="{{'disabilitycategories1_'.$i}}" name="{{'disabilitycategories1_'.$i}}"  onchange="getDisabilities(this)" class="form-control" required>
                        <option value="">selecciona...</option>
                        @if(isset($catDisabilities))
                          @if(isset($requisition['beneficiary1']))
                            @foreach($catDisabilities as $element)
                              <option value="{{$element['id']}}" {{$element['id'] == $requisition->beneficiary1['catDisabilities_id'.$i] ? 'selected' : '' }}>{{$element['name']}}</option>
                            @endforeach
                          @else
                            @foreach($catDisabilities as $element)
                              <option value="{{$element['id']}}">{{$element['name']}}</option>
                            @endforeach
                          @endif
                        @endif
                      </select>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="{{'disability1_'.$i}}">Diagnostico</label>
                      @if(isset($requisition->beneficiary1))
                        <select id="{{'disability1_'.$i}}" name="{{'disability1_'.$i}}"  class="form-control" required>
                          <option value="">Selecciona...</option>
                            @foreach($requisition['beneficiary1Disabilities'.$i] as $element)
                              <option value="{{$element['id']}}" {{$element->id == $requisition->beneficiary1['disabilities_id'.$i] ? 'selected' : ''}}>{{$element['name']}}</option>
                            @endforeach
                        </select>
                      @else
                        <select id="{{'disability1_'.$i}}" name="{{'disability1_'.$i}}" disabled class="form-control" required>
                          <option value="">Selecciona...</option>
                        </select>
                      @endif
                    </div>
                  </div>
                </div>
              @endfor
            </div>
          @endif
          {{-- @if --}}
          <div id="requestDiagnostic1"></div>
          @if(isset($requisition))
            @for($i = 2 ; $i <= $requisition->countPersonalD;$i++)
              <div id="{{'fDB-'.$i}}">
                <hr/>
                <div id="{{'requestHeader'.$i}}" class="headerAppend">Beneficiario {{$i}}
                  <button type="button" id="{{'deleteB-'.$i}}" class="btn float-right" onclick="deleteBeneficiary(this)">
                    <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                  </button>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-7">
                    <label for="{{'curpbeneficiary'.$i}}">Curp del beneficiario</label>
                    <div class="input-group">
                      @if(isset($requisition['beneficiary'.$i]))
                        <input type="text" class="form-control" id="{{'curpbeneficiary'.$i}}" name="{{'curpbeneficiary'.$i}}" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del beneficiario" required value="{{$requisition['beneficiary'.$i]['curp']}}">
                      @else
                        <input type="text" class="form-control" id="{{'curpbeneficiary'.$i}}" name="{{'curpbeneficiary'.$i}}" data-mask="SSSS000000SSSSSSAA" placeholder="Ingrese la curp del beneficiario" required>
                      @endif
                      <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" onclick="verifyCurp(this)" id="{{'check-'.$i}}">Verificar</button>
                      </div>
                      <div class="invalid-feedback">
                        Favor de ingresar la CURP del beneficiario
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-2">
                    <label for="{{'agebeneficiary'.$i}}">Edad</label>
                    @if(isset($requisition->beneficiary1))
                      <input type="text" class="form-control" id="{{'agebeneficiary'.$i}}" data-mask="000" name="{{'agebeneficiary'.$i}}" placeholder="Ingrese la edad del beneficiario" required value="{{$requisition['beneficiary'.$i]['age']}}">
                    @else
                      <input type="text" class="form-control" id="{{'agebeneficiary'.$i}}" data-mask="000" name="{{'agebeneficiary'.$i}}" placeholder="Ingrese la edad del beneficiario" required>
                    @endif
                  </div>
                  <div class="form-group col-md-3">
                    <label for="{{'phonenumber'.$i}}">Número telefónico</label>
                    @if(isset($requisition->beneficiary1))
                      <input type="text" class="form-control" id="{{'phonenumber'.$i}}" name="{{'phonenumber'.$i}}" placeholder="Ingresar número telefónico del beneficiario" data-mask="000-000-0000" value="{{$requisition['beneficiary'.$i]['ext']['number']}}" required>
                    @else
                      <input type="text" class="form-control" id="{{'phonenumber'.$i}}" name="{{'phonenumber'.$i}}" placeholder="Ingresar número telefónico del beneficiario" data-mask="000-000-0000" required>
                    @endif
                    <div class="invalid-feedback">
                      Favor de ingresar el número telefónico del beneficiario
                    </div>
                  </div>                          
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="{{'namebeneficiary'.$i}}">Nombre(s)</label>
                    @if(isset($requisition['beneficiary'.$i]))
                      <input type="text" class="form-control" id="{{'namebeneficiary'.$i}}" name="{{'namebeneficiary'.$i}}" value="{{$requisition['beneficiary'.$i]['name']}}" placeholder="Ingrese el nombre del beneficiario" required>
                    @else
                      <input type="text" class="form-control" id="{{'namebeneficiary'.$i}}" name="{{'namebeneficiary'.$i}}" placeholder="Ingrese el nombre del beneficiario" required>
                    @endif
                    <div class="invalid-feedback">
                        Favor de ingresar el nombre del beneficiario
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'lastNamebeneficiary'.$i}}">Apellido paterno</label>
                    @if(isset($requisition['beneficiary'.$i]))
                      <input type="text" class="form-control" id="{{'lastNamebeneficiary'.$i}}" name="{{'lastNamebeneficiary'.$i}}" value="{{$requisition['beneficiary'.$i]['lastName']}}" placeholder="Ingrese el apellido paterno del beneficiario" required>
                    @else
                      <input type="text" class="form-control" id="{{'lastNamebeneficiary'.$i}}" name="{{'lastNamebeneficiary'.$i}}" placeholder="Ingrese el apellido paterno del beneficiario" required>
                    @endif
                    <div class="invalid-feedback">
                        Favor de ingresar el apellido paterno del beneficiario
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'secondLastNamebeneficiary'.$i}}">Apellido materno</label>
                    @if(isset($requisition['beneficiary'.$i]))
                      <input type="text" class="form-control" id="{{'secondLastNamebeneficiary'.$i}}" name="{{'secondLastNamebeneficiary'.$i}}" placeholder="Ingrese el apellido Materno del beneficiario" value="{{$requisition['beneficiary'.$i]['secondLastName']}}" required>
                    @else
                      <input type="text" class="form-control" id="{{'secondLastNamebeneficiary'.$i}}" name="{{'secondLastNamebeneficiary'.$i}}" placeholder="Ingrese el apellido Materno del beneficiario" required>
                    @endif
                    <div class="invalid-feedback">
                        Favor de ingresar el apellido materno del beneficiario
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="{{'civilStatusbeneficiary'.$i}}">Edo. Civil</label>
                    <select id="{{'civilStatusbeneficiary'.$i}}" name="{{'civilStatusbeneficiary'.$i}}" class="form-control" required>
                      @if(isset($requisition['beneficiary'.$i]))
                        {{-- <option value="" {{$extpersonalData['civilStatus'] == ""}}>Selecciona...</option> --}}
                        <option value="soltero(a)" {{$requisition['beneficiary'.$i]['ext']['civilStatus'] == "soltero(a)" ? 'selected' : ""}}>Soltero(a)</option>
                        <option value="casado(a)" {{$requisition['beneficiary'.$i]['ext']['civilStatus'] == "casado(a)" ? 'selected' : ""}}>Casado(a)</option>
                        <option value="divorciado(a)" {{$requisition['beneficiary'.$i]['ext']['civilStatus'] == "divorciado(a)" ? 'selected' : ""}}>Divorciado(a)</option>
                        <option value="viudo(a)" {{$requisition['beneficiary'.$i]['ext']['civilStatus'] == "viudo(a)" ? 'selected' : ""}}>Viudo(a)</option>
                        <option value="unionLibre" {{$requisition['beneficiary'.$i]['ext']['civilStatus'] == "unionLibre" ? 'selected' : ""}}>Unión libre</option>
                      @else
                        <option value="">Selecciona...</option>
                        <option value="soltero(a)">Soltero(a)</option>
                        <option value="casado(a)">Casado(a)</option>
                        <option value="divorciado(a)">Divorciado(a)</option>
                        <option value="viudo(a)">Viudo(a)</option>
                        <option value="unionLibre">Unión libre</option>
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'scholarShipbeneficiary'.$i}}">Escolaridad</label>
                        <select id="{{'scholarShipbeneficiary'.$i}}" name="{{'scholarShipbeneficiary'.$i}}" class="form-control" required>
                          @if(isset($requisition['beneficiary'.$i]))
                            {{-- <option value="sinEstudios" {{$extpersonalData['scholarShip'] == "sinEstudios"}}>Sin estudios</option> --}}
                            <option value="primaria" {{$requisition['beneficiary'.$i]['ext']['scholarShip'] == "primaria" ? 'selected' : ""}}>Primaria</option>
                            <option value="secundaria" {{$requisition['beneficiary'.$i]['ext']['scholarShip'] == "secundaria" ? 'selected' : ""}}>Secundaria</option>
                            <option value="bachillerato/tecnico" {{$requisition['beneficiary'.$i]['ext']['scholarShip'] == "bachillerato/tecnico" ? 'selected' : ""}}>Bachillerato/Técnico</option>
                            <option value="licenciatura/profesional" {{$requisition['beneficiary'.$i]['ext']['scholarShip'] == "licenciatura/profesional" ? 'selected' : ""}}>Licenciatura/Profesional</option>
                            <option value="posgrado" {{$requisition['beneficiary'.$i]['ext']['scholarShip'] == "posgrado" ? 'selected' : ""}}>Posgrado</option>
                          @else
                            <option value="sinEstudios">Sin estudios</option>
                            <option value="primaria">Primaria</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="bachillerato/tecnico">Bachillerato/Técnico</option>
                            <option value="licenciatura/profesional">Licenciatura/Profesional</option>
                            <option value="posgrado">Posgrado</option>
                          @endif
                        </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'employments_idbeneficiary'.$i}}">Ocupación</label>
                    <select id="{{'employments_idbeneficiary'.$i}}" name="{{'employments_idbeneficiary'.$i}}" class="form-control" required>
                        @if(isset($employments))
                            @if(isset($requisition->beneficiary1))
                                @foreach($employments as $element)
                                    <option value="{{$element['id']}}" {{$element['id'] == $requisition['beneficiary'.$i]['ext']['employments_id'] ? 'selected' : ''}}>{{$element['name']}}</option>
                                @endforeach
                            @else
                                @foreach($employments as $element)
                                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                  </div>
                </div>
                <div>
                  <span class="m-0 font-weight-bold text-primary headerAppend">Diagnostico de Beneficiario
                    <button type="button" id="{{'addDiagnosticBeneficiary'.$i}}" onclick='addDisabilities(this)' class="btn btn-primary float-right">Agregar</button>
                  </span>
                  @if(isset($requisition))
                    <input type="hidden" name="{{'countDiagnosticBeneficiary'.$i}}" id="{{'countDiagnosticBeneficiary'.$i}}" value="{{$requisition['countDiagnosticBeneficiary'.$i]}}">
                    <input type="hidden" name="{{'countTotalDB'.$i}}" id="{{'countTotalDB'.$i}}" value="{{$requisition['countDiagnosticBeneficiary'.$i]}}">
                  @else
                    <input type="hidden" name="{{'countDiagnosticBeneficiary'.$i}}" id="{{'countDiagnosticBeneficiary'.$i}}" value="1">
                    <input type="hidden" name="{{'countTotalDB'.$i}}" id="{{'countTotalDB'.$i}}" value="1">
                  @endif
                </div>
              </div>
              @if(isset($requisition))
                <div id="{{'requestDiagnostic'.$i}}">
                  @for($x = 1; $x <= $requisition['countDiagnosticBeneficiary'.$i]; $x++)
                    <div id="{{'fDDB'.$i.'_'.$x}}">                        
                      <hr>
                      <div id="{{'requestHeader'.$x}}" class="headerAppend">Categoria de Diagnostico {{$x}}
                        <button type="button" id="{{'deleteDB'.$i.'_'.$x}}" class="btn float-right" onclick="deleteBeneficiaryDiag(this)">
                          <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                        </button>
                      </div>
                      <div class="form-row" style="display: none;">
                        <div class="form-group col-md-12">                    
                          @if(isset($requisition['beneficiary'.$i]['Disabilitiesid'.$x]))
                            <input type="hidden" class="form-control" id="{{'beneficiaryDisabilitiesid'.$i.'_'.$x}}" name="{{'beneficiaryDisabilitiesid'.$i.'_'.$x}}" value="{{ $requisition['beneficiary'.$i.'Disabilitiesid'.$x]}}">
                          @else
                            <input type="hidden" class="form-control" id="{{'beneficiaryDisabilitiesid'.$i.'_'.$x}}" name="{{'beneficiaryDisabilitiesid'.$i.'_'.$x}} value="">
                          @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="{{'disabilitycategories'.$i.'_'.$x}}">Categoria del Diagnostico</label>
                          <select id="{{'disabilitycategories'.$i.'_'.$x}}" name="{{'disabilitycategories'.$i.'_'.$x}}"  onchange="getDisabilities(this)" class="form-control" required>
                            <option value="">selecciona...</option>
                            @if(isset($catDisabilities))
                              @if(isset($requisition['beneficiary'.$i]))
                                @foreach($catDisabilities as $element)
                                  <option value="{{$element['id']}}" {{$element['id'] == $requisition['beneficiary'.$i]['catDisabilities_id'.$x] ? 'selected' : '' }}>{{$element['name']}}</option>
                                @endforeach
                              @else
                                @foreach($catDisabilities as $element)
                                  <option value="{{$element['id']}}">{{$element['name']}}</option>
                                @endforeach
                              @endif
                            @endif
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="{{'disability'.$i.'_'.$x}}">Diagnostico</label>
                          @if(isset($requisition['beneficiary'.$i]))
                            <select id="{{'disability'.$i.'_'.$x}}" name="{{'disability'.$i.'_'.$x}}"  class="form-control" required>
                              <option value="">Selecciona...</option>
                              @foreach($requisition['beneficiary'.$i.'Disabilities'.$x] as $element)
                                <option value="{{$element['id']}}" {{$element->id == $requisition['beneficiary'.$i]['disabilities_id'.$x] ? 'selected' : ''}}>{{$element['name']}}</option>
                              @endforeach
                            </select>
                          @else
                            <select id="{{'disability'.$i.'_'.$x}}" name="{{'disability'.$i.'_'.$x}}" disabled class="form-control" required>
                              <option value="">Selecciona...</option>
                            </select>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endfor
                </div>
              @endif                
            @endfor
          @endif
          <div id="requests"></div>
          <hr/>
          <div class="headerAppend">
            Dirección
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="street">Calle</label>
              @if(isset($requisition->address))
                <input type="text" class="form-control" id="street" name="street" placeholder="Ingresar la calle" value="{{$requisition->address['street']}}" required>
              @else
                <input type="text" class="form-control" id="street" name="street" placeholder="Ingresar la calle" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar la calle de la dirección del beneficiario
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="externalNumber">Número externo</label>
              @if(isset($requisition->address))
                <input type="text" class="form-control" id="externalNumber" name="externalNumber" placeholder="Ingresar el número externo" value="{{$requisition->address['externalNumber']}}" required>
              @else
                <input type="text" class="form-control" id="externalNumber" name="externalNumber" placeholder="Ingresar el número externo" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el número externo de la dirección del beneficiario
              </div>
            </div>
            <div class="form-group col-md-3">
              <label for="internalNumber">Número interno</label>
              @if(isset($requisition->address))
                <input type="text" class="form-control" id="internalNumber" name="internalNumber" value="{{$requisition->address['internalNumber']}}" placeholder="Ingresar el número interno">
              @else
                <input type="text" class="form-control" id="internalNumber" name="internalNumber" placeholder="Ingresar el número interno">
              @endif
            </div>
            <div class="form-group col-md-3">
              <label for="postalCode1">Código Postal</label>
              <div class="input-group">
                @if(isset($requisition->address))
                  <input type="text" class="form-control" id="postalCode1" name="postalCode1" placeholder="Ingresa tú numero postal" required data-mask="00000" value="{{$requisition->address['community']['postalCode']}}">
                @else
                  <input type="text" class="form-control" id="postalCode1" name="postalCode1" placeholder="Ingresa tú numero postal" required data-mask="00000">
                @endif
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" onclick="filterCP(this)" id="filter-1">Filtrar</button>
                </div>
                <div class="invalid-feedback">
                  Favor de ingresar el código postal de la dirección del beneficiario
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="communities_id1">Colonia</label>
              @if(isset($requisition->address))
                <select id="communities_id1" name="communities_id1" class="form-control" required>
                  @if(isset($communities))
                    @foreach ($communities as $element)
                      <option value="{{$element['id']}}" {{$element['id'] == $requisition->address['communities_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                    @endforeach
                  @endif
                </select>
              @else
                <select id="communities_id1" name="communities_id1" disabled class="form-control" required>
                  <option value="">Selecciona...</option>
                </select>
              @endif
            </div>
            <div class="form-group col-md-3">
              <label for="municipalities_id1">Municipio</label>
              <select id="municipalities_id1" name="municipalities_id1" disabled class="form-control" required>
                @if(isset($requisition->address))
                  <option value="{{$requisition->address['municipalities']['id']}}">{{$requisition->address['municipalities']['name']}}</option>
                @else
                  <option value="">seleccione...</option>
                @endif
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="states_id1">Estado</label>
              <select id="states_id1" name="states_id1" class="form-control" disabled required>
              @if(isset($requisition->address))
                <option value="{{$requisition->address['states']['id']}}">{{$requisition->address['states']['name']}}</option>
              @else
                <option value="">seleccione...</option>
              @endif
              </select>
            </div>
            <div class="form-group col-md-3">
              <label for="area">Área</label>
              @if(isset($requisition))
                <input type="text" class="form-control" id="area" name="area" placeholder="Ingresar el número del área" value="{{$requisition->area}}" required>
              @else
                <input type="text" class="form-control" id="area" name="area" placeholder="Ingresar el número del área" required>
              @endif
              <div class="invalid-feedback">
                Favor de ingresar el número del área
              </div>
            </div>
          </div>
          <a href="solicitudes"  class="btn btn-primary float-right">Cancelar</a>
          <button type="button" id="beneficiaryGeneralData-1"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Siguiente</button>
          <button type="button" id="beneficiaryGeneralData-2"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Anterior</button>
          <button type="button" onclick="saveAfter()" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar para después</button>          
        </div>  
        {{-- familySituation --}}
        <div class="tab-pane fade" id="familySituation" role="tabpanel" aria-labelledby="familySituation-tab">
          <hr>
          <div>
            <span class="m-0 font-weight-bold text-primary title-table">No. de Miembros que viven en el Hogar
              <button type="button" id="addMH" class="btn btn-primary float-right">Agregar</button>
            </span>
            @if(isset($requisition->CountConditionsFamily))
              <input type="hidden" name="countMH" id="countMH" value="{{$requisition->CountConditionsFamily == 0 || $requisition->CountConditionsFamily == null ? 1 : $requisition->CountConditionsFamily }}">
              <input type="hidden" name="countTotalMH" id="countTotalMH" value="{{ $requisition->CountConditionsFamily == 0 || $requisition->CountConditionsFamily == null ? 1 : $requisition->CountConditionsFamily}}">
            @else
              <input type="hidden" name="countMH" id="countMH" value="1">
              <input type="hidden" name="countTotalMH" id="countTotalMH" value="1">
            @endif
          </div>
          <hr>
          <div class="form-row" style="display: none;">
            <div class="form-group col-md-12">
              @if(isset($requisition['ConditionsFamily1']))
                <input type="hidden" class="form-control" id="ConditionsFamilyid1" name="ConditionsFamilyid1" value="{{$requisition['ConditionsFamily1']['id']}}">
              @else
                <input type="hidden" class="form-control" id="ConditionsFamilyid1" name="ConditionsFamilyid1" value="">
              @endif
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="name1">Nombre(s)</label>
              @if(isset($requisition->ConditionsFamily1))
                <input type="text" class="form-control" id="name1" name="name1" placeholder="Ingresa nombre de la persona" value="{{$requisition->ConditionsFamily1['name']}}">
              @else
                <input type="text" class="form-control" id="name1" name="name1" placeholder="Ingresa nombre de la persona">
              @endif
            </div>
            <div class="form-group col-md-4">
              <label for="lastName1">Apellido paterno</label>
              @if(isset($requisition->ConditionsFamily1))
                <input type="text" class="form-control" id="lastName1" name="lastName1" placeholder="Ingresa el apellido paterno de la persona" value="{{$requisition->ConditionsFamily1['lastname']}}">
              @else
                <input type="text" class="form-control" id="lastName1" name="lastName1" placeholder="Ingresa el apellido paterno de la persona">
              @endif
            </div>
            <div class="form-group col-md-4">
              <label for="secondLastName1">Apellido materno</label>
              @if(isset($requisition->ConditionsFamily1))
                <input type="text" class="form-control" id="secondLastName1" name="secondLastName1" placeholder="Ingresa el apellido materno de la persona" value="{{$requisition->ConditionsFamily1['secondlastname']}}">
              @else
                <input type="text" class="form-control" id="secondLastName1" name="secondLastName1" placeholder="Ingresa el apellido materno de la persona">
              @endif
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="age1">Edad</label>
              @if(isset($requisition->ConditionsFamily1))
                <input type="text" class="form-control" id="age1" name="age1" data-mask="000" placeholder="Ingresa la edad de la persona" value="{{$requisition->ConditionsFamily1['age']}}">
              @else
                <input type="text" class="form-control" id="age1" name="age1" data-mask="000" placeholder="Ingresa la edad de la persona">
              @endif
            </div>
            <div class="form-group col-md-4">
              <label for="relationship1">Parentesco</label>
              <select id="relationship1" name="relationship1" class="form-control">
                @if(isset($requisition->ConditionsFamily1))
                  <option value="" {{"" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>selecciona...</option>
                  <option value="padre" {{"padre" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Padre</option>
                  <option value="madre" {{"madre" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Madre</option>
                  <option value="hermano(a)" {{"hermano(a)" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Hermano(a)</option>
                  <option value="tio(a)" {{"tio(a)" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Tio(a)</option>
                  <option value="primo(a)" {{"primo(a)" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Primo(a)</option>
                  <option value="hijo(a)" {{"hijo(a)" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Hijo(a)</option>
                  <option value="abuelo(a)" {{"abuelo(a)" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Abuelo(a)</option>
                  <option value="otros" {{"otros" == $requisition->ConditionsFamily1['relationship'] ? 'selected' : ''}}>Otros</option>
                @else
                  <option value="">selecciona...</option>
                  <option value="padre">Padre</option>
                  <option value="madre">Madre</option>
                  <option value="hermano(a)">Hermano(a)</option>
                  <option value="tio(a)">Tio(a)</option>
                  <option value="primo(a)">Primo(a)</option>
                  <option value="hijo(a)">Hijo(a)</option>
                  <option value="abuelo(a)">Abuelo(a)</option>
                  <option value="otros">Otros</option>
                @endif
              </select>
            </div>
            <div class="form-group col-md-4">
              <label for="civilStatus1">Edo. Civil</label>
              <select id="civilStatus1" name="civilStatus1" class="form-control">
                @if(isset($requisition->ConditionsFamily1))
                  <option value="" {{"" == $requisition->ConditionsFamily1['civilStatus'] ? 'selected' : ''}}>selecciona...</option>
                  <option value="soltero(a)" {{"soltero(a)" == $requisition->ConditionsFamily1['civilStatus'] ? 'selected' : ''}}>Soltero(a)</option>
                  <option value="casado(a)" {{"casado(a)" == $requisition->ConditionsFamily1['civilStatus'] ? 'selected' : ''}}>Casado(a)</option>
                  <option value="divorciado(a)" {{"divorciado(a)" == $requisition->ConditionsFamily1['civilStatus'] ? 'selected' : ''}}>Divorciado(a)</option>
                  <option value="viudo(a)" {{"viudo(a)" == $requisition->ConditionsFamily1['civilStatus'] ? 'selected' : ''}}>Viudo(a)</option>
                  <option value="unionLibre" {{"unionLibre" == $requisition->ConditionsFamily1['civilStatus'] ? 'selected' : ''}}>Unión libre</option>
                @else
                  <option value="">selecciona...</option>
                  <option value="soltero(a)">Soltero(a)</option>
                  <option value="casado(a)">Casado(a)</option>
                  <option value="divorciado(a)">Divorciado(a)</option>
                  <option value="viudo(a)">Viudo(a)</option>
                  <option value="unionLibre">Unión libre</option>
                @endif
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="scholarShip1">Escolaridad</label>
              <select id="scholarShip1" name="scholarShip1" class="form-control">
                @if(isset($requisition->ConditionsFamily1))
                  <option value="" {{"" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>selecciona...</option>
                  <option value="sinEstudios" {{"sinEstudios" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>Sin estudios</option>
                  <option value="primaria" {{"primaria" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>Primaria</option>
                  <option value="secundaria" {{"secundaria" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>Secundaria</option>
                  <option value="bachillerato/tecnico" {{"bachillerato/tecnico" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>Bachillerato/Técnico</option>
                  <option value="licenciatura/profesional" {{"licenciatura/profesional" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>Licenciatura/Profesional</option>
                  <option value="posgrado" {{"posgrado" == $requisition->ConditionsFamily1['scholarship'] ? 'selected' : ''}}>Posgrado</option>
                @else
                  <option value="">selecciona...</option>
                  <option value="sinEstudios">Sin estudios</option>
                  <option value="primaria">Primaria</option>
                  <option value="secundaria">Secundaria</option>
                  <option value="bachillerato/tecnico">Bachillerato/Técnico</option>
                  <option value="licenciatura/profesional">Licenciatura/Profesional</option>
                  <option value="posgrado">Posgrado</option>
                @endif
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="employments_id1">Ocupación</label>
              <select id="employments_id1" name="employments_id1" class="form-control">
                  <option value="">selecciona...</option>
                  @if(isset($requisition->ConditionsFamily1))
                      @if(isset($employments))
                          @foreach($employments as $element)
                              <option value="{{$element['id']}}" {{$element['id'] == $requisition->ConditionsFamily1['employments_id'] ? 'selected' : ''}}>{{$element['name']}}</option>
                          @endforeach
                      @endif
                  @else
                    @if(isset($employments))
                      @foreach($employments as $element)
                        <option value="{{$element['id']}}">{{$element['name']}}</option>
                      @endforeach
                    @endif
                  @endif
              </select>
            </div>
          </div>

          @if(isset($requisition))
            @for($i = 2 ; $i <= $requisition->CountConditionsFamily;$i++)
              <div id="{{'fDMH-'.$i}}">
                <hr/>
                <button type="button" id="{{'deleteMH-'.$i}}" class="btn float-right" onclick="deleteMH(this)">
                  <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                </button>
                <div class="form-row" style="display: none;">
                  <div class="form-group col-md-12">                    
                    @if(isset($requisition['ConditionsFamily'.$i]))
                      <input type="hidden" class="form-control" id="{{'ConditionsFamilyid'.$i}}" name="{{'ConditionsFamilyid'.$i}}" value="{{$requisition['ConditionsFamily'.$i]['id']}}">
                    @else
                      <input type="hidden" class="form-control" id="{{'ConditionsFamilyid'.$i}}" name="{{'ConditionsFamilyid'.$i}}" value="">
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="{{'name'.$i}}">Nombre(s)</label>
                    @if(isset($requisition['ConditionsFamily'.$i]))
                      <input type="text" class="form-control" id="{{'name'.$i}}" name="{{'name'.$i}}" placeholder="Ingresa nombre de la persona" value="{{$requisition['ConditionsFamily'.$i]['name']}}">
                    @else
                      <input type="text" class="form-control" id="{{'name'.$i}}" name="{{'name'.$i}}" placeholder="Ingresa nombre de la persona">
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'lastName'.$i}}">Apellido paterno</label>
                    @if(isset($requisition['ConditionsFamily'.$i]))
                      <input type="text" class="form-control" id="{{'lastName'.$i}}" name="{{'lastName'.$i}}" placeholder="Ingresa el apellido paterno de la persona" value="{{$requisition['ConditionsFamily'.$i]['lastname']}}">
                    @else
                      <input type="text" class="form-control" id="{{'lastName'.$i}}" name="{{'lastName'.$i}}" placeholder="Ingresa el apellido paterno de la persona">
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'secondLastName'.$i}}">Apellido materno</label>
                    @if(isset($requisition['ConditionsFamily'.$i]))
                      <input type="text" class="form-control" id="{{'secondLastName'.$i}}" name="{{'secondLastName'.$i}}" placeholder="Ingresa el apellido materno de la persona" value="{{$requisition['ConditionsFamily'.$i]['secondlastname']}}">
                    @else
                      <input type="text" class="form-control" id="{{'secondLastName'.$i}}" name="{{'secondLastName'.$i}}" placeholder="Ingresa el apellido materno de la persona">
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="{{'age'.$i}}">Edad</label>
                    @if(isset($requisition['ConditionsFamily'.$i]))
                      <input type="number" class="form-control" id="{{'age'.$i}}" name="{{'age'.$i}}" placeholder="Ingresa la edad de la persona" value="{{$requisition['ConditionsFamily'.$i]['age']}}">
                    @else
                      <input type="number" class="form-control" id="{{'age'.$i}}" name="{{'age'.$i}}" placeholder="Ingresa la edad de la persona">
                    @endif
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'relationship'.$i}}">Parentesco</label>
                    <select id="{{'relationship'.$i}}" name="{{'relationship'.$i}}" class="form-control">
                      @if(isset($requisition['ConditionsFamily'.$i]))
                        <option value="" {{"" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>selecciona...</option>
                        <option value="padre" {{"padre" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Padre</option>
                        <option value="madre" {{"madre" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Madre</option>
                        <option value="hermano(a)" {{"hermano(a)" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Hermano(a)</option>
                        <option value="tio(a)" {{"tio(a)" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Tio(a)</option>
                        <option value="primo(a)" {{"primo(a)" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Primo(a)</option>
                        <option value="hermano(a)" {{"hermano(a)" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Hermano(a)</option>
                        <option value="hijo(a)" {{"hijo(a)" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Hijo(a)</option>
                        <option value="abuelo(a)" {{"abuelo(a)" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Abuelo(a)</option>
                        <option value="otros" {{"otros" == $requisition['ConditionsFamily'.$i]['relationship'] ? 'selected' : ''}}>Otros</option>
                      @else
                        <option value="">selecciona...</option>
                        <option value="padre">Padre</option>
                        <option value="madre">Madre</option>
                        <option value="hermano(a)">Hermano(a)</option>
                        <option value="tio(a)">Tio(a)</option>
                        <option value="primo(a)">Primo(a)</option>
                        <option value="hermano(a)">Hermano(a)</option>
                        <option value="hijo(a)">Hijo(a)</option>
                        <option value="abuelo(a)">Abuelo(a)</option>
                        <option value="otros">Otros</option>
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="{{'civilStatus'.$i}}">Edo. Civil</label>
                    <select id="{{'civilStatus'.$i}}" name="{{'civilStatus'.$i}}" class="form-control">
                      @if(isset($requisition['ConditionsFamily'.$i]))
                        <option value="" {{"" == $requisition['ConditionsFamily'.$i]['civilStatus'] ? 'selected' : ''}}>selecciona...</option>
                        <option value="soltero(a)" {{"soltero(a)" == $requisition['ConditionsFamily'.$i]['civilStatus'] ? 'selected' : ''}}>Soltero(a)</option>
                        <option value="casado(a)" {{"casado(a)" == $requisition['ConditionsFamily'.$i]['civilStatus'] ? 'selected' : ''}}>Casado(a)</option>
                        <option value="divorciado(a)" {{"divorciado(a)" == $requisition['ConditionsFamily'.$i]['civilStatus'] ? 'selected' : ''}}>Divorciado(a)</option>
                        <option value="viudo(a)" {{"viudo(a)" == $requisition['ConditionsFamily'.$i]['civilStatus'] ? 'selected' : ''}}>Viudo(a)</option>
                        <option value="unionLibre" {{"unionLibre" == $requisition['ConditionsFamily'.$i]['civilStatus'] ? 'selected' : ''}}>Unión libre</option>
                      @else
                        <option value="">selecciona...</option>
                        <option value="soltero(a)">Soltero(a)</option>
                        <option value="casado(a)">Casado(a)</option>
                        <option value="divorciado(a)">Divorciado(a)</option>
                        <option value="viudo(a)">Viudo(a)</option>
                        <option value="unionLibre">Unión libre</option>
                      @endif
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="{{'scholarShip'.$i}}">Escolaridad</label>
                    <select id="{{'scholarShip'.$i}}" name="{{'scholarShip'.$i}}" class="form-control">
                      @if(isset($requisition['ConditionsFamily'.$i]))
                        <option value="" {{"" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>selecciona...</option>
                        <option value="sinEstudios" {{"sinEstudios" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>Sin estudios</option>
                        <option value="primaria" {{"primaria" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>Primaria</option>
                        <option value="secundaria" {{"secundaria" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>Secundaria</option>
                        <option value="bachillerato/tecnico" {{"bachillerato/tecnico" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>Bachillerato/Técnico</option>
                        <option value="licenciatura/profesional" {{"licenciatura/profesional" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>Licenciatura/Profesional</option>
                        <option value="posgrado" {{"posgrado" == $requisition['ConditionsFamily'.$i]['scholarship'] ? 'selected' : ''}}>Posgrado</option>
                      @else
                        <option value="">selecciona...</option>
                        <option value="sinEstudios">Sin estudios</option>
                        <option value="primaria">Primaria</option>
                        <option value="secundaria">Secundaria</option>
                        <option value="bachillerato/tecnico">Bachillerato/Técnico</option>
                        <option value="licenciatura/profesional">Licenciatura/Profesional</option>
                        <option value="posgrado">Posgrado</option>
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="{{'employments_id'.$i}}">Ocupación</label>
                    <select id="{{'employments_id'.$i}}" name="{{'employments_id'.$i}}" class="form-control">
                      <option value="">selecciona...</option>
                      @if(isset($requisition['ConditionsFamily'.$i]))
                        @if(isset($employments))
                          @foreach($employments as $element)
                            <option value="{{$element['id']}}" {{$element['id'] == $requisition['ConditionsFamily'.$i]['employments_id'] ? 'selected' : ''}}>{{$element['name']}}</option>
                          @endforeach
                        @endif
                      @else
                        @if(isset($employments))
                          @foreach($employments as $element)
                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                          @endforeach
                        @endif
                      @endif
                    </select>
                  </div>
                </div>
              </div>
            @endfor
          @endif

          <div id="MHs"></div>
          <hr>
          <a href="solicitudes"  class="btn btn-primary float-right">Cancelar</a>
          <button type="button" id="familySituation-1"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Siguiente</button>
          <button type="button" id="familySituation-2"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Anterior</button>
          <button type="button" onclick="saveAfter()" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar para después</button>
        </div>                
        {{-- economicData --}}
        <div class="tab-pane fade" id="lifeConditions" role="tabpanel" aria-labelledby="lifeConditions-tab">
          <br>
          <div class="form-row">
            <div class="form-group col-md-5">
              <label for="typeHouse">La casa del beneficiario es:</label>
              <select id="typeHouse" name="typeHouse" class="form-control" required>
                  @if(isset($lifeConditions))
                      <option value="" {{"" == $lifeConditions->typeHouse ? "selected" : ""}}>selecciona...</option>
                      <option value="propia" {{"propia" == $lifeConditions->typeHouse ? "selected" : ""}}>Propia</option>
                      <option value="rentada" {{"rentada" == $lifeConditions->typeHouse ? "selected" : ""}}>Rentada</option>
                      <option value="prestada" {{"prestada" == $lifeConditions->typeHouse ? "selected" : ""}}>Prestada</option>
                      <option value="invadida" {{"invadida" == $lifeConditions->typeHouse ? "selected" : ""}}>Invadida</option>
                  @else
                      <option value="">selecciona...</option>
                      <option value="propia">Propia</option>
                      <option value="rentada">Rentada</option>
                      <option value="prestada">Prestada</option>
                      <option value="invadida">Invadida</option>
                  @endif
              </select>
            </div>
            <div class="form-group col-md-5">
                <label for="number_rooms">Número de cuartos</label>
                @if(isset($lifeConditions))
                    <input type="text" class="form-control" id="number_rooms" name="number_rooms" value="{{$lifeConditions->number_rooms}}" data-mask="00" placeholder="Ingresar la cantidad de cuartos" required>
                @else
                    <input type="text" class="form-control" id="number_rooms" name="number_rooms" placeholder="Ingresar la cantidad de cuartos" data-mask="00" required>
                @endif
            </div>
          </div>
          <hr>
          <div>
            <span class="m-0 font-weight-bold text-primary title-table">Muebles
              <button type="button" id="addFurniture" class="btn btn-primary float-right">Agregar</button>
            </span>
            @if(isset($requisition))
              <input type="hidden" name="countFurniture" id="countFurniture" value="{{ $requisition->CountForniture == "0" || $requisition->CountForniture == null ? 1 : $requisition->CountForniture}}">
              <input type="hidden" name="countTotalF" id="countTotalF" value="{{$requisition->CountForniture == "0" || $requisition->CountForniture == null ? 1 : $requisition->CountForniture}}">
            @else
              <input type="hidden" name="countFurniture" id="countFurniture" value="1">
              <input type="hidden" name="countTotalF" id="countTotalF" value="1">
            @endif
          </div>
          <hr>
          <div class="headerAppend">Mueble Principal</div>
          <div class="form-row" style="display: none;">
            <div class="form-group col-md-12">
              @if(isset($requisition['furniture1']))
                <input type="hidden" class="form-control" id="furnitureid1" name="furnitureid1" value="{{$requisition['furniture1']['id']}}">                 
              @else                
                <input type="hidden" class="form-control" id="furnitureid1" name="furnitureid1" value="">
              @endif
          	</div>
         </div>      
          <div class="form-row">          
            <div class="form-group col-md-12">
              <label for="furnitures_id1">Mueble</label>
              <select id="furnitures_id1" name="furnitures_id1" class="form-control" required>
                <option value="">selecciona...</option>
                @if(isset($furnitures))
                  @if(isset($requisition->furniture1))
                    @foreach($furnitures as $element)
                      <option value="{{$element['id']}}" {{$element['id'] == $requisition->furniture1['furnitures_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                    @endforeach
                  @else
                    @foreach($furnitures as $element)
                      <option value="{{$element['id']}}">{{$element['name']}}</option>
                    @endforeach
                  @endif
                @endif
              </select>
            </div>
          </div>
          
          @if(isset($requisition))
            @for($i = 2 ; $i <= $requisition->CountForniture;$i++)
              <div id="{{'fDF-'.$i}}">
                <hr>
                <div class="headerAppend">Mueble {{$i}}
                  <button type="button" id="{{'deleteFurniture-'.$i}}" class="btn float-right" onclick="deleteFurniture(this)">
                    <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                  </button>
                </div>
                <div class="form-row" style="display: none;">
                  <div class="form-group col-md-12">
                    @if(isset($requisition['furniture'.$i]))
                      <input type="hidden" class="form-control" id="{{'furnitureid'.$i}}" name="{{'furnitureid'.$i}}" value="{{$requisition['furniture'.$i]['id']}}">                      
                    @else
                      <input type="hidden" class="form-control" id="{{'furnitureid'.$i}}" name="{{'furnitureid'.$i}}" value="">
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="{{'furnitures_id'.$i}}">Mueble</label>
                    <select id="{{'furnitures_id'.$i}}"  name="{{'furnitures_id'.$i}}" class="form-control" required>
                      <option value="">seleccione...</option>
                      @if(isset($furnitures))
                        @if(isset($requisition['furniture'.$i]))
                          @foreach($furnitures as $element)
                            <option value="{{$element['id']}}" {{$element['id'] == $requisition['furniture'.$i]['furnitures_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                          @endforeach
                        @else
                          @foreach($furnitures as $element)
                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                          @endforeach
                        @endif
                      @endif
                    </select>
                  </div>
                </div>
              </div>
            @endfor
          @endif
          <div id="furnitures"></div>
          <hr>
          <div>
            <span class="m-0 font-weight-bold text-primary title-table">Materiales de construcción
              <button type="button" id="addBuildingMaterial" class="btn btn-primary float-right">Agregar</button>
            </span>
            @if(isset($requisition->CountMaterial))
              <input type="hidden" name="countBuildingMaterial" id="countBuildingMaterial" value="{{$requisition->CountMaterial == "0" || $requisition->CountMaterial == null ? 1 : $requisition->CountMaterial }}">
              <input type="hidden" name="countTotalBM" id="countTotalBM" value="{{$requisition->CountMaterial == "0" || $requisition->CountMaterial == null ? 1 : $requisition->CountMaterial }}">
            @else
              <input type="hidden" name="countBuildingMaterial" id="countBuildingMaterial" value="1">
              <input type="hidden" name="countTotalBM" id="countTotalBM" value="1">
            @endif
          </div>
          <hr>
          <div class="headerAppend">Material de Construcción Principal</div>
          <div class="form-row" style="display: none;">
            <div class="form-group col-md-12">
              @if(isset($requisition['buildingMaterial1']))
                <input type="hidden" class="form-control" id="buildingmaterialid1" name="buildingmaterialid1" value="{{$requisition['buildingMaterial1']['id']}}">                 
              @else                
                <input type="hidden" class="form-control" id="buildingmaterialid1" name="buildingmaterialid1" value="">
              @endif
          	</div>
         </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="buildingMaterials_id1">Material de Construcción</label>
              <select id="buildingMaterials_id1" name="buildingMaterials_id1" class="form-control" required>
                <option value="">selecciona...</option>
                @if(isset($buildingMaterials))
                  @if(isset($requisition->buildingMaterial1))
                    @foreach($buildingMaterials as $element)
                      <option value="{{$element['id']}}" {{$element['id'] == $requisition->buildingMaterial1['buildingMaterials_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                    @endforeach
                  @else
                    @foreach($buildingMaterials as $element)
                      <option value="{{$element['id']}}">{{$element['name']}}</option>
                    @endforeach
                  @endif
                @endif
              </select>
            </div>
          </div>
          @if(isset($requisition))
            @for($i = 2 ; $i <= $requisition->CountMaterial;$i++)
              <div id="{{'fDBM-'.$i}}">
                <hr>
                <div class="headerAppend">Material de Construcción {{$i}}
                  <button type="button" id="{{'deleteBuildingMaterial-'.$i}}" class="btn float-right" onclick="deleteBuildingMaterial(this)">
                    <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                  </button>
                </div>
                <div class="form-row" style="display: none;">
                  <div class="form-group col-md-12">
                    @if(isset($requisition['buildingMaterial'.$i]))
                      <input type="hidden" class="form-control" id="{{'buildingmaterialid'.$i}}" name="{{'buildingmaterialid'.$i}}" value="{{$requisition['buildingMaterial'.$i]['id']}}">
                    @else
                      <input type="hidden" class="form-control" id="{{'buildingmaterialid'.$i}}" name="{{'buildingmaterialid'.$i}}" value="">
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="{{'buildingMaterials_id'.$i}}">Material</label>
                    <select id="{{'buildingMaterials_id'.$i}}"  name="{{'buildingMaterials_id'.$i}}" class="form-control" required>
                      <option value="">seleccione...</option>
                      @if(isset($buildingMaterials))
                        @if(isset($requisition['buildingMaterial'.$i]))
                          @foreach($buildingMaterials as $element)
                            <option value="{{$element['id']}}" {{$element['id'] == $requisition['buildingMaterial'.$i]['buildingMaterials_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                          @endforeach
                        @else
                          @foreach($buildingMaterials as $element)
                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                          @endforeach
                        @endif
                      @endif
                    </select>
                  </div>
                </div>
              </div>
            @endfor
          @endif
          <div id="buildingMaterials"></div>
          <hr>
          <div>
            <span class="m-0 font-weight-bold text-primary title-table">Servicios
              <button type="button"  id="addService" class="btn btn-primary float-right">Agregar</button>
            </span>
            @if(isset($requisition->CountServis))
              <input type="hidden" name="countService" id="countService" value="{{$requisition->CountServis == "0" || $requisition->CountServis == null ? 1 : $requisition->CountServis}}">
              <input type="hidden" name="countTotalS" id="countTotalS" value="{{$requisition->CountServis == "0" || $requisition->CountServis == null ? 1 : $requisition->CountServis}}">
            @else
              <input type="hidden" name="countService" id="countService" value="1">
              <input type="hidden" name="countTotalS" id="countTotalS" value="1">
            @endif
          </div>
          <hr>
          <div class="headerAppend">Servicio Principal</div>
          <div class="form-row" style="display: none;">
            <div class="form-group col-md-12">
              @if(isset($requisition['services1']))
                <input type="hidden" class="form-control" id="servicesid1" name="servicesid1" value="{{$requisition['services1']['id']}}">                 
              @else                
                <input type="hidden" class="form-control" id="servicesid1" name="servicesid1" value="">
              @endif
          	</div>
         </div>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="services_id1">Servicio</label>
              <select id="services_id1" name="services_id1" class="form-control" required>
                <option value="">selecciona...</option>
                @if(isset($services))
                  @if(isset($requisition->services1))
                    @foreach($services as $element)
                      <option value="{{$element['id']}}" {{$element['id'] == $requisition->services1['services_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                    @endforeach
                  @else
                    @foreach($services as $element)
                      <option value="{{$element['id']}}">{{$element['name']}}</option>
                    @endforeach
                  @endif
                @endif
              </select>
            </div>
          </div>
          @if(isset($requisition))
            @for($i = 2 ; $i <= $requisition->CountServis;$i++)
              <div id="{{'fDS-'.$i}}">
                <hr>
                <div class="headerAppend">Servicio {{$i}}
                  <button type="button" id="{{'deleteService-'.$i}}" class="btn float-right" onclick="deleteService(this)">
                    <i class="fas fa-trash-alt fa-2x colorIcon"></i>
                  </button>
                </div>
                <div class="form-row" style="display: none;">
                  <div class="form-group col-md-12">
                    @if(isset($requisition['services'.$i]))
                      <input type="hidden" class="form-control" id="{{'servicesid'.$i}}" name="{{'servicesid'.$i}}" value="{{$requisition['services'.$i]['id']}}">
                    @else
                      <input type="hidden" class="form-control" id="{{'servicesid'.$i}}" name="{{'servicesid'.$i}}" value="">
                    @endif
                  </div>
                </div>
                <div class="form-group col-md-12">
                  @if(isset($requisition['servicesid'.$i]))
                    <input type="hidden" class="form-control" id="{{'servicesid'.$i}}" name="{{'servicesid'.$i}}" value="{{$requisition['servicesid'.$i]['name']}}">
                  @else
                    <input type="hidden" class="form-control" id="{{'servicesid'.$i}}" name="{{'servicesid'.$i}}" value="">
                  @endif
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="{{'services_id'.$i}}">Servicio</label>
                    <select id="{{'services_id'.$i}}"  name="{{'services_id'.$i}}" class="form-control" required>
                      <option value="">seleccione...</option>
                        @if(isset($services))
                          @if(isset($requisition['services'.$i]))
                            @foreach($services as $element)
                              <option value="{{$element['id']}}" {{$element['id'] == $requisition['services'.$i]['services_id'] ? 'selected' : '' }}>{{$element['name']}}</option>
                            @endforeach
                          @else
                            @foreach($services as $element)
                              <option value="{{$element['id']}}">{{$element['name']}}</option>
                            @endforeach
                          @endif
                        @endif
                    </select>
                  </div>
                </div>
              </div>
            @endfor
          @endif

          <div id="services"></div>
          <hr>
          <a href="solicitudes"  class="btn btn-primary float-right">Cancelar</a>
          <button type="button" id="lifeConditions-1"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Siguiente</button>
          <button type="button" id="lifeConditions-2"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Anterior</button>
          <button type="button" onclick="saveAfter()" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar para después</button>          
        </div>
        {{-- economicData --}}
        <div class="tab-pane fade" id="economicData" role="tabpanel" aria-labelledby="economicData-tab">
          <br>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="income">Ingresos</label>
              @if(isset($economicData))
                <input type="text" class="form-control" id="income" name="income" placeholder="Ingresa los ingresos mensuales del beneficiario" required value="{{$economicData['income']}}">
              @else
                <input type="text" class="form-control" id="income" name="income" placeholder="Ingresa los ingresos mensuales del beneficiario" required>
              @endif
            </div>
            <div class="form-group col-md-4">
              <label for="expense">Egresos</label>
              @if(isset($economicData))
                <input type="text" class="form-control" id="expense" name="expense" placeholder="Ingresa los egresos mensuales del beneficiario" value="{{$economicData['expense']}}">
              @else
                <input type="text" class="form-control" id="expense" name="expense" placeholder="Ingresa los egresos mensuales del beneficiario">
              @endif
            </div>
          </div>
          <a href="solicitudes"  class="btn btn-primary float-right">Cancelar</a>
          <button type="submit" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar</button>
          <button type="button" id="economicData-1"  onclick="nextNavTab(this)" class="btn btn-primary float-right" style="margin-right: 3px;">Anterior</button>
          <button type="button" onclick="saveAfter()" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar para después</button>
        </div>
       </div> 
    </form>
  </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Recorte de imagen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="img-container">
          <div class="row">
            <div class="col-md-8">
              <img id="imageCrop" src="">
            </div>
            <div class="col-md-4">
              <div class="preview"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="crop">recortar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal de información del apoyo --}}
<div class="row">
  <div class="col-md-12">
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-warning">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-warning-title">¡AVISO IMPORTANTE!</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div id="alert-container"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection

@section('jsDashboard')
  <script src="../assets/js/mainForm.js"></script>
  <script src="../assets/js/RequestForm.js"> </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
@endsection