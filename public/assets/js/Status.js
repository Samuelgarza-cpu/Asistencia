$(function() {
    'use strict';
    addWActiveAColor();
    refresh('/estados_solicitud');
    $("input#color").ColorPickerSliders({
        size: 'sm',
        placement: 'right',
        swatches: false,
        sliders: false,
        hsvpanel: true
    });
});

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        $('.modal-title').text('Modificar Registro');
        $('#action').val("update");
        $('#frm').removeClass('was-validated')
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#color').val(row.color);
        $("#color").trigger("colorpickersliders.updateColor", row.color);
        if (row.active == 1)
            $('#active').attr("checked", "checked");
        else
            $('#active').removeAttr("checked");
        $('#modal-register').modal('toggle');
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}

function cellStyle(value, row, index) {
    console.log(row);
    return {
        css: {
            background: row.color
        }
    }
}