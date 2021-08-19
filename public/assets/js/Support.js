$(function() {
    'use strict';
    addWActive();
    refresh('/apoyos');
});

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        // alert('You click like action, row: ' + JSON.stringify(row.id));
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#name').val(row.name);
        if (row.active == 1)
            $('#active').attr("checked", "checked");
        else
            $('#active').removeAttr("checked");
        // $('#departments_institutes_id').val(row.departments_institutes_id);
        $('#modal-register').modal('toggle');
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}