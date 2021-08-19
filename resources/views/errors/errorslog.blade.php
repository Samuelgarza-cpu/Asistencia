@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Bitácora de errores
@endsection

@section('headerTable')
    <th data-field="id" data-sortable="true">#</th>
    <th data-field="date" data-sortable="true">Fecha</th>
    <th data-field="description">Descripción</th>
    <th data-field="owner" data-sortable="true">Dueño</th>
    <th data-field="users_id" data-sortable="true">Usuario</th>

@endsection

@section('contentForm')
@endsection

@section('jsForm')
  {{-- Bootstrap table --}}
  <script src="../assets/js/bootstrap-table.min.js"></script>
  <script src="../assets/js/bootstrap-table-locale-all.min.js"></script>
  <script src="../assets/js/errors.js"></script>
@endsection