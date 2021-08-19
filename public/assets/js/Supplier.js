$(function() {
    'use strict';
    addNew('registrar_proveedor');
    refresh('/proveedores');
});

window.operateEvents = {
    'click #update': function(e, value, row, index) {
        window.location.href = 'modificar_proveedor/' + row.id;
    },
    'click #remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    },
    'click #addProduct': function(e, value, row, index) {
        window.location.href = 'productosdelproveedor/' + row.id;
    }

}