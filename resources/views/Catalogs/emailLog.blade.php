@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Bitácora de Correos
@endsection

@section('headerTable')
    <th data-field="id" data-sortable="true">#</th>
    <th data-field="date" data-sortable="true">Fecha</th>
    <th data-field="sender" data-sortable="true">De</th>
    <th data-field="recipient" data-sortable="true">Para</th>
    <th data-field="status" data-sortable="true">Estatus</th>
    <th data-field="descriptionStatus">Descripción</th>    
@endsection

@section('contentForm')
@endsection

@section('jsForm')
  {{-- Bootstrap table --}}
  <script src="../assets/js/bootstrap-table.min.js"></script>
  <script src="../assets/js/bootstrap-table-locale-all.min.js"></script>
  <script src="../assets/js/emaillog.js"></script>
@endsection