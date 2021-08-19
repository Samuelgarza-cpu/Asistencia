@extends('base.base')
@section('cssDashboard')
@endsection

@section('text')
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <span class="m-0 font-weight-bold text-primary title-table" id="titleForm">{{$action == "new" ? 'Registrar nuevo usuario' : 'Modificar usuario'}}</span>
      </div>
    <div class="card-body">
        <form method="POST" action="{{Request::url()}}" class="needs-validation" enctype="multipart/form-data" novalidate>
            @csrf
            <input type="hidden" name="action" id="action" value="{{$action}}"/>
            @if(isset($user))
              <input type="hidden" name="id" id="id" value="{{$user['id']}}">
            @else
              <input type="hidden" name="id" id="id" value="0">
            @endif

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="owner">Nombre del dueño:</label>
                @if(isset($user))
                  <input type="text" class="form-control" id="owner" name="owner" placeholder="Ingrese el nombre del dueño del usuario" required value="{{$user['owner']}}">
                @else
                  <input type="text" class="form-control" id="owner" name="owner" placeholder="Ingrese el nombre del dueño del usuario" required>
                @endif
                <div class="invalid-feedback">
                    Favor de ingresar el nombre del dueño del usuario
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="email">Correo electrónico</label>
                @if(isset($user))
                  <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico" required value="{{$user['email']}}">
                @else
                  <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el correo electrónico" required>
                @endif  
                <div class="invalid-feedback">
                    Favor de ingresar el correo electrónico del usuario
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">Nombre de usuario:</label>
                @if(isset($user))
                  <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre del usuario" value="{{$user['name']}}" required>
                @else
                  <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre del usuario" required>
                @endif  
                <div class="invalid-feedback">
                    Favor de ingresar el nombre del usuario
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="password">Contraseña</label>
                @if(isset($user))
              <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña" required value="{{$user['password']}}">
                @else
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña" required>
                @endif 
                
                <div class="invalid-feedback">
                    Favor de ingresar la contraseña del usuario
                </div>
              </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="roles_id">Rol</label>
                      <select id="roles_id" name="roles_id" class="form-control" required>
                      <option value="">selecciona...</option>
                      @if(isset($roles))
                        @if(isset($user))
                          @foreach($roles as $element)
                            <option value="{{$element['id']}}" {{ ( $element['id'] == $user["roles_id"]) ? 'selected' : '' }}>{{$element['name']}}</option>
                          @endforeach
                        @else
                          @foreach($roles as $element)
                            <option value="{{$element['id']}}">{{$element['name']}}</option>
                          @endforeach
                        @endif
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="departments_institutes_id">Departamento</label>
                    <select id="departments_institutes_id" name="departments_institutes_id" class="form-control" required>
                      <option value="">selecciona...</option>
                      @if(isset($departments))
                        @if(isset($user))
                          @foreach($departments as $element)
                            <option value="{{$element['id_of_institute_deparment']}}" {{ ( $element['id_of_institute_deparment'] == $user["departments_institutes_id"]) ? 'selected' : '' }}>{{$element['name_with_institute']}}</option>
                          @endforeach
                        @else
                          @foreach($departments as $element)
                            <option value="{{$element['id_of_institute_deparment']}}">{{$element['name_with_institute']}}</option>
                          @endforeach
                        @endif
                      @endif
                    </select>
                  </div>
                  <div class="form-group col-md-3">
                    <label for="active">¿Activo?</label>
                    
                    <div class="custom-control custom-switch">
                      @if(isset($user))
                      <input type="checkbox" class="custom-control-input" name="active" id="active" {{($user["active"] == true) ? 'checked' : ''}}>
                      @else
                      <input type="checkbox" class="custom-control-input" name="active" id="active">
                      @endif  
                      <label class="custom-control-label" for="active">Deslice a la derecha para activar usuario</label>
                    </div>                  
                  </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 files-div">
                @if(isset($user['signature']))
                <span class="file">
                  <input type="file" accept="image/*" name="signature" id="signature" class="form-control">
                </span>
                <label for="signature">
                    <span>{{$user['signature']}}</span>
                </label>                
                    @else
                    <span class="file">
                      <input type="file" accept="image/*" name="signature" id="signature" class="form-control" required>
                      <div class="invalid-feedback">
                        Favor de ingresar la imagen de la firma del usuario
                    </div>
                    </span>
                    <label for="signature">
                        <span>Subir la firma del usuario</span>
                    </label>
                    @endif  
              </div>
              <div class="form-group col-md-6 files-div">
                @if(isset($user))
                  <img id="imagenPrevisualizacion" src="{{$user['signatureSRC']}}" class="file-img">
                @else
                  <img id="imagenPrevisualizacion" class="file-img">
                @endif
              </div>
            </div>

            <a href="usuarios"  class="btn btn-primary float-right">Cancelar</a>
            <button type="submit" class="btn btn-primary float-right" style="margin-right: 3px;">Guardar</button>
          </form>
    </div>
</div>
@endsection

@section('jsDashboard')
  <script src="../assets/js/mainForm.js"></script>
  <script src="../assets/js/UserForm.js"></script>
@endsection