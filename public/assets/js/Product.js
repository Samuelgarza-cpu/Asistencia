$(function() {
    'use strict';
    addModal();
    refresh('/productos');
});

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#categories_id').val(row.categories_id);
        $('#modal-register').modal('toggle');
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}