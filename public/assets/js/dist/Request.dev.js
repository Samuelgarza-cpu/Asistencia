"use strict";

$(function () {
  'use strict';

  addNew('nueva_solicitud');
  refresh('/solicitudes');
  var inputs = document.querySelectorAll('.document');
  Array.prototype.forEach.call(inputs, function (input) {
    var label = input.nextElementSibling,
        labelVal = label.innerHTML;
    input.addEventListener('change', function (e) {
      var fileName = '';
      if (this.files && this.files.length > 1) fileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);else fileName = e.target.value.split("'\'").pop();

      if (fileName) {
        label.querySelector('span').innerHTML = fileName;
        var reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
      } else {
        label.innerHTML = labelVal;
      }
    });
  });
});
window.operateEvents = {
  'click .update': function clickUpdate(e, value, row, index) {
    window.location.href = 'modificar_solicitud/' + row.id;
  },
  'click .generatePDF': function clickGeneratePDF(e, value, row, index) {
    window.location.href = 'generardocumento/' + row.id;
  },
  'click .remove': function clickRemove(e, value, row, index) {
    $('#registerId').val(row.id);
    $('#modal-confirmation').modal('toggle');
  },
  'click .auth': function clickAuth(e, value, row, index) {
    $('#registerRId').val(row.id);
    $('#action4').val('autorizar');
    $('#title-modal-confirmation').text('Autorizar Solicitud');
    $('#modal-confirmation-request').modal('toggle');
  },
  'click .nauth': function clickNauth(e, value, row, index) {
    $('#registerRId').val(row.id);
    $('#action4').val('rechazar');
    $('#title-modal-confirmation').text('Rechazar Solicitud');
    $('#modal-confirmation-request').modal('toggle');
  },
  'click .giveProducts': function clickGiveProducts(e, value, row, index) {
    $('#registerRId').val(row.id);
    $('#action4').val('entregar');
    $('#title-modal-confirmation').text('Mensaje de Solicitud');
    $('#modal-confirmation-request').modal('toggle');
  },
  'click .addDocument': function clickAddDocument(e, value, row, index) {
    $('#registerDId').val(row.id);
    $('#modal-addDocument').modal('toggle');
  },
  // 'click .showDocument': function(e, value, row, index) {
  //     var registerSDId = row.id;
  //     var action = "getDocument";
  //     $.ajax({
  //             type: "POST",
  //             url: "solicitudes",
  //             data: { 'action': action, "id": registerSDId, "_token": $("meta[name='csrf-token']").attr("content") }
  //         })
  //         .done(function(response) {
  //             console.log(response);
  //             var embed = $('#embed');
  //             embed.attr('src', response.src);
  //             $('#modal-showDocument').modal('toggle');
  //         })
  //         .fail(function() {
  //             console.log("error");
  //             $('#modal-showDocument').modal('toggle');
  //         })
  //         .always(function() {})
  // },
  'click .showDocument': function clickShowDocument(e, value, row, index) {
    window.open(window.location.href = 'verdocumento/' + row.id);
  }
};