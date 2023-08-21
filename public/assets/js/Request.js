$(function() {
    'use strict';
    addNew('nueva_solicitud');
    refresh('/solicitudes');
    var inputs = document.querySelectorAll('.document');
    Array.prototype.forEach.call(inputs, function(input) {
        var label = input.nextElementSibling,
            labelVal = label.innerHTML;
        input.addEventListener('change', function(e) {
            var fileName = '';
            if (this.files && this.files.length > 1)
                fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
            else
                fileName = e.target.value.split("'\'").pop();
            if (fileName) {
                label.querySelector('span').innerHTML = fileName;
                let reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
            } else {
                label.innerHTML = labelVal;
            }
        });
    });

   // $('#active').change(addDeliveryPictures);



});
// function addDeliveryPictures() {
//     if (this.checked) {

//         var deliverypicturedivID = $('#deliveryPicture');
//         var inputdeliveryid = "price";

        // var spaninputdelivery = document.createElement('span');
        // spaninputdelivery.setAttribute("class", "file deliveryImage");

        // var inputdelivery = document.createElement('input');
        // inputdelivery.setAttribute("type", "text");
        // inputdelivery.setAttribute("class", "form-control");
        // inputdelivery.setAttribute("id", "price");
        // inputdelivery.setAttribute("name", inputdeliveryid);
        // inputdelivery.setAttribute("required", "required");


        // var divErrorDelivery = document.createElement('div');
        // divErrorDelivery.setAttribute("class", "invalid-feedback")
        // divErrorDelivery.textContent = "Favor de ingresar la imagen de entrega";

        // var labeldelivery = document.createElement('label');
        // labeldelivery.setAttribute("for", inputdeliveryid);
        // labeldelivery.setAttribute("class", "label-button");

        // var spanlabel = document.createElement('span');
        // spanlabel.setAttribute("id", "title-delivery");
        // spanlabel.textContent = "Añadir imagen de entrega";

        //deliverypicturedivID.append(inputdelivery);

        // spaninputdelivery.append(inputdelivery);
        // spaninputdelivery.append(divErrorDelivery);
        // deliverypicturedivID.append(labeldelivery);
        // labeldelivery.append(spanlabel);

        // var inputs = document.querySelectorAll('.deliveryImage');
        // Array.prototype.forEach.call(inputs, function(input) {
        //     var label = input.nextElementSibling,
        //         labelVal = label.innerHTML;
        //     input.addEventListener('change', function(e) {
        //         var fileName = '';
        //         if (this.files && this.files.length > 1)
        //             fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
        //         else
        //             fileName = e.target.value.split("'\'").pop();
        //         if (fileName) {
        //             label.querySelector('span').innerHTML = fileName;
        //             let reader = new FileReader();
        //             reader.readAsDataURL(e.target.files[0]);
        //         } else {
        //             label.innerHTML = labelVal;
        //         }
        //     });
        // });
//     } else {
//         var formGroupDelete = $('#deliveryPicture');
//         formGroupDelete.find('span').remove();
//         formGroupDelete.find('label').remove();
//     }
// }

window.operateEvents = {
    'click .update': function(e, value, row, index) {

        window.location.href = 'modificar_solicitud/' + row.id;
    },
    'click .generatePDF': function(e, value, row, index) {
        window.location.href = 'generardocumento/' + row.id;
    },
    'click .remove': function(e, value, row, index) {
        $('#registerId').val(row.id);
        $('#modal-confirmation').modal('toggle');
    },
    'click .auth': function(e, value, row, index) {
        $('#registerRId').val(row.id);
        $('#action4').val('autorizar');
        $('#title-modal-confirmation').text('Autorizar Solicitud');
        $('#modal-confirmation-request').modal('toggle');

    },
    'click .verify': function(e, value, row, index) {
        $('#registerRId').val(row.id);
        $('#action4').val('Pendiente de Verificación');
        $('#title-modal-confirmation').text('Verificar Solicitud');
        $('#modal-confirmation-request').modal('toggle');

    },
    'click .nauth': function(e, value, row, index) {
        $('#registerRId').val(row.id);
        $('#action4').val('rechazar');
        $('#title-modal-confirmation').text('Rechazar Solicitud');
        $('#modal-confirmation-request').modal('toggle');

    },
    'click .giveProducts': function(e, value, row, index) {
        $('#registerRId').val(row.id);
        $('#action4').val('entregar');
        $('#title-modal-confirmation').text('Mensaje de Solicitud');
        $('#modal-confirmation-request').modal('toggle');

    },
    'click .addDocument': function(e, value, row, index) {
        $('#registerDId').val(row.id);
        document.getElementById("frm-addDocument").reset();
        var titledept = document.getElementById("title-dept");
        titledept.innerHTML = "Subir el documento de la solicitud";

        //var formGroupDelete = $('#deliveryPicture');
        //formGroupDelete.find('span').remove();
        //formGroupDelete.find('label').remove();

        $('#modal-addDocument').modal('toggle');
    },
    'click .addDeliveryPicture': function(e, value, row, index) {
        $('#registerIId').val(row.id);
        document.getElementById("frm-addDeliveryPicture").reset();
        var titleimg = document.getElementById("title-image");
        titleimg.innerHTML = "Subir la imagen de entrega";
        $('#modal-addDeliveryPicture').modal('toggle');
    },
    //  'click .showDocument': function(e, value, row, index) {
    //      var registerSDId = row.id;
    //      //$('#registerDId').val(row.id);
    //      var action = "getDocument";
    //      $.ajax({
    //              type: "POST",
    //              url: "solicitudes",
    //              data: { 'action': action, "_token": $("meta[name='csrf-token']").attr("content") }
    //          })
    //          .done(function(response) {
    //             //console.log(response);
    //             // debugger;
    //             // var embed = $('#embedx');
    //             // embed.attr("src", response);
    //              $('#modal-showDocument').modal('toggle');
    //          })
    //          .fail(function() {
    //              console.log("error");
    //              $('#modal-showDocument').modal('toggle');
    //          })
    //          .always(function() {})
    //  },
    'click .showDocument': function(e, value, row, index) {
         window.location.href = 'verdocumento/' + row.id;
     },
}