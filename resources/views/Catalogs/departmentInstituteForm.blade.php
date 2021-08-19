@extends('base.base')
@section('cssDashboard')
@endsection

@section('text')
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary title-table">Relacionar departamento e institución</span>
      </div>
    <div class="card-body">
        <form method="POST" action="{{Request::url()}}" class="needs-validation" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="action" id="action" value="{{$action}}"/>
            @if(isset($department_institute))
              <input type="hidden" name="id" id="id" value="{{$department_institute['id']}}">
            @else
              <input type="hidden" name="id" id="id" value="0">
            @endif

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="institutes_id">Instituto:</label>
                    <select type="text" class="form-control" id="institutes_id" name="institutes_id" required>
                        <option value="">Selecciona...</option>
                        @if(isset($institutes))
                            @if(isset($department_institute))
                                @foreach($institutes as $element)
                                    <option value="{{$element['id']}}" {{$element['id'] == $department_institute->institutes_id ? 'selected' : ''}}>{{$element['name']}}</option>
                                @endforeach
                            @else
                                @foreach($institutes as $element)
                                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                    <div class="invalid-feedback">
                        Favor de seleccionar el insistuto a relacionar
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="departments_id">Departamento:</label>
                    <select type="text" class="form-control" id="departments_id" name="departments_id" required>
                        <option value="">Selecciona...</option>
                        @if(isset($departments))
                            @if(isset($department_institute))
                                @foreach($departments as $element)
                                    <option value="{{$element['id']}}" {{$element['id'] == $department_institute->departments_id ? 'selected' : ''}}>{{$element['name']}}</option>
                                @endforeach
                            @else
                                @foreach($departments as $element)
                                    <option value="{{$element['id']}}">{{$element['name']}}</option>
                                @endforeach
                            @endif
                        @endif
                    </select>
                    <div class="invalid-feedback">
                        Favor de seleccionar el insistuto a relacionar
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group files-div col-md-3">
                    @if(isset($department_institute->stamp))                        
                        <span class="file stamp-img">
                            <input type="file" accept="image/*" name="stamp" id="stamp" class="form-control">
                            <div class="invalid-feedback">
                                Favor de ingresar la imagen del sello del departamento
                            </div>
                        </span>
                        <label for="stamp" class="label-button">
                            <span id="title-dept">{{$department_institute->stamp}}</span>
                        </label>
                    @else
                        <span class="file stamp-img">
                            <input type="file" accept="image/*" name="stamp" id="stamp" class="form-control" required>
                            <div class="invalid-feedback">
                                Favor de ingresar la imagen del sello del departamento
                            </div>
                        </span>
                        <label for="stamp" class="label-button">
                            <span id="title-dept">Subir el sello del departamento</span>
                        </label>
                    @endif
                </div>
                <div class="form-group files-div col-md-3">
                    @if(isset($department_institute->stampSRC))
                        <img id="imagenPrevisualizacion" src="{{$department_institute->stampSRC}}">
                    @else
                        <img id="imagenPrevisualizacion">
                    @endif
                </div>
                <div class="form-group files-div col-md-3">
                    @if(isset($department_institute->image))
                        <span class="file image-img">
                            <input type="file" accept="image/*" name="image" id="image" class="form-control">
                            <div class="invalid-feedback">
                                Favor de ingresar la imagen del departamento
                            </div>
                        </span>
                        <label for="image" class="label-button">
                            <span>{{$department_institute->image}}</span>
                        </label>  
                    @else
                        <span class="file image-img">
                            <input type="file" accept="image/*" name="image" id="image" class="form-control" required>
                            <div class="invalid-feedback">
                                Favor de ingresar la imagen del departamento
                            </div>
                        </span>
                        <label for="image" class="label-button">
                            <span>Subir la imagen del departamento</span>
                        </label>  
                    @endif
                </div>
                <div class="form-group files-div col-md-3">
                    @if(isset($department_institute->imageSRC))
                        <img id="imagenPrevisualizacion2" src="{{$department_institute->imageSRC}}">
                    @else
                        <img id="imagenPrevisualizacion2">
                    @endif
                </div>
            </div>
            <div class="headerAppend">Dirección Principal</div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="street">Calle</label>
                    @if(isset($address))
                        <input type="text" class="form-control" id="street" name="street" placeholder="Ingresar la calle" required value="{{$address->street}}">
                    @else
                        <input type="text" class="form-control" id="street" name="street" placeholder="Ingresar la calle" required>
                    @endif
                    <div class="invalid-feedback">
                    Favor de ingresar la calle de la dirección del departamento
                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="externalNumber">Número externo</label>
                    @if(isset($address))
                        <input type="text" class="form-control" id="externalNumber" name="externalNumber" placeholder="Ingresar el número externo" required value="{{$address->externalNumber}}">
                    @else
                        <input type="text" class="form-control" id="externalNumber" name="externalNumber" placeholder="Ingresar el número externo" required>
                    @endif
                    <div class="invalid-feedback">
                    Favor de ingresar el número externo de la dirección del departamento
                    </div>  
                </div>
                <div class="form-group col-md-3">
                    <label for="internalNumber">Número interno</label>
                    @if(isset($address))
                        <input type="text" class="form-control" id="internalNumber" name="internalNumber" placeholder="Ingresar el número interno" value="{{$address->internalNumber}}">
                    @else
                        <input type="text" class="form-control" id="internalNumber" name="internalNumber" placeholder="Ingresar el número interno">
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="postalCode">Código Postal</label>
                    <div class="input-group">
                        @if(isset($community))
                            <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Ingresa tú numero postal" required data-mask="00000" value="{{$community->postalCode}}">
                        @else
                            <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Ingresa tú numero postal" required data-mask="00000">
                        @endif
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="filterCP(this)" id="filter">Filtrar</button>
                        </div>
                        <div class="invalid-feedback">
                            Favor de ingresar el código postal de la dirección del proveedor
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="communities_id">Colonia</label>
                    @if(isset($address))
                        <select id="communities_id" name="communities_id" class="form-control" required>
                            <option value="">Selecciona...</option>
                            @if(isset($communities))
                                @foreach($communities as $element)
                                <option value="{{$element['id']}}" {{$element['id'] == $address->communities_id ? 'selected' : '' }}>{{$element['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    @else
                        <select id="communities_id" name="communities_id" class="form-control" disabled required>
                            <option value="">Selecciona...</option>
                            @if(isset($communities))
                                @foreach($communities as $element)
                                <option value="{{$element['id']}}" {{$element['id'] == $address->communities_id ? 'selected' : '' }}>{{$element['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="municipalities_id">Municipio</label>
                    <select id="municipalities_id" name="municipalities_id" class="form-control" disabled required>
                        <option value="">Selecciona...</option>
                        @if(isset($address))
                            @if(isset($municipalities))
                                <option value="{{$municipalities->id}}" selected>{{$municipalities->name}}</option>
                            @endif
                        @endif
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="states_id">Estado</label>
                    <select id="states_id" name="states_id" class="form-control" disabled required>
                        <option value="">Selecciona...</option>
                        @if(isset($address))
                            @if(isset($states))
                            <option value="{{$states->id}}" selected>{{$states->name}}</option>
                            @endif
                        @endif
                    </select>
                </div>
            </div>

            <a href="instituto_departamento "  class="btn btn-primary float-right">Cancelar</a>
            <button type="submit" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar</button>
          </form>
    </div>
</div>
@endsection

@section('jsDashboard')
  <script src="../assets/js/mainForm.js"></script>
  <script src="../assets/js/departmentInstituteForm.js"></script>
@endsection