"use strict";

$(function () {
  'use strict';

  addNew('Nuevo_usuario');
  refresh('/usuarios');
});
window.operateEvents = {
  'click .update': function clickUpdate() {
    window.location.href = 'modificar_usuario';
  },
  'click .remove': function clickRemove() {
    var $tabla = $("#dataTable");
    $tabla.on('click-row.bs.table', function (row, $element) {
      $('#registerId').val($element.id);
      $('#modal-confirmation').modal('toggle');
    });
  }
};