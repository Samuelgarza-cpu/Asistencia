@extends('base.forms')
@section('cssForm')
@endsection

@section('titleTable')
  Relacionar Departamentos con Instituto
@endsection

@section('headerTable')
  <th data-field="number" data-sortable="true">#</th>
  <th data-field="department" data-sortable="true">Departamento</th>
  <th data-field="institute" data-sortable="true">Instituto</th>
  <th data-field="actions" data-events="operateEvents" data-width="80"></th>
@endsection

@section('contentForm')
@endsection

@section('jsForm')
  <script src="../assets/js/DepartmentInstitute.js"></script>
@endsection