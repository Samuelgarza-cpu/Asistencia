@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Proveedores
@endsection

@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="companyname" data-sortable="true">Nombre</th>
  <th data-field="phones">Numeros de contacto</th>
  <th data-field="description">Descripción</th>
  <th data-field="fulladdress">Dirección</th>
  <th data-field="status">¿Activo?</th>
  <th data-field="actions" data-events="operateEvents" data-width="80"></th>
@endsection

@section('contentForm')
@endsection

@section('jsForm')
  <script src="../assets/js/Supplier.js"></script>
@endsection
