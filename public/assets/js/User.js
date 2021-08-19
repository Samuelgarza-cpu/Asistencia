$(function() {
    'use strict';
    addNew('registrar_usuario');
    refresh('/usuarios');
});

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        window.location.href = 'modificar_usuario/' + row.id;
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}