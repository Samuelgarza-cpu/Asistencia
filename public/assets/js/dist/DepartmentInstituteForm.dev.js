"use strict";

$(function () {
  'use strict';

  var inputs = document.querySelectorAll('.stamp-img');
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

        reader.onload = function () {
          var preview = document.getElementById('imagenPrevisualizacion');
          preview.src = reader.result;
          preview.setAttribute("class", "file-img");
        };
      } else {
        label.innerHTML = labelVal;
      }
    });
  });
  var inputs = document.querySelectorAll('.image-img');
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

        reader.onload = function () {
          var preview = document.getElementById('imagenPrevisualizacion2');
          preview.src = reader.result;
          preview.setAttribute("class", "file-img");
        };
      } else {
        label.innerHTML = labelVal;
      }
    });
  });
});

function filterCP(filterbtn) {
  var postalCode = $('#postalCode').val();

  if (postalCode != '') {
    var action = 'getData';
    var data = {
      'action': action,
      'postalCode': postalCode,
      "_token": $("meta[name='csrf-token']").attr("content")
    };
    $.ajax({
      type: "POST",
      url: "/instituto_departamento",
      data: data
    }).done(function (response) {
      var communities = $('#communities_id');
      var municipalities = $('#municipalities_id');
      var states = $('#states_id');
      communities.find('option').remove();
      municipalities.find('option').remove();
      states.find('option').remove();
      communities.prop('disabled', false);
      $(response.communities).each(function (i, v) {
        // indice, valor
        communities.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
      $(response.municipalities).each(function (i, v) {
        // indice, valor
        municipalities.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
      $(response.states).each(function (i, v) {
        // indice, valor
        states.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
    }).fail(function () {
      console.log("error");
    }).always(function () {});
  }
}