$(function() {
    'use strict';
    addNew('registrar_relacion');
    refresh('/instituto_departamento');
});

window.operateEvents = {
    'click .update': function(e, value, row, index) {
        window.location.href = 'modificar_relacion/' + row.id;
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    }
}

// window.operateEvents = {
//     'click .update': function(e, value, row, index) {
//         // alert('You click like action, row: ' + JSON.stringify(row));
//         $('.modal-title').text('Modificar Registro');
//         $('#action').val("update");
//         $('#frm').removeClass('was-validated')
//         $('#id').val(row.id);
//         $('#departments_id').val(row.departments_id);
//         $('#image').removeAttr("required");
//         $('#institutes_id').val(row.institutes_id);
//         if (row.stampSRC == null) {
//             $('#imagenPrevisualizacion').removeAttr('src');
//             $('#imagenPrevisualizacion').removeAttr('class');
//         } else {
//             $('#imagenPrevisualizacion').addClass("file-img");
//             $('#imagenPrevisualizacion').attr('src', row.stampSRC);
//         }

//         if (row.stampSRC == null) {
//             $('#imagenPrevisualizacion2').removeAttr('src');
//             $('#imagenPrevisualizacion2').removeAttr('class');
//         } else {
//             $('#imagenPrevisualizacion2').attr('src', row.imageSRC);
//             $('#imagenPrevisualizacion2').addClass("file-img");
//         }


//         $('#modal-register').modal('toggle');
//     },
//     'click .remove': function(e, value, row, index) {
//         $('#registerId').val(row.id);
//         $('#modal-confirmation').modal('toggle');
//     }
// }