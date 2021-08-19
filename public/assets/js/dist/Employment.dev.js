"use strict";

$(function () {
  'use strict';

  addModal();
  refresh('/ocupaciones');
});
window.operateEvents = {
  'click .update': function clickUpdate() {
    var $tabla = $("#dataTable");
    $tabla.on('click-row.bs.table', function (row, $element) {
      $('.modal-title').text('Modificar Registro');
      $('#action').val("update");
      $('#frm').removeClass('was-validated');
      $('#id').val($element.id);
      $('#name').val($element.name);
      $('#modal').modal('toggle');
    });
  },
  'click .remove': function clickRemove() {
    var $tabla = $("#dataTable");
    $tabla.on('click-row.bs.table', function (row, $element) {
      $('#registerId').val($element.id);
      $('#modal-confirmation').modal('toggle');
    });
  }
};