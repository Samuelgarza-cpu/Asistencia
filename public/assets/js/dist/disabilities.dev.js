"use strict";

$(function () {
  'use strict';

  addModal();
  refresh('/diagnostico');
});
window.operateEvents = {
  'click .update': function clickUpdate(e, value, row, index) {
    // alert('You click like action, row: ' + JSON.stringify(row));
    $('.modal-title').text('Modificar Registro');
    $('#action').val("update");
    $('#frm').removeClass('was-validated');
    $('#id').val(row.id);
    $('#name').val(row.name);
    $('#categories_id').val(row.disabilitycategories_id);
    if (row.active == 1) $('#active').attr("checked", "checked");else $('#active').removeAttr("checked");
    $('#modal-register').modal('toggle');
  },
  'click .remove': function clickRemove(e, value, row, index) {
    $('#registerId').val(row.id);
    $('#modal-confirmation').modal('toggle');
  }
};