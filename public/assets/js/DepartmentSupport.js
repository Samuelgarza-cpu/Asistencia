$(function() {
    'use strict';
    addModal();
    refresh('/apoyos_departamento');
});

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row));
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#departmentsInstitutes_id').val(row.departmentsInstitutes_id);
        $('#supports_id').val(row.supports_id);
        $('#modal-register').modal('toggle');
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}