"use strict";

// Colocar una nueva configuración default
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';
$(function () {
  'use strict';

  ShowGraph("myPieChart1", names1, data1, bgcolor1, hbgcolor1);
  ShowGraph("myPieChart2", names2, data2, bgcolor2, hbgcolor2);
  ShowGraph("myPieChart3", names3, data3, bgcolor3, hbgcolor3);
});

function ShowGraph(chartName, names, data, bgcolor, hbgcolor) {
  // Pie Chart Example
  var ctx = document.getElementById(chartName);
  var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: names,
      datasets: [{
        data: data,
        backgroundColor: bgcolor,
        hoverBackgroundColor: hbgcolor,
        hoverBorderColor: "rgba(234, 236, 244, 1)"
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10
      },
      legend: {
        display: false
      },
      cutoutPercentage: 80
    }
  });
}

$('#supports_id').change(function () {
  if ($(this).val() != '') {
    var support_id = $(this).val();
    var action = 'productsFilter';
    $.ajax({
      type: "POST",
      url: "reportes",
      data: {
        'action': action,
        'support_id': support_id,
        "_token": $("meta[name='csrf-token']").attr("content")
      }
    }).done(function (response) {
      console.log(response);
      var products = $('#products_id');
      products.prop('disabled', false);
      products.find('option').remove();
      products.append('<option value="0">Todos</option>');
      $(response).each(function (i, v) {
        // indice, valor
        products.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
    }).fail(function () {
      console.log("error");
    }).always(function () {});
  }
});
$('#catdisabilities_id').change(function () {
  if ($(this).val() != '') {
    var catdisabilities_id = $(this).val();
    var action = 'disabilityFilter';
    $.ajax({
      type: "POST",
      url: "reporte_discapacidades",
      data: {
        'action': action,
        'catdisabilities_id': catdisabilities_id,
        "_token": $("meta[name='csrf-token']").attr("content")
      }
    }).done(function (response) {
      console.log(response);
      var disabilities = $('#disability_id');
      disabilities.prop('disabled', false);
      disabilities.find('option').remove();
      disabilities.append('<option value="0">Todos</option>');
      $(response).each(function (i, v) {
        // indice, valor
        disabilities.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
    }).fail(function () {
      console.log("error");
    }).always(function () {});
  }
});
$('#categories_id').change(function () {
  if ($(this).val() != '') {
    var categories_id = $(this).val();
    var action = 'productFilter';
    $.ajax({
      type: "POST",
      url: "reporte_solicitudes",
      data: {
        'action': action,
        'categories_id': categories_id,
        "_token": $("meta[name='csrf-token']").attr("content")
      }
    }).done(function (response) {
      console.log(response);
      var products_id = $('#products_id');
      products_id.prop('disabled', false);
      products_id.find('option').remove();
      products_id.append('<option value="0">Todos</option>');
      $(response).each(function (i, v) {
        // indice, valor
        products_id.append('<option value="' + v.id + '">' + v.name + '</option>');
      });
    }).fail(function () {
      console.log("error");
    }).always(function () {});
  }
});

function getProducts() {}

function filterInformation() {
  // if ($(this).val() != '') {
  //     var curp = $(this).val();
  //     var action = 'check';
  //     $.ajax({
  //             type: "POST",
  //             url: "nueva_solicitud",
  //             data: { 'action': action, 'curp': curp, "_token": $("meta[name='csrf-token']").attr("content") }
  //         })
  //         .done(function(response) {
  //             if (response == "Ya existe un usuario con esa curp")
  //                 alertify.error(response);
  //             else
  //                 alertify.success(response);
  //         })
  //         .fail(function() {
  //             console.log("error");
  //         })
  //         .always(function() {})
  // }
  alert('You click on me');
}

function buscarInf() {
  var $tabla = $("#dataTable");
  $tabla.bootstrapTable({
    locale: "es-ES"
  });
  var action = 'search_disabilities';
  var from = $('#from').val();
  var until = $('#until').val();
  var catdisabilities_id = $('#catdisabilities_id').val();
  var disability_id = $('#disability_id').val();
  var area = $('#area').val();
  var date = new Date('Y-m-d');

  if (from == null || until == null) {
    $f1 = $date;
    $f2 = $date;
  } else {
    $f1 = from;
    $f2 = until;
  }

  $.ajax({
    type: "POST",
    url: "reporte_discapacidades",
    data: {
      'action': action,
      'from': $f1,
      'until': $f2,
      'catdisabilities_id': catdisabilities_id,
      'disability_id': disability_id,
      'area': area,
      "_token": $("meta[name='csrf-token']").attr("content")
    }
  }).done(function (response) {
    $tabla.bootstrapTable('showLoading');
    console.log({
      response: response
    });

    if (response.dataInformation.length > 0) {
      $tabla.bootstrapTable('destroy').bootstrapTable({
        height: 500,
        locale: "es-Es",
        data: response.dataInformation
      });
    }

    ShowGraph("myPieChart1", response.defaultNames1, response.defaultData1, response.defaultbgColor1, response.defaulthbgColor1);

    if (response.defaultLegend1.length != 0) {
      var legend1 = $('#legend1');
      legend1.find('span').remove();
      $(response.defaultLegend1).each(function (i, v) {
        // indice, valor
        legend1.append('<span class="mr-2"><i class="fas fa-circle" style="color:' + v.color + '"> </i>' + v.name + '</span>');
      });
    }

    ShowGraph("myPieChart2", response.defaultNames2, response.defaultData2, response.defaultbgColor2, response.defaulthbgColor2);

    if (response.defaultLegend2.length != 0) {
      var legend2 = $('#legend2');
      legend2.find('span').remove();
      $(response.defaultLegend2).each(function (i, v) {
        // indice, valor
        legend2.append('<span class="mr-2"><i class="fas fa-circle" style="color:' + v.color + '"> </i>' + v.name + '</span>');
      });
    }

    ShowGraph("myPieChart3", response.defaultNames3, response.defaultData3, response.defaultbgColor3, response.defaulthbgColor3);

    if (response.defaultLegend3.length != 0) {
      var legend3 = $('#legend3');
      legend3.find('span').remove();
      $(response.defaultLegend3).each(function (i, v) {
        // indice, valor
        legend3.append('<span class="mr-2"><i class="fas fa-circle" style="color:' + v.color + '"> </i>' + v.name + '</span>');
      });
    }
  }).fail(function (jqXHR, textStatus, errorThrown) {
    alert(jqXHR.responseText);
    console.log("Error: ".jqXHR.responseText);
  }).always(function () {
    $tabla.bootstrapTable('hideLoading');
  });
} //reporte_solicitudes


function buscarInfRequest() {
  var $tabla = $("#dataTable");
  $tabla.bootstrapTable({
    locale: "es-ES"
  });
  var action = 'search_requests';
  var from = $('#from').val();
  var until = $('#until').val();
  var type = $('#type').val();
  var categories_id = $('#categories_id').val();
  var products_id = $('#products_id').val();
  var area = $('#area').val();
  var date = new Date('Y-m-d');

  if (from == null || until == null) {
    $f1 = $date;
    $f2 = $date;
  } else {
    $f1 = from;
    $f2 = until;
  }

  $.ajax({
    type: "POST",
    url: "reporte_solicitudes",
    data: {
      'action': action,
      'from': $f1,
      'until': $f2,
      'type': type,
      'categories_id': categories_id,
      'products_id': products_id,
      'area': area,
      "_token": $("meta[name='csrf-token']").attr("content")
    }
  }).done(function (response) {
    $tabla.bootstrapTable('showLoading');
    console.log({
      response: response
    });

    if (response.dataInformation.length > 0) {
      $tabla.bootstrapTable('destroy').bootstrapTable({
        height: 500,
        locale: "es-Es",
        data: response.dataInformation
      });
    }

    ShowGraph("myPieChart1", response.defaultNames1, response.defaultData1, response.defaultbgColor1, response.defaulthbgColor1);

    if (response.defaultLegend1.length != 0) {
      var legend1 = $('#legend1');
      legend1.find('span').remove();
      $(response.defaultLegend1).each(function (i, v) {
        // indice, valor
        legend1.append('<span class="mr-2"><i class="fas fa-circle" style="color:' + v.color + '"> </i>' + v.name + '</span>');
      });
    }

    ShowGraph("myPieChart2", response.defaultNames2, response.defaultData2, response.defaultbgColor2, response.defaulthbgColor2);

    if (response.defaultLegend2.length != 0) {
      var legend2 = $('#legend2');
      legend2.find('span').remove();
      $(response.defaultLegend2).each(function (i, v) {
        // indice, valor
        legend2.append('<span class="mr-2"><i class="fas fa-circle" style="color:' + v.color + '"> </i>' + v.name + '</span>');
      });
    }

    ShowGraph("myPieChart3", response.defaultNames3, response.defaultData3, response.defaultbgColor3, response.defaulthbgColor3);

    if (response.defaultLegend3.length != 0) {
      var legend3 = $('#legend3');
      legend3.find('span').remove();
      $(response.defaultLegend3).each(function (i, v) {
        // indice, valor
        legend3.append('<span class="mr-2"><i class="fas fa-circle" style="color:' + v.color + '"> </i>' + v.name + '</span>');
      });
    }
  }).fail(function (jqXHR, textStatus, errorThrown) {
    alert(jqXHR.responseText);
    console.log("Error: ".jqXHR.responseText);
  }).always(function () {
    $tabla.bootstrapTable('hideLoading');
  });
}

function exportExcel() {
  var $tabla = $("#dataTable");
  $tabla.bootstrapTable({
    locale: "es-ES"
  });
  var from = $('#from').val();
  var until = $('#until').val();
  var catdisabilities_id = $('#catdisabilities_id').val();
  var disability_id = $('#disability_id').val();
  var area = $('#area').val();
  var action = 'export_excel';
  $.ajax({
    type: "POST",
    url: "reporte_discapacidades",
    data: {
      'action': action,
      'from': from,
      'until': until,
      'catdisabilities_id': catdisabilities_id,
      'disability_id': disability_id,
      'area': area,
      "_token": $("meta[name='csrf-token']").attr("content")
    }
  }).done(function (response) {
    console.log('entre');
  }).fail(function () {
    console.log("Error: ");
  }).always(function () {});
}

function exportPDF() {
  window.location.href = 'pdfexport/export_pdf'; // var from = $('#from').val();
  // var until = $('#until').val();
  // var catdisabilities_id = $('#catdisabilities_id').val();
  // var disability_id = $('#disability_id').val();
  // var area = $('#area').val();
  // var action = 'export_pdf';
  // $.ajax({
  //         type: "POST",
  //         url: "reporte_discapacidades",
  //         data: { 'action': action, 'from': from, 'until': until, 'catdisabilities_id': catdisabilities_id, 'disability_id': disability_id, 'area': area, "_token": $("meta[name='csrf-token']").attr("content") }
  //     })
  //     .done(function(response) {
  //     console.log(response);
  //     })
  //     .fail(function() {
  //         console.log("Error: ");
  //     })
  //     .always(function() {
  //     })
}

window.operateEvents = {
  'click .btnBuscar': function clickBtnBuscar() {
    window.location.href = 'reporte_discapacidades/';
  },
  'click .btnExcel': function clickBtnExcel() {
    window.location.href = 'reporte_discapacidades/';
  },
  'click .showDocument': function clickShowDocument(e, value, row, index) {
    window.location.href = 'verdocumento/' + row.id;
  } // 'click .btnPDF': function() {
  //     window.location.href = 'reporte_discapacidades/';
  // },

};