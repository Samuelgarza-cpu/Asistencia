"use strict";

$(function () {
  'use strict';

  addNew('registrar_proveedor');
  refresh('/proveedores');
});
window.operateEvents = {
  'click #update': function clickUpdate(e, value, row, index) {
    window.location.href = 'modificar_proveedor/' + row.id;
  },
  'click #remove': function clickRemove(e, value, row, index) {
    $('#registerId').val(row.id);
    $('#modal-confirmation').modal('toggle');
  },
  'click #addProduct': function clickAddProduct(e, value, row, index) {
    window.location.href = 'productosdelproveedor/' + row.id;
  }
};