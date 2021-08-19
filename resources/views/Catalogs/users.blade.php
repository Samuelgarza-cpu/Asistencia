@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Usuarios
@endsection

@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="name" data-sortable="true">Usuario</th>
  <th data-field="role" data-sortable="true">Rol</th>
  <th data-field="department" data-sortable="true">Departamento</th>
  <th data-field="institute" data-sortable="true">Instituto</th>
  <th data-field="owner" data-sortable="true">Dueño</th>
  <th data-field="email">Correo</th>
  <th data-field="status" data-sortable="true">Estado</th>

  <th data-field="actions" data-events="operateEvents" data-width="80">Acciones</th>
@endsection

@section('contentForm')
@endsection

@section('jsForm')
  <script src="../assets/js/User.js"></script>
@endsection